<?php

namespace admin\controllers;

use Yii;
use admin\models\Order;
use admin\models\AdminUser;
use common\helpers\Hui;
use common\helpers\Html;
use common\helpers\FileHelper;

class OrderController extends \admin\components\Controller
{
    /**
     * @authname 订单列表
     */
    public function actionList()
    {
        $query = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->manager()->orderBy('order.id DESC');
        $countQuery = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->manager();

        // 今日盈亏统计，交易额、手数
        $profit = $countQuery->andWhere(['order.order_state' => Order::ORDER_THROW])->select('SUM(order.profit) profit')->one()->profit ?: 0 ;
        $amount = $countQuery->select('SUM(order.deposit) deposit')->one()->deposit ?: 0;
        $hand = $countQuery->select('SUM(order.hand) hand')->one()->hand ?: 0;
        $fee = $countQuery->select('SUM(order.fee) fee')->one()->fee ? : 0;

        $html = $query->getTable([
            'user.id',
            'user.nickname',
            'parent.nickname' => ['header' => '推荐人昵称'],
            'admin.id' => ['header' => '后台经纪人', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                return $row->user->admin->power == AdminUser::POWER_RING ? $row->user->admin->username : '无';
            }],
            'admin.username' => ['header' => '机构', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                if ($row->user->admin->power == AdminUser::POWER_MEMBER) {
                    return $row->user->admin->username;
                } else {
                    return AdminUser::findOne($row->user->admin->pid)->username;
                }
            }],
            'admin.power' => ['header' => '会员', 'value' => function ($row) {
                $id = AdminUser::findOne($row->user->admin->pid)->pid;
                return AdminUser::findOne($id)->username;
            }],
            'product.name',
            'created_at',
            'updated_at' => function ($row) {
                return $row['order_state'] == Order::ORDER_POSITION ? '' : $row['updated_at'];
            },
            'rise_fall' => ['header' => '涨跌', 'value' => function ($row) {
                return $row['rise_fall'] == Order::RISE ? Html::redSpan('买涨') : Html::greenSpan('买跌');
            }],
            'price',
            'sell_price' => function ($row) {
                if ($row['order_state'] == Order::ORDER_POSITION) {
                    return '';
                } else {
                    if ($row['price'] < $row['sell_price']) {
                        return Html::redSpan($row['sell_price']);
                    } else {
                        return Html::greenSpan($row['sell_price']);
                    }
                }
            },
            'fee',
            'hand' => ['header' => '持仓手数'],
            'deposit',
            'profit' => function ($row) {
                return $row['profit'] >= 0 ? Html::redSpan($row['profit']) : Html::greenSpan($row['profit']);
            },
            // 'risk'=> ['header' => '风险率', 'value' => function($row){
            //     $risk = $row->profit > 0 ? $row->deposit : $row->deposit + $row->profit;
            //     $risks =  $risk / $row->deposit >= 0 ? Html::redSpan($risk / $row->deposit * 100 . '%') : Html::greenSpan($risk / $row->deposit * 100 . '%');
            //     return $risks;
            // }],
            'order_state',
            ['type' => [], 'value' => function ($row) {
                // return $row['order_state'] == Order::ORDER_POSITION ? Hui::warningBtn('平仓', ['order/sellOrder', 'id' => $row['id']], ['class' => 'sellOrderBtn']) : '';
                if (u()->power >= AdminUser::POWER_ADMIN && $row['order_state'] == Order::ORDER_POSITION) {
                    return Hui::primaryBtn('平仓', ['sellOrder', 'id' => $row['id']], ['class' => 'sellOrder']);
                }
            }]
            // ['header' => '操作', 'width' => '60px', 'value' => function ($row) {
            //     if ($row->sign_state == Order::SIGN_NO) {
            //         $text = '未标记';
            //     } else {
            //         $text = $row->sign_state == Order::SIGN_WIN?'标记赢':'标记亏';
            //     }
            //     if ($row->order_state == Order::ORDER_POSITION) {
            //         return Hui::primaryBtn($text, ['editSign', 'id' => $row->id], ['class' => 'signBtn']);
            //     }
            //     return $text;
            // }]
            // ['type' => [], 'value' => function ($row) {
            //     return $row['order_state'] == Order::ORDER_POSITION ? Hui::warningBtn('平仓', ['order/sellOrder', 'id' => $row['id']], ['class' => 'sellOrderBtn']) : '';
            // }]
        ], [
            'ajaxReturn' => [
                'countProfit' => '盈亏统计：' . ($profit >= 0 ? Html::redSpan($profit) : Html::greenSpan($profit)) . '，',
                'countAmount' => $amount,
                'countHand' => $hand,
                'countFee' => $fee
            ],
            'searchColumns' => [
                'user.id' => ['header' => '用户id'],
                // 'user.pid' => ['header' => '推荐人id'],
                'parent.nickname' => ['header' => '推荐人昵称'],
                'ringname' => ['header' => '后台经纪人'],
                'membername' => ['header' => '机构'],
                'operate' => ['header' => '会员'],
                'product_name' => ['type' => 'select', 'header' => '选择产品'],
                'user.nickname' => ['header' => '昵称'],
                'user.mobile',
                'time' => 'timeRange',
                'is_profit' => ['type' => 'select', 'header' => '是否盈亏'],
                'order_state' => 'select'
            ]
        ]);

        return $this->render('list', compact('html', 'profit', 'amount', 'hand', 'fee'));
    }

    /**
     * @authname 订单信息导出
     */
    public function actionOrderExcel()
    {
        ini_set("memory_limit", "10000M");
        set_time_limit(0);
        require Yii::getAlias('@vendor/PHPExcel/Classes/PHPExcel.php');
        //获取数据
        $query = (new Order)->listQuery()->joinWith(['product', 'user', 'user.parent'])->manager();
        // $count = (new User)->listQuery()->manager()->count();
        $data = $query->all();

        $n = 3;
        //加载PHPExcel插件
        $Excel = new \PHPExcel();
        $Excel->setActiveSheetIndex(0);
        //编辑表格    标题
        $Excel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $Excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $Excel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(20);
        $Excel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setName('黑体');
        $Excel->getActiveSheet()->setCellValue('A1',config('web_name').'-订单信息统计表');
        //表头
        $Excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        $Excel->setActiveSheetIndex(0)->getStyle('A2:G2')->getFont()->setBold(true);
        $Excel->setActiveSheetIndex(0)->setCellValue('A2','用户的ID');
        $Excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $Excel->setActiveSheetIndex(0)->setCellValue('B2','昵称');
        $Excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('C2','推荐人昵称');
        $Excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('D2','产品名称');
        $Excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $Excel->setActiveSheetIndex(0)->setCellValue('E2','下单时间');
        $Excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('F2','涨跌');
        $Excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('G2','买入价');
        $Excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('H2','卖出价格');
        $Excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('I2','手续费');
        $Excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $Excel->setActiveSheetIndex(0)->setCellValue('J2','保证金');
        $Excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);        
        $Excel->setActiveSheetIndex(0)->setCellValue('K2','盈亏');
        $Excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);        
        $Excel->setActiveSheetIndex(0)->setCellValue('L2','持仓状态');
        $Excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $filePath = Yii::getAlias('@webroot' . config('uploadPath') . '/excel/U' . u()->id . '/');
        FileHelper::mkdir($filePath);
        $num = 1;
        $m = 1;
        //内容
        foreach ($data as $val) {
            $Excel->setActiveSheetIndex(0)->setCellValue('A'.$n, $val->id);
            if (strpos($val['user']['nickname'], '=') === 0){
                $val['user']['nickname'] = "nanqe" . $val['user']['nickname'];
            }
            // test($val);
            $Excel->setActiveSheetIndex(0)->setCellValue('B'.$n, $val['user']['nickname']);
            $Excel->setActiveSheetIndex(0)->setCellValue('C'.$n, $val->user['parent']['nickname']);
            $Excel->setActiveSheetIndex(0)->setCellValue('D'.$n, $val['product']['name']);
            $Excel->setActiveSheetIndex(0)->setCellValue('E'.$n, $val->created_at);
            $Excel->setActiveSheetIndex(0)->setCellValue('F'.$n, $val->getRiseFallValue($val->rise_fall));
            $Excel->setActiveSheetIndex(0)->setCellValue('G'.$n, $val->price);
            $Excel->setActiveSheetIndex(0)->setCellValue('H'.$n, $val->sell_price);
            $Excel->setActiveSheetIndex(0)->setCellValue('I'.$n, $val->fee);
            $Excel->setActiveSheetIndex(0)->setCellValue('J'.$n, $val->deposit);
            $Excel->setActiveSheetIndex(0)->setCellValue('K'.$n, $val->profit);
            $Excel->setActiveSheetIndex(0)->setCellValue('L'.$n, $val->getOrderStateValue($val->order_state));
            $n++;
            $Excel->getActiveSheet()->getRowDimension($n+1)->setRowHeight(18);
            if ($m != 0 && $m % 1000 == 0) {
                //保存到服务器
                $filename = $filePath . $num . '.xls';
                $fp = fopen($filename, 'w+'); 
                if (!is_writable($filename) ){ 
                    die('文件:' . $filename . '不可写，请检查！'); 
                } 
                $objWriter= \PHPExcel_IOFactory::createWriter($Excel,'Excel5');
                $objWriter->save($filename);
                fclose($fp);
                $num++;
                $n = 3;
                $Excel = new \PHPExcel();
                $Excel->setActiveSheetIndex(0);
                //编辑表格    标题
                $Excel->setActiveSheetIndex(0)->mergeCells('A1:G1');
                $Excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $Excel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(20);
                $Excel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setName('黑体');
                $Excel->getActiveSheet()->setCellValue('A1',config('web_name').'-用户信息统计表');
                //表头
                $Excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
                $Excel->setActiveSheetIndex(0)->getStyle('A2:G2')->getFont()->setBold(true);
                $Excel->setActiveSheetIndex(0)->setCellValue('A2','用户的ID');
                $Excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $Excel->setActiveSheetIndex(0)->setCellValue('B2','昵称');
                $Excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('C2','推荐人昵称');
                $Excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('D2','产品名称');
                $Excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $Excel->setActiveSheetIndex(0)->setCellValue('E2','下单时间');
                $Excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('F2','涨跌');
                $Excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('G2','买入价');
                $Excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('H2','卖出价格');
                $Excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('I2','手续费');
                $Excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $Excel->setActiveSheetIndex(0)->setCellValue('J2','保证金');
                $Excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);        
                $Excel->setActiveSheetIndex(0)->setCellValue('K2','盈亏');
                $Excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);        
                $Excel->setActiveSheetIndex(0)->setCellValue('L2','持仓状态');
                $Excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
            }
            $m++;
        }
        $filename = $filePath . $num . '.xls';
        $fp = fopen($filename, 'w+'); 
        if (!is_writable($filename)) { 
            die('文件:' . $filename . '不可写，请检查！'); 
        } 
        $objWriter= \PHPExcel_IOFactory::createWriter($Excel, 'Excel5');
        $objWriter->save($filename);
        fclose($fp);
        //压缩下载
        require Yii::getAlias('@vendor/PHPZip/PHPZip.php');
        $filePath = Yii::getAlias('@webroot' . config('uploadPath') . '/excel/U' . u()->id . '/');
        $archive = new \PHPZip();
        $archive->ZipAndDownload($filePath, config('web_name').'-订单信息统计表');
        deleteDir($filePath);
        //统计
        // $Excel->setActiveSheetIndex(0)->mergeCells('A'.$n.':G'.$n);
        // $Excel->getActiveSheet()->setCellValue('A'.$n,'统计'.$count.'人');
        // $Excel->setActiveSheetIndex(0)->getStyle('A'.$n)->getFont()->setBold(true);
        // //格式
        // $Excel->getActiveSheet()->getStyle('A2:G'.$n)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        // //导出表格
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition:attachment;filename="'.config('web_name').'-用户信息统计表.xls');
        // header('Cache-Control: max-age=0');
        // $objWriter= \PHPExcel_IOFactory::createWriter($Excel,'Excel5');
        // $objWriter->save('php://output');
    }

