<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\userExtend;
use frontend\models\UserWithdraw;
use frontend\models\UserCharge;
use common\helpers\FileHelper;
use frontend\models\Product;
use frontend\models\Order;
use frontend\models\ProductPrice;
use frontend\models\Coupon;
use frontend\models\UserPrize;
use frontend\models\Prize;
use frontend\models\Bank;
use frontend\models\UserMedal;
use frontend\models\RingWechat;
use frontend\models\UserCoupon;
use frontend\models\BankCard;
use frontend\models\BankCode;
use frontend\models\DataAll;
use frontend\models\UserAccount;

class UserController extends \frontend\components\Controller
{
    public function beforeAction($action)
    {
        if (user()->isGuest && !in_array($this->action->id, ['ajax-adress'])) {
            $this->redirect(['site/login']);
            return false;
            // $wx = session('wechat_userinfo');
            // if (!empty($wx)) {
            //     $user = User::find()->where(['open_id' => $wx['openid']])->one();
            //     $user->login(false);
            // } else {
            //     $code = get('code');
            //     if (empty($code)) {
            //         $this->redirect(['/wechart.php']);
            //         return false;
            //     } else {
            //         User::registerUser($code);
            //     }
            // }
        }
        if (!parent::beforeAction($action)) {
            return false;
        } else {
            return true;
        }
    }


    // 修改交易密码
    public function actionModify()
    {
        $this->view->title = '修改交易密码';
        return $this->render('modify');
    }

    
    /**
     * @authname  个人中心
     */
    public function actionIndex()
    {
//        $this->redirect('/site/my');
        $this->view->title = '我的个人中心';

        $user = User::findModel(u()->id);
        $manager = '申请经纪人';
        $urls = url('manager/register');
        //如果是经纪人
        if ($user->is_manager == User::IS_MANAGER_YES) {
            $manager = '我是经纪人';
            $urls = url('manager/index');
        }

        $count = UserCoupon::getAllUserCouponCount();
        
        return $this->render('index', compact('user', 'manager', 'urls', 'count'));
    }
    
    /**
     * @authname  个人中心
     */
    public function actionAjaxAdress()
    {
        $data = post();
        if (empty($data['openBank'])) { //openProv] => 广东
            return error();
        }
        $openCity = str_replace('市', '', $data['openCity']);
        $bankCode = BankCode::find()->where(['aa' => $data['openBank']])->andWhere(['like', 'name', $openCity])->andWhere(['like', 'name', $data['inp']])->map('id', 'name');
        if (empty($bankCode)) {
            return error();
        }
        return success($bankCode);
    }

    public function actionWithDraw()
    {
        $this->view->title = '提现';
        // $this->layout = 'empty';
        $model = User::findModel(u()->id);
        $userAccount = UserAccount::find()->where(['user_id' => u()->id])->one();
        if (empty($userAccount)) {
            $userAccount = new UserAccount();
        }

        $userWithdraw = new UserWithdraw(['scenario' => 'withdraw']);
        if ($userWithdraw->load(post())) {
            if (date('w') == 0 || date('w') == 6) {
                return error('请在规定时间提现'); 
            }
            $userWithdraws = UserWithdraw::find()->where(['user_id' => u()->id])->andWhere(['>', 'created_at', date('Y-m-d 00:00:00', time())])->andWhere(['<>', 'op_state', UserWithdraw::OP_STATE_DENY])->select('SUM(amount) amount')->one()->amount;
            $maxMoney = config('web_out_max_money', 20000);
            if($userWithdraws > $maxMoney) {
                return error('单日提现累计不能超过' . $maxMoney);
            }
            if($model->account < 0 || $model->blocked_account < 0 || $model->state == User::STATE_INVALID) {
                return error('您的账户暂时不能提现');
            }
            if (!$userWithdraw->validate()) {
                return error($userWithdraw);
            }
            $userAccount->load(post());
            $bank = Bank::find()->where(['number' => $userAccount->bank_name])->one();
            if (empty($bank)) {
               return error('找不到这个银行名称！'); 
            }
            $bank_code = BankCode::findOne($userAccount->address);
            if(empty($bank_code)) {
                return error('支行名称有误！');
            }
            
            $userAccount->bank_areacode = $bank_code->settAreaCode;
            $userAccount->city = trim(str_replace('市', '', $userAccount->city));
            $userAccount->bank_address = $bank_code->name;
            $userAccount->bank_type = $bank_code->bankno;
            $userAccount->realname = $userAccount->bank_user;
            $userAccount->bank_mobile = '181';//u()->mobile;
            $userAccount->id_card = 'xx';
            $userAccount->user_id = u()->id;
            //用户账户表处理
            $userAccount->scenario = 'withDraw';
            if ($userAccount->validate()) {
                $userAccount->save();

                $userWithdraw->trade_no = u()->id . date("YmdHis") . rand(1000, 9999);
                $userWithdraw->user_id = u()->id;
                $userWithdraw->account_id = $userAccount->id;
                if ($userWithdraw->insert(false)) {
                    $model->account -= $userWithdraw->amount + config('web_out_money_fee', 2); 
                    $model->save(false);
                    return success('提交申请成功');
                }
            } else {
                return error($userAccount);
            }
        }

        return $this->render('withDraw', compact('userAccount', 'userWithdraw', 'model'));
    }

