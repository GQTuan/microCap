<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\Product;
use frontend\models\Order;
use frontend\models\ProductPrice;
use frontend\models\Coupon;
use frontend\models\UserCoupon;
use frontend\models\UserMedal;
use frontend\models\DataAll;

class OrderController extends \frontend\components\Controller
{
    public function beforeAction($action)
    {
        if (user()->isGuest) {
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

    //下单操作
    public function actionIndex()
    {
        $this->view->title = '下单';
        $pid = req('pid');
        if (user()->isGuest) {
            return $this->redirect(['site/login']);
        }
        $product = Product::find()->andWhere(['id' => $pid])->with('dataAll')->one();
        $productPrice = ProductPrice::getSetProductPrice($product->id);
        if (!isset($productPrice)) {
            return $this->redirect(['site/wrong']);
        }
        //体验卷
        $couponType = UserCoupon::getNumberType($pid);
        return $this->render('index', compact('product', 'productPrice', 'couponType'));
    }

    //持仓列表
    public function actionPosition()
    {
        $this->view->title = '持仓';
        $orders = Order::find()->where(['order_state' => Order::ORDER_POSITION, 'user_id' => u()->id])->with('product')->orderBy('created_at DESC')->all();
        $user = User::findModel(u()->id);
        return $this->render('position', compact('orders', 'user'));
    }

    //平仓
    public function actionSellPosition($id = 1)
    {
        $this->view->title = '平仓';
        if (user()->isGuest) {
            return $this->redirect(['site/login']);
        }
        $order = Order::find()->where(['order_state' => Order::ORDER_POSITION, 'user_id' => u()->id, 'id' => $id])->with('product')->one();
        if (empty($order)) {
            return $this->redirect(['site/index']);
        }
        return $this->render('sellPosition', compact('order'));
    }
    //客户平仓
    public function actionCustomSellPosition($id = 1)
    {
        $this->view->title = '客户平仓';
        return $this->render('customSellPosition');
    }

    //收入
    public function actionInput()
    {
        $this->view->title = '收入';
        return $this->render('input');
    }
    //下单
    public function actionBuy()
    {

        $this->view->title = '投资';
        //获取已get方式传过来的参数的值
        $parmar = get('rise_fall');
        // test(post('rise_fall'));
        $product = Product::find()->andWhere(['id' => get('id')])->with('dataAll')->one();
        if (empty($product)) {
            return $this->redirect(['order/transDetail']);
        }
        $productPrices = ProductPrice::find()->where(['product_id' => $product->id])->orderBy('deposit ASC')->all();
        
        //代金卷
        $couponArr = UserCoupon::getNumberType();
        // 免死金牌
        $medalArr = UserMedal::find()->andWhere(['user_id' => u()->id, 'use_state' => UserMedal::STATE_VALID])->andWhere(['>', 'number', 0])->select('SUM(number) number')->one()->number;
        return $this->render('buy', compact('productPrices', 'product', 'couponArr','content','parmar', 'medalArr'));
    }
    //直属客户
    public function actionZhishuClient()
    {
        $this->view->title = '直属客户';
        return $this->render('zhishuClient');
    }
    /**
     * @authname 交易详情
     */
    public function actionTransDetail()
    {
        $this->view->title = '详情';
        $products = Product::getDetailProduct();
        $id = get('id', key($products[1]));
        if (!isset($products[1][$id])) {
            return $this->redirect(['user/wrong']);
        }
        $orderState = Order::find()->where(['user_id' => u()->id])->one();
        if(!$orderState) {
            $state = 1;
        }else {
            $state = 0;
        }
        // $productPrices = ProductPrice::find()->where(['product_id' => $id])->orderBy('sort ASC')->all();
        //优惠劵的总数
        $count = UserCoupon::getAllUserCouponCount();
        $allProduct = $products[0];
        return $this->render('transDetail', compact('allProduct', 'count', 'id', 'state'));
    }

    /**
     * 更新所有持仓单数据ajax请求
     * @access public
     * @return json
     */
    public function actionAjaxUpdateOrder()
    {
        $orders = Order::find()->where(['order_state' => Order::ORDER_POSITION, 'user_id' => u()->id])->all();
        $data = [];
        foreach ($orders as $order) {
            $data[$order->id] = Order::userWinOrder($order);
        }
        return success($data);
    }

    /**
     * 更新一条持仓单数据ajax请求
     * @access public
     * @return json
     */
    public function actionAjaxUpdateOrderOne()
    {
        $data = Order::getUserOrderData(post('id'));
        // test($data);
        return success($data);
    }

    /**
     * 保存订单
     * @access public
     * @return json
     */
    public function actionAjaxSaveOrder()
    {
        $data = post('data');

        $productPrice = ProductPrice::find()->where(['product_id' =>$data['product_id'], 'deposit' => $data['price']])->one();
        if (empty($productPrice)) {
            return error('数据异常！');
        }
        // if ($data['deposit'] > $productPrice->deposit) {
        //     return error('单笔下单已超过最大金额！');
        // }
        //判断此期货是否在交易时间内
        if (!Product::isTradeTime($productPrice->product_id)) {
            return error('非买入时间，无法委托买入！');
        }
        //订单处理
        $res = Order::saveOrder($data, $productPrice);
        if ($res['code'] == 1) {
            return success();
        } else {
            return error($res['info']);
        }
    }

    /**
     * 平仓订单ajax请求 系统倒计时平仓
     * @access public
     * @return json
     */
    public function actionAjaxSellOrder()
    {
        $id = post('id');
        $order = Order::find()->where(['id' => $id, 'order_state' => Order::ORDER_POSITION, 'user_id' => u()->id])->one();
        if (empty($order)) {
            return error('订单已平仓！');
        }
        $bool = Order::sellOrder($order->id);
        if ($bool) {
            return success();
        } else {
            return error('订单数据异常！');
        }
    }
}