//    /**
//     * @authname 手动平仓
//     */
//    public function actionSellOrder()
//    {
//        $id = get('id');
//
//        if (Order::sellOrder($id)) {
//            return success('成功平仓');
//        } else {
//            return error('此单已平');
//        }
//    }
    /**
     * @authname 手动平仓
     */
    public function actionSellOrder()
    {
        $id = get('id');
        $price = post('price');
        if ($price < 0 || !is_numeric($price)) {
            return error('价格数据非法！');
        }
        if (Order::sellOrder($id, false, $price)) {
            return success('成功平仓');
        } else {
            return error('此单已平');
        }
    }

    /**
     * @authname 手动标记风控
     */
    public function actionEditSign()
    {
        $id = get('id');
        $order = Order::findOne($id);
        if (!empty($order)) {
            switch (post('sign')) {
                case '盈':
                    $order->sign_state = Order::SIGN_WIN;
                    break;

                case '亏':
                    $order->sign_state = Order::SIGN_FAIL;
                    break;

                case '取消':
                    $order->sign_state = Order::SIGN_NO;
                    break;
                
                default:
                    return error('请输入盈、亏、取消中的三种，不要输入其它内容！');
                    break;
            }
            $order->update();
            return success('修改成功!');
        } else {
            return error('数据非法');
        }
    }

    /**
     * @authname 持仓订单
     */
    public function actionPosition()
    {
        $query = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->andWhere(['order.order_state' => Order::ORDER_POSITION])->manager()->orderBy('order.id DESC');
        $countQuery = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->andWhere(['order.order_state' => Order::ORDER_POSITION])->manager();

        // 今日盈亏统计，交易额、手数
        $profit = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.profit) profit')->one()->profit ?: 0 ;
        $amount = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.deposit) deposit')->one()->deposit ?: 0;
        $hand = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.hand) hand')->one()->hand ?: 0;
        $fee = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.fee) fee')->one()->fee ? : 0;

        $html = $query->getTable([
            'user.id',
            'user.nickname',
            'parent.nickname' => ['header' => '推荐人昵称'],
            'admin.id' => ['header' => '后台经纪人', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                return $row->user->admin->power == AdminUser::POWER_RING ? $row->user->admin->username : '无';
            }],
            'admin.username' => ['header' => '机构', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                if ($row->user->admin->power == AdminUser::POWER_MEMBER) {
                    return $row->user->admin->username;
                } else {
                    return AdminUser::findOne($row->user->admin->pid)->username;
                }
            }],
            'admin.power' => ['header' => '会员', 'value' => function ($row) {
                $id = AdminUser::findOne($row->user->admin->pid)->pid;
                return AdminUser::findOne($id)->username;
            }],
            'product.name',
            'created_at',
            'rise_fall' => ['header' => '涨跌', 'value' => function ($row) {
                return $row['rise_fall'] == Order::RISE ? Html::redSpan('买涨') : Html::greenSpan('买跌');
            }],
            'price',
            'fee',
            'hand' => ['header' => '持仓手数'],
            'deposit',
            'profit' => function ($row) {
                return $row['profit'] >= 0 ? Html::redSpan($row['profit']) : Html::greenSpan($row['profit']);
            },
            // 'risk'=> ['header' => '风险率', 'value' => function($row){
            //     $risk = $row->profit > 0 ? $row->deposit : $row->deposit + $row->profit;
            //     $risks =  $risk / $row->deposit >= 0 ? Html::redSpan($risk / $row->deposit * 100 . '%') : Html::greenSpan($risk / $row->deposit * 100 . '%');
            //     return $risks;
            // }],
            'order_state',
        ], [
            'ajaxReturn' => [
                'countProfit' => '盈亏统计：' . ($profit >= 0 ? Html::redSpan($profit) : Html::greenSpan($profit)) . '，',
                'countAmount' => $amount,
                'countHand' => $hand,
                'countFee' => $fee
            ],
            'searchColumns' => [
                'user.id' => ['header' => '用户id'],
                'parent.nickname' => ['header' => '推荐人昵称'],
                'ringname' => ['header' => '后台经纪人'],
                'membername' => ['header' => '机构'],
                'operate' => ['header' => '会员'],
                'product_name' => ['type' => 'select', 'header' => '选择产品'],
                'user.nickname' => ['header' => '昵称'],
                'user.mobile',
                'time' => 'timeRange',
                'is_profit' => ['type' => 'select', 'header' => '是否盈亏'],
            ]
        ]);

        return $this->render('position', compact('html', 'profit', 'amount', 'hand', 'fee'));
    }

    /**
     * @authname ajax实时获取持仓数据
     */
    public function actionAjaxPosition()
    {
        $query = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->andWhere(['order.order_state' => Order::ORDER_POSITION])->manager()->orderBy('order.id DESC');
        $countQuery = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->andWhere(['order.order_state' => Order::ORDER_POSITION])->manager();

        // 今日盈亏统计，交易额、手数
        $profit = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.profit) profit')->one()->profit ?: 0 ;
        $amount = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.deposit) deposit')->one()->deposit ?: 0;
        $hand = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.hand) hand')->one()->hand ?: 0;
        $fee = $countQuery->andWhere(['order.order_state' => Order::ORDER_POSITION])->select('SUM(order.fee) fee')->one()->fee ? : 0;

        $html = $query->getTable([
            'user.id',
            'user.nickname',
            'parent.nickname' => ['header' => '推荐人昵称'],
            'admin.id' => ['header' => '后台经纪人', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                return $row->user->admin->power == AdminUser::POWER_RING ? $row->user->admin->username : '无';
            }],
            'admin.username' => ['header' => '机构', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                if ($row->user->admin->power == AdminUser::POWER_MEMBER) {
                    return $row->user->admin->username;
                } else {
                    return AdminUser::findOne($row->user->admin->pid)->username;
                }
            }],
            'admin.power' => ['header' => '会员', 'value' => function ($row) {
                $id = AdminUser::findOne($row->user->admin->pid)->pid;
                return AdminUser::findOne($id)->username;
            }],
            'product.name',
            'created_at',
            'rise_fall' => ['header' => '涨跌', 'value' => function ($row) {
                return $row['rise_fall'] == Order::RISE ? Html::redSpan('买涨') : Html::greenSpan('买跌');
            }],
            'price',
            'fee',
            'hand' => ['header' => '持仓手数'],
            'deposit',
            'profit' => function ($row) {
                return $row['profit'] >= 0 ? Html::redSpan($row['profit']) : Html::greenSpan($row['profit']);
            },

            'order_state',
        ], [
            'ajaxReturn' => [
                'countProfit' => $profit >= 0 ? Html::redSpan($profit) : Html::greenSpan($profit),
                'countAmount' => $amount >= 0 ? Html::redSpan($amount, ['class' => 'countAmount']) : Html::greenSpan($amount, ['class' => 'countAmount']),
                'countHand' => $hand >= 0 ? Html::redSpan($hand, ['class' => 'countHand']) : Html::greenSpan($hand, ['class' => 'countHand']),
                'countFee' => $fee >= 0 ? Html::redSpan($fee, ['class' => 'countFee']) : Html::greenSpan($fee, ['class' => 'countFee'])
            ],
            'searchColumns' => [
                'user.id' => ['header' => '用户id'],
                'parent.nickname' => ['header' => '推荐人昵称'],
                'ringname' => ['header' => '后台经纪人'],
                'membername' => ['header' => '机构'],
                'operate' => ['header' => '会员'],
                'product_name' => ['type' => 'select', 'header' => '选择产品'],
                'user.nickname' => ['header' => '昵称'],
                'user.mobile',
                'time' => 'timeRange',
                'is_profit' => ['type' => 'select', 'header' => '是否盈亏'],
            ]
        ]);
        return $this->renderPartial('_positionList', compact('html', 'profit', 'amount', 'hand', 'fee'));
    }
    public function actionCurrentList()
    {
        $map = ['order.order_state' => Order::ORDER_POSITION];
        $query = (new Order)->listQuery()->joinWith(['product.dataAll', 'user.parent', 'user.admin'])->manager()->filterWhere($map)->orderBy('order.id DESC')->paginate(false);
        $html = $query->getTable([
            'user.id',
            'user.nickname',
            'parent.nickname' => ['header' => '推荐人昵称'],
            'admin.id' => ['header' => '后台经纪人', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                return $row->user->admin->power == AdminUser::POWER_RING ? $row->user->admin->username : '无';
            }],
            'admin.username' => ['header' => '机构', 'value' => function ($row) {
                if (!isset($row->user->admin->power)) {
                    return '';
                }
                if ($row->user->admin->power == AdminUser::POWER_MEMBER) {
                    return $row->user->admin->username;
                } else {
                    return AdminUser::findOne($row->user->admin->pid)->username;
                }
            }],
            'admin.power' => ['header' => '会员', 'value' => function ($row) {
                $id = AdminUser::findOne($row->user->admin->pid)->pid;
                return AdminUser::findOne($id)->username;
            }],
            'product.name',
            'created_at',
            'updated_at' => function ($row) {
                return $row['order_state'] == Order::ORDER_POSITION ? '' : $row['updated_at'];
            },
            'rise_fall' => ['header' => '涨跌', 'value' => function ($row) {
                return $row['rise_fall'] == Order::RISE ? Html::redSpan('买涨') : Html::greenSpan('买跌');
            }],
            'price',
            'sell_price' => function ($row) {
                if ($row['order_state'] == Order::ORDER_POSITION) {
                    return '';
                } else {
                    if ($row['price'] < $row['sell_price']) {
                        return Html::redSpan($row['sell_price']);
                    } else {
                        return Html::greenSpan($row['sell_price']);
                    }
                }
            },
            'fee',
            'hand' => ['header' => '持仓手数'],
            'deposit',
            'profit' => function ($row) {
                return $row['profit'] >= 0 ? Html::redSpan($row['profit']) : Html::greenSpan($row['profit']);
            },

            'order_state',
        ]);


        return $html;
    }

}