    /**
     * @authname  交易记录界面
     */
    public function actionTransDetail()
    {
        $this->view->title = '交易记录';
        // $this->layout = 'empty';
        $query = Order::find()->where(['order_state' => Order::ORDER_THROW, 'user_id' => u()->id])->with('product')->orderBy('order.updated_at DESC');
        // 每页显示3条
        $data = $query->paginate(5);
        // 查询总数量
        $count = $query->totalCount;
        // 总共多少页
        $pageCount = $count / 5;
        // 判断是不是整数
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        // 点击加载更多显示的页面
        if (get('p')) {

            return success($this->renderPartial('_transDetail', compact('data')), $pageCount);
        }
        return $this->render('transDetail', compact('count', 'pageCount', 'data'));
    }

    /**
     * @authname  提现记录界面
     */
    public function actionWithDrawLists()
    {
        $this->view->title = '提现记录';
        // $this->layout = 'empty';
        $query = UserWithdraw::find()->where(['user_id' => u()->id])->orderBy('created_at DESC');
        // 每页显示3条
        $data = $query->paginate(PAGE_SIZE);
        // 查询总数量
        $count = $query->totalCount;
        // 总共多少页
        $pageCount = $count / PAGE_SIZE;
        // 判断是不是整数
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        // 点击加载更多显示的页面
        if (get('p')) {

            return success($this->renderPartial('_withDrawLists', compact('data')), $pageCount);
        }
        return $this->render('withDrawLists', compact('count', 'pageCount', 'data'));
    }
      /**
     * @authname  我的账单页面
     */
    public function actionMyBill()
    {
        $this->view->title = '我的账单';
        $this->layout = 'empty';
        // 查询信息
        $query = UserCharge::find()->where(['charge_state' => UserCharge::CHARGE_STATE_PASS, 'user_id' => u()->id])->orderBy('created_at DESC');
        // 每页显示3条
        $data = $query->paginate(5);
        // 查询总数量
        $count = $query->totalCount;
        // 总共多少页
        $pageCount = $count / 5;
        // 判断是不是整数
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        if (get('p')) {

            return success($this->renderPartial('_myBill', compact('data')), $pageCount);
        }
        return $this->render('myBill', compact('count', 'pageCount', 'data'));
    }
    public function actionOutMoney()
    {
        $this->view->title = '出金记录';

        $query = UserWithdraw::find()->where(['user_id' => u()->id])->orderBy('created_at DESC');
        $data = $query->paginate(5);
        $pageCount = $query->totalCount / 5;
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        if (get('p')) {

            return success($this->renderPartial('_outMoney', compact('data')), $pageCount);

        }

        return $this->render('outMoney', compact('count', 'pageCount', 'data'));
    }

    public function actionLotteryRecord()
    {
        $this->view->title = '抽奖记录';
        $query = UserPrize::find()->joinWith(['prize'])->where(['user_id' => u()->id])->orderBy('userPrize.state');

        $data = $query->paginate(PAGE_SIZE);
        $pageCount = $query->totalCount / PAGE_SIZE;
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        if (get('p') > 1) {
            return success($this->renderPartial('_lotteryRecord', compact('data'), $pageCount));
        }
        return $this->render('lotteryRecord', compact('data', 'pageCount'));
    }

    /**
     * @authname 抽奖赠送代金券
     */
    
