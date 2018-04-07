<?php

namespace frontend\models;

use Yii;

class Order extends \common\models\Order
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['start_date', 'end_date'], 'safe'],
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            // 'scenario' => ['field1', 'field2'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            // 'field1' => 'description1',
            // 'field2' => 'description2',
        ]);
    }

    public static function saveOrder($data, $productPrice)
    {
        $order = new Order();
        $order->product_id = $productPrice->product_id;
        $order->one_profit = $productPrice->one_profit;
        //代金券购买
        // test($data['quanCount']);
        if ($data['quanCount'] > 0) {
            $couponCount = UserCoupon::getCouponIdCount($data['quanLevel'], true);
            if ($data['quanCount'] > $couponCount) {
                return error('代金券的数量不够!');
            }
            //代金卷金额
            $order->discount = $data['quanLevel'] * $data['quanCount'];
        }
        if ($data['deposit'] < 10) {
           return ['code' => -1, 'info' => '下单购买金额最低10起步！']; 
        }
        if ($data['hand'] < 1 && !is_int($data['hand'])) {
           return ['code' => -1, 'info' => '下单数非法！']; 
        }
        $order->fee = $productPrice->fee * $data['hand'];
        $order->hand = $data['hand'];
        if($order->hand > $productPrice->max_hand) {
            return ['code' => -1, 'info' => '下单手数超过最大手数'];
        }
        $order->deposit = $productPrice->deposit * $order->hand;
        $order->rise_fall = $data['rise_fall'];
        if ($order->discount > $order->deposit) {
            return ['code' => -1, 'info' => '优惠金额不能超过保证金总额！'];
        }
        $order->stop_profit_price = $data['deposit'] * $data['zhiying'] / 100;
        $order->stop_profit_point = $data['zhiying'];
        $order->stop_loss_price = $data['deposit'] * $data['zhisun'] / 100;
        $order->stop_loss_point = $data['zhisun'];
        // 是否使用免死金牌
        if($data['paiCount'] == Order::STATE_VALID) {
            $order->is_medal = Order::STATE_VALID;
            UserMedal::deleteUserMedal();
        }
        //查询余额是否够用
        $user = User::findModel(u()->id);
        if ($user->blocked_account < 0 || $user->account < 0) {
            return ['code' => -1, 'info' => '您的账号异常请联系管理员！'];
        }
        if ($user->state == User::STATE_INVALID) {
            return ['code' => -1, 'info' => '您的账号已经冻结！'];
        }
        if (($user->blocked_account + $order->deposit + $order->fee - $order->discount) > $user->account) {
            return ['code' => -1, 'info' => '您的余额已不够支付，请充值！'];
        }
        $order->user_id = $user->id;
        //当前最新价格
        $dataAll = DataAll::newProductPrice($order->product_id);
        if ($dataAll->price <= 1) {
            return ['code' => -1, 'info' => '最新价格违法！'];
        }
        $order->price = $dataAll->price;
        //平仓时间
        if (!$order->save()) {
            return ['code' => -1, 'info' => $order];
        } else {
            // 送积分
            $integral = new Integral;
            $integral->getintegral(Integral::PLACE);
            if ($order->discount > 0) {
                UserCoupon::deleteUserCoupon($data['quanLevel'], $data['quanCount']);
            }
            $user->blocked_account += $order->deposit - $order->discount;
            $user->account -= $order->fee;
            //经纪人手续费返点
            UserRebate::isUserRebate($order);
            $user->save(false);
            return ['code' => 1, 'info' => '购买成功！'];
        }
    }

    /**
     * 盈利钱数
     * @param  int|model 订单id/model
     * @access public
     * @return number 钱数
     */
    public static function userWinOrder($order)
    {
        if (is_numeric($order)) {
            $order = self::findModel($order);
        }

        $dataAll = DataAll::newProductPrice($order->product_id);
        if ($order->rise_fall == self::RISE) {
        //钱数 （当前价格-购买价格）*手数*每个点的差价
            $diffPrice = sprintf('%.3f', $dataAll->price - $order->price);
        } else {
        //买跌
            $diffPrice = sprintf('%.3f', $order->price - $dataAll->price);
        }
        //汇率
        // $rate = 1;
        // //判断期货是否属于人民币
        // if ($order->product->currency == self::CUR_USA) {
        //     $rate = config()->get('usa', self::USA_RATE);
        // }
        //盈利多少钱
        return sprintf('%.2f', ($diffPrice * $order->one_profit * $order->hand));
    }

    /**
     * 订单最新的数据
     * @param  int 订单id
     * @access public
     * @return arraycover
     */
    public static function getUserOrderData($id)
    {
        $order = self::find()->where(['order_state' => Order::ORDER_POSITION, 'user_id' => u()->id, 'id' => $id])->one();
        $data['profit'] = self::userWinOrder($order);
        $data['price'] = DataAll::newProductPrice($order->product_id)->price;
        $data['profitRate'] = $data['profit'] * 100 / $order->deposit;
        $data['deposit'] = $data['profit'] + $order->deposit;
        return $data;
    }

    //经纪人客户平仓时间搜索+产品
    public function coverQuery($array)
    {
        $this->load(get());
        $this->start_date = $this->start_date ?: date('Y-m-d', strtotime('-31 days'));
        $this->end_date = $this->end_date ?: date('Y-m-d', strtotime('+1 days'));
        return $this->search()
                    ->joinWith(['product', 'user'])
                    ->andWhere(['order_state' => Order::ORDER_THROW])
                    ->andWhere(['in', 'user_id', $array])
                    ->andFilterWhere(['between', 'order.created_at', $this->start_date, $this->end_date])
                    ->andFilterWhere(['product_id' => $this->product_id])
                    ->orderBy('order.created_at DESC');
    }

    //持仓单搜索
    public function positionQuery()
    {
        $this->load(get());
        if (!get() && !isset($this->order_state)) {
            $this->order_state = self::ORDER_POSITION;
        }
        return $this->search()
                    ->andWhere(['user_id' => u()->id])
                    ->andFilterWhere(['order_state' => $this->order_state])
                    ->andFilterWhere(['product_id' => $this->product_id])
                    ->with(['product'])
                    ->orderBy('created_at DESC');
    }
}