     public function actionGiveCoupon()
     {
        $data = post('data');
        $prize = Prize::find()->where(['prizes_id' => $data['pid']])->one();
        if($data['pid'] == 6) {
            $userMedal = new UserMedal;
            $userMedal->user_id = u()->id;
            $userMedal->number = $prize->prize_num;
            $userMedal->insert(false);
        }else {
            UserCoupon:: sendCoupon(u()->id, 1, $prize->prize_num);
        }
        $userPrize = UserPrize::find()->where(['id' => $data['uid']])->one();
        $userPrize->state = UserPrize::STATE_VALID;
        $userPrize->save(false);
        return success('领取成功');

     }

    public function actionSetting()
    {
        $this->view->title = '个人设置';
        return $this->render('setting');
    }

    //个人名片
    public function actionMyCallingCard()
    {
        $this->view->title = '个人名片';

        return $this->render('myCallingCard');
    }


    //个人设置
    public function actionUserConf()
    {
        $this->view->title = '个人设置';

        return $this->render('userConf');
    }

    //修改密码
    public function actionModifyPwd()
    {
        $this->view->title = '修改密码';
        $model = User::findOne(u('id'));
        $model->scenario = 'password';
        if ($model->load($_POST)) {
            if ($model->validate()) {
                $model->password = $model->newPassword;
                if ($model->hashPassword()->update()) {
                    return $this->redirect(['index']);
                } else {
                    return error($model);
                }
            } else {
                return error($model);
            }
        }

        return $this->render('modifyPwd',  compact('model'));
    }
    //修改电话
    public function actionModifyPhone()
    {
        $this->view->title = '修改手机号';
        $model = User::findModel(u()->id);
        $model->scenario = 'setMobile';
        if ($model->load(post())) {
            if ($model->verifyCode != session('verifyCode') || empty($model->verifyCode)) {
                return error('短信验证码不正确');
            }
            if ($model->validate()) {
                $model->username = $model->mobile;
                if ($model->update()) {
                    return $this->redirect(['user/index']);
                } else {
                    return error($model);
                }
            } else {
                return error($model);
            }
        }
        $model->mobile = null;
        return $this->render('modifyPhone', compact('model'));
    }




    public function actionMaintain()
    {
        $this->view->title = '维护中';
        $this->layout = 'empty';
        return $this->render('/site/maintain');
    }


    /**
     * @authname 绑定银行卡
     */
    public function actionBankCard()
    {
        $bankCard = BankCard::find()->where(['user_id' => u()->id])->one();
        if (empty($bankCard)) {
            $bankCard = new BankCard;
        }
        // test(u()->id);
        $bankCard->scenario = 'bank';
        // $this->layout = 'empty';
        if($bankCard->load(post())) {
            if ($bankCard->validate()) {
                $bankCard->user_id = u()->id;
                if ($bankCard->id) {
                    $bankCard->update();
                } else {
                    $bankCard->insert(false);
                }
                return success('绑定成功');
                // $charge = UserCharge::epayBankCard($bankCard);
                // if($charge) {
                // }else {
                    // return error('绑定失败，请确认您的信息是否正确');
                // }
            } else {
                return error($bankCard);
            }         
        }
        return $this->render('bankCard', compact('bankCard'));
    }

    public function actionMyOffline()
    {
        $this->view->title = '名下用户记录';
        //如果是经纪人
        if (u()->is_manager != User::IS_MANAGER_YES) {
            return $this->redirect('/site/wrong');
        }
        //名下的用户
        $idArr = User::getUserOfflineId();
        $idArr = array_merge($idArr[0], $idArr[1]);
        $query = User::find()->where(['state' => User::STATE_VALID])->andWhere(['in', 'id', $idArr])->orderBy('created_at DESC');
        $data = $query->paginate(PAGE_SIZE);

        return $this->render('myOffline', compact('data'));
    }


    //请求更新订单钱数
    public function actionAjaxUpdateCharge()
    {
        $data = post('data');
        if (is_int($data['amount']) || $data['amount'] <= 0) {
            return error('金额参数非法！');
        }
        $userCharge = UserCharge::find()->where(['charge_state' => UserCharge::CHARGE_STATE_WAIT, 'user_id' => u()->id, 'id' => $data['id']])->one();
        if (!empty($userCharge)) {
            $userCharge->amount = floatval($data['amount']);
            $userCharge->trade_no = u()->id . date("YmdHis") . rand(1000, 9999);
            if ($userCharge->save()) {
                return success(1);
                //微信生成订单
                require Yii::getAlias('@vendor/WxPayPubHelper/WxPayPubHelper.php');
                $jsApi = new \JsApi_pub();
                $openid = u()->open_id;
                $unifiedOrder = new \UnifiedOrder_pub();
                $unifiedOrder->setParameter("openid", $openid);//商品描述
                $unifiedOrder->setParameter("body", "微盘充值");//商品描述
                $unifiedOrder->setParameter("out_trade_no", $userCharge->trade_no);//商户订单号
                $unifiedOrder->setParameter("total_fee", $userCharge->amount * 100);//总金额
                $unifiedOrder->setParameter("notify_url", "http://" . $_SERVER['HTTP_HOST'] . "/site/ajax-update-status");//通知地址
                $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
                $prepay_id = $unifiedOrder->getPrepayId();
                $jsApi->setPrepayId($prepay_id);
                $jsApiParameters = $jsApi->getParameters();
                return success($jsApiParameters);
            }
        }
        return error('数据异常！');
    }

    public function actionTt()//测试充值
    {
        $data = post('data');
        $userCharge = UserCharge::find()->where(['charge_state' => UserCharge::CHARGE_STATE_WAIT, 'user_id' => u()->id, 'id' => $data['id']])->one();
        if (!empty($userCharge)) {
            // test($userCharge->amount);
            $userCharge->charge_state = 2;
            if ($userCharge->save()) {
                $user = User::findOne($userCharge->user_id);
                $user->account += $userCharge->amount;
                if ($user->save()) {
                    return success('成功');
                }
            } else {
                return error($userCharge);
            }
        }
        return error('失败！');
    }

    public function actionWrong()
    {
        $this->view->title = '错误';
        return $this->render('wrong');
    }
    /**
     * @authname  代金券
     */
    public function actionCoupon()
    {
        $this->view->title = '代金券';
        $userCoupons = UserCoupon::find()->andWhere(['use_state' => UserCoupon::USE_STATE_WAIT, 'user_id' => u()->id])->andWhere(['>', 'number', 0])->andWhere(['>', 'valid_time', self::$time])->joinWith(['coupon'])->orderBy('amount ASC')->all();
        return $this->render('coupon', compact('userCoupons'));
    }



    public function actionOrder()
    {
        $this->view->title = '账单';
        $query = UserCharge::find()->where(['user_id' => u()->id, 'charge_state' => UserCharge::CHARGE_STATE_PASS]);
        // 每页显示3条
        $data = $query->paginate(PAGE_SIZE);
        // 查询总数量
        $count = $query->totalCount;
        // 总共多少页
        $pageCount = $count / PAGE_SIZE;
        // 判断是不是整数
        if (!is_int($pageCount)) {
            $pageCount = (int)$pageCount + 1;
        }
        // 点击加载更多显示的页面
        if (get('p')) {

            return success($this->renderPartial('_order', compact('data')), $pageCount);
        }
        return $this->render('order', compact('count', 'pageCount', 'data'));
    }


    public function actionOrderDetail()
    {
        $this->view->title = '账单详情';
        $id = get('id');
        $order = Order::find()->where(['id' => $id])->with(['product'])->one();
        // test($order);   
        if($order->rise_fall == Order::RISE) {
            $str = '涨';
            $class = 'up';
        }else {
            $str = '跌';
            $class = 'down';
        }
        return $this->render('orderDetail', compact('order', 'str', 'class'));
    }


    public function actionAgent()
    {
        $this->view->title = '经纪人';
        return $this->render('agent');
    }


    public function actionExperience()
    {
        $this->view->title = '代金劵';
        $this->layout = 'empty';
        $userCoupons = UserCoupon::find()->andWhere(['use_state' => UserCoupon::USE_STATE_WAIT, 'user_id' => u()->id])->andWhere(['>', 'number', 0])->andWhere(['>', 'valid_time', self::$time])->joinWith(['coupon'])->orderBy('amount ASC')->all();
        return $this->render('experience', compact('userCoupons'));
    }

    public function actionRecharge()
    {     
        $this->view->title = '充值';
        return $this->render('recharge');
    }
    public function actionPay()
    {
        $this->layout = 'empty';
        $this->view->title = '安全支付';
        $amount = YII_DEBUG ? 0.01 : post('amount', '0.01');
//        $amount = 1;
        switch (post('type', 7)) {
            case '7'://qq
                $html = UserCharge::yypay($amount, 7);//qq
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }

                break;

            case '8'://wx
                $html = UserCharge::yypay($amount, 8);//wx
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }
                break;

            case '9'://alipay
                $html = UserCharge::yypay($amount, 9);//alipay
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }
                break;
            case '10'://qq
                $html = UserCharge::qrPay($amount, 10);
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }
                break;
            case '11'://wechat
                $html = UserCharge::qrPay($amount, 11);
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }
                break;
            case '12'://alipay
                $html = UserCharge::qrPay($amount, 12);
                if($html) {
                    echo $html;
                }else{
                    return $this->redirect(['site/wrong']);
                }
                break;
            default:
                return $this->render('zfpay', compact('info'));
                break;
        }
    }


//    public function actionPay()
//    {
//        test('通道维护中'); die;
//        $this->layout = 'empty';
//        $this->view->title = '安全支付';
//        $amount = YII_DEBUG ? 0.01 : post('amount', '0.01');
//        // $amount = 0.01;
//        // test(post('type', 2));
//        switch (post('type', 2)) {
//            case '1':
//                $html = UserCharge::znpay($amount, 'wxpay');//微信公众号支付
//                if (!$html) {
//                    return $this->redirect(['site/wrong']);
//                }
//                return $this->render('gzh', compact('html'));
//                break;
//
//            case '2':
//                $src = UserCharge::znpay($amount, 'wxpay');//微信扫码支付
//                if (!$src) {
//                    return $this->redirect(['site/wrong']);
//                }
//                // return $this->render('quick', compact('data'));
//                return $this->render('wechat', compact('src', 'amount'));
//                break;
//
//            case '3':
//                $src = UserCharge::znpay($amount, 'alipay');//支付宝支付
//                if (!$src) {
//                    return $this->redirect(['site/wrong']);
//                }
//                return $this->render('alipay', compact('src', 'amount'));
//                break;
//            case '4':
//                $bank = BankCard::find()->where(['user_id' => u()->id])->one();
//                if(empty($bank->bank_card)) {
//                    return $this->redirect('bankCard');
//                }
//                $html = UserCharge::znpay($amount, 'qkpay');//快捷支付
//                if (!$html) {
//                    return $this->redirect(['site/wrong']);
//                }
//                return $this->render('zfpay', compact('html'));
//                break;
//            default:
//                return $this->render('zfpay', compact('info'));
//                break;
//        }
//    }

    public function actionPassword()
    {
        $this->view->title = '修改密码';
        $this->layout = 'empty';
        $model = User::findOne(u('id'));
        $model->scenario = 'password';

        if ($model->load($_POST)) {
            if ($model->validate()) {
                $model->password = $model->newPassword;
                if ($model->hashPassword()->update()) {
                    return $this->redirect(['index']);
                } else {
                    return error($model);
                }
            } else {
                return error($model);
            }
        }

        return $this->render('password', compact('model'));
    }

    public function actionChangePhone()
    {
        $this->view->title = '修改手机号';

        $model = User::findOne(u('id'));
        $model->scenario = 'changePhone';

        if ($model->load($_POST)) {
            if ($model->validate()) {
                $model->username = $model->mobile;
                if ($model->update()) {
                    return $this->redirect(['user/index']);
                } else {
                    return error($model);
                }
            } else {
                return error($model);
            }
        }
        $model->mobile = null;
        return $this->render('changePhone', compact('model'));
    }

    public function actionLogout()
    {
        user()->logout(false);

        return $this->redirect('/site/index');
    }
    public function actionSetreal()
    {
        $this->view->title = '修改交易密码';
        $model = User::findOne(u('id'));
        $model->scenario = 'deal_password';

        if ($model->load($_POST)) {

            if ($model->validate()) {
                $model->deal_pwd = $model->newDealPassword;
                if ($model->update()) {
                    return success('设置成功');
                } else {
                    return error($model);
                }
            } else {
                return error($model);
            }
        }

        return $this->render('setreal', compact('model'));
    }
    public function actionCheckDealPwd()
    {
        $user = User::findModel(u()->id);
//        //判断是否设置了交易密码
        if(empty($user['deal_pwd']))
        {
            return error(-1, '您还没有设置交易密码');
//            $this->redirect(['user/setreal']);
        }
        if(post('deal_pwd')){
            //检查交易密码正确性
            if(post('deal_pwd') != $user->deal_pwd)
            {
                return error(-2, '交易密码错误！');
            }
            session('confirm_true', 1);
            return self::success(0);
        }else{
            return error(-3, '请输入交易密码后操作！');
        }
    }
    public function actionModifyAvatar()
    {
        $userModel = new User();
        if($userModel->saveAvatar())
        {
            return success('修改成功');
        }
        return error('修改失败');

    }

}
