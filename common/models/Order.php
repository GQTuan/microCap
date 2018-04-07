<?php

namespace common\models;

use Yii;

/**
 * 这是表 `order` 的模型
 */
class Order extends \common\components\ARModel
{
    // 1买，2卖
    const BUY = 1;
    const SELL = 2;
    // 持仓状态，1持仓，2抛出
    const ORDER_POSITION = 1;
    const ORDER_THROW = 2;
    //涨跌（1涨2跌）
    const RISE = 1;
    const FALL = 2;
    // 币种 1RMB，2USD
    const CURRENCY_RMB = 1;
    const CURRENCY_USD = 2;
    // 是否系统平仓
    const IS_CONSOLE_YES = 1;
    const IS_CONSOLE_NO = -1;
    // 是否是否标记风控
    const SIGN_NO = 1;
    const SIGN_WIN = 2;//赢
    const SIGN_FAIL = 3;//亏
    // 默认美元汇率
    const USA_RATE = 6.77;

    public $product_name;
    public $start_date;
    public $end_date;
    
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id', 'hand', 'rise_fall', 'sell_hand', 'currency', 'is_console', 'order_state', 'created_by', 'updated_by'], 'integer'],
            [['price', 'one_profit', 'fee', 'stop_profit_price', 'stop_profit_point', 'stop_loss_price', 'stop_loss_point', 'deposit', 'sell_price', 'sell_deposit', 'discount', 'profit'], 'number'],
            [['sell_time', 'created_at', 'updated_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => '买卖品类',
            'hand' => '手数',
            'price' => '买入价',
            'one_profit' => '一手盈亏',
            'fee' => '手续费',
            'stop_profit_price' => '止盈金额',
            'stop_profit_point' => '止盈点数',
            'stop_loss_price' => '止损金额',
            'stop_loss_point' => '止损点数',
            'deposit' => '保证金',
            'rise_fall' => '涨跌：1涨，2跌',
            'sell_price' => '卖出价格',
            'sell_hand' => '卖出手数',
            'sell_deposit' => '卖出总价',
            'discount' => '优惠金额',
            'currency' => '币种：1人民币，2美元',
            'profit' => '盈亏',
            'is_console' => 'Is Console',
            'sell_time' => '平仓时间',
            'order_state' => '持仓状态，1持仓，2抛出',
            'created_at' => '下单时间',
            'created_by' => 'Created By',
            'updated_at' => '平仓时间',
            'updated_by' => 'Updated By',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'order.id' => $this->id,
                'order.user_id' => $this->user_id,
                'order.product_id' => $this->product_id,
                'order.hand' => $this->hand,
                'order.price' => $this->price,
                'order.one_profit' => $this->one_profit,
                'order.fee' => $this->fee,
                'order.stop_profit_price' => $this->stop_profit_price,
                'order.stop_profit_point' => $this->stop_profit_point,
                'order.stop_loss_price' => $this->stop_loss_price,
                'order.stop_loss_point' => $this->stop_loss_point,
                'order.deposit' => $this->deposit,
                'order.rise_fall' => $this->rise_fall,
                'order.sell_price' => $this->sell_price,
                'order.sell_hand' => $this->sell_hand,
                'order.sell_deposit' => $this->sell_deposit,
                'order.discount' => $this->discount,
                'order.currency' => $this->currency,
                'order.profit' => $this->profit,
                'order.is_console' => $this->is_console,
                'order.order_state' => $this->order_state,
                'order.created_by' => $this->created_by,
                'order.updated_by' => $this->updated_by,
            ])
            ->andFilterWhere(['like', 'order.sell_time', $this->sell_time])
            ->andFilterWhere(['like', 'order.created_at', $this->created_at])
            ->andFilterWhere(['like', 'order.updated_at', $this->updated_at])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    /**
     * 卖出产品
     * @param  int 订单id
     * @param  float 产品当前价格
     * @access public
     * @return boolean
     */
    public static function sellOrder($id, $isConsole = false)
    {
        $query = self::find()->where(['id' => $id, 'order_state' => self::ORDER_POSITION])->with('product');
        if (!$isConsole) {
            $query->andWhere(['user_id' => u()->id]);
        }
        $order = $query->one();
        if (!empty($order)) {
            //最新价格
            $dataAll = DataAll::newProductPrice($order->product_id);
            // $dataAll->price = 200;
            //买涨
            if ($order->rise_fall == self::RISE) {
                $diffPrice = sprintf('%.3f', $dataAll->price - $order->price);
            } else {
            //买跌
                $diffPrice = sprintf('%.3f', $order->price - $dataAll->price);
            }

            //挣了多少钱
            $order->profit = sprintf('%.2f', ($diffPrice * $order->one_profit * $order->hand));
            //如果平仓的时候收益超出，按设定最高收益
            if ($order->profit > 0) {
                if ($order->stop_profit_point > 0) {
                    //盈利不能超过设置盈利
                    if ($order->profit > $order->stop_profit_price ) {
                        $order->profit = $order->stop_profit_price;
                    }
                }
            } else {
                if ($order->stop_loss_point > 0) {
                    //亏损不能超过设置亏损
                    if (-$order->profit > $order->stop_loss_price) {
                        $order->profit = -$order->stop_loss_price;
                    }
                }
            }

            if ($order->profit > $order->deposit) {
               $order->profit = $order->deposit;
            }

            if (-$order->profit > $order->deposit) {
               $order->profit = -$order->deposit;
            }
            //卖掉收入
            $order->sell_deposit = sprintf('%.2f', $order->deposit + $order->profit);

            $order->sell_hand = $order->hand;
            $order->sell_price = $dataAll->price;
            $order->order_state = self::ORDER_THROW;
            $order->is_console = $isConsole === true ? self::IS_CONSOLE_YES : self::IS_CONSOLE_NO;
// test($order->attributes);
            if ($order->save()) {
                //去除该单用户的冻结资金 增加钱数 (用户是否用现金支付fee等于0用了体验卷)
                $user = User::findOne($order->user_id);
                $user->blocked_account -= $order->deposit - $order->discount;
                $user->account += $order->profit;
                if ($order->profit != 0) {
                    //微会员与结算会员的保证金关联
                    AdminDeposit::depositRecord($order);
                }
                if ($order->profit > 0) {
                    $user->profit_account += $order->profit;
                } else {
                    if ($order->is_medal == 1) {
                        $user->account -= $order->profit;
                    } else {
                        $user->loss_account += $order->profit;
                    }
                }
                if ($user->account < 0) {
                    $user->account = 0;
                }
                $user->save(false); 
                return true;
            }
        }
        return false;
    }

    /**
     * 标记卖出产品
     * @param  int 订单id
     * @param  float 产品当前价格
     * @access public
     * @return boolean
     */
    public static function sellSignOrder($id)
    {
        $query = self::find()->where(['id' => $id, 'order_state' => self::ORDER_POSITION])->with('product');
        if (!$isConsole) {
            $query->andWhere(['user_id' => u()->id]);
        }
        $order = $query->one();
        if (!empty($order)) {
            if ($order->sign_state < self::SIGN_WIN) {
                return false;
            }
            // if (strpos($order->price, '.') !== false) {
            //     list($int, $point) = explode('.', $order->price);
            //     $point = pow(10, -1 * strlen($point));
            // } else {
            //     $point = 1;
            // }
            // $price = $order->price;
            // $wave = 1;
            //最新价格
            $dataAll = DataAll::newProductPrice($order->product_id);
            //买涨
            if ($order->rise_fall == self::RISE) {
                $diffPrice = sprintf('%.3f', $dataAll->price - $order->price);
            } else {
            //买跌
                $diffPrice = sprintf('%.3f', $order->price - $dataAll->price);
            }

            //挣了多少钱
            $order->profit = sprintf('%.2f', ($diffPrice * $order->one_profit * $order->hand));
            //如果平仓的时候收益超出，按设定最高收益
            if ($order->profit > 0) {
                if ($order->stop_profit_point > 0) {
                    //盈利不能超过设置盈利
                    if ($order->profit > $order->stop_profit_price ) {
                        $order->profit = $order->stop_profit_price;
                    }
                }
            } else {
                if ($order->stop_loss_point > 0) {
                    //亏损不能超过设置亏损
                    if (-$order->profit > $order->stop_loss_price) {
                        $order->profit = -$order->stop_loss_price;
                    }
                }
            }

            if ($order->profit > $order->deposit) {
               $order->profit = $order->deposit;
            }

            if (-$order->profit > $order->deposit) {
               $order->profit = -$order->deposit;
            }
            //卖掉收入
            $order->sell_deposit = sprintf('%.2f', $order->deposit + $order->profit);

            $order->sell_hand = $order->hand;
            $order->sell_price = $dataAll->price;
            $order->order_state = self::ORDER_THROW;
            $order->is_console = self::IS_CONSOLE_YES;
// test($order->attributes);
            if ($order->save()) {
                //去除该单用户的冻结资金 增加钱数 (用户是否用现金支付fee等于0用了体验卷)
                $user = User::findOne($order->user_id);
                $user->blocked_account -= $order->deposit - $order->discount;
                $user->account += $order->profit;
                if ($order->profit != 0) {
                    //微会员与结算会员的保证金关联
                    AdminDeposit::depositRecord($order);
                }
                if ($order->profit > 0) {
                    $user->profit_account += $order->profit;
                } else {
                    if ($order->is_medal == 1) {
                        $user->account -= $order->profit;
                    } else {
                        $user->loss_account += $order->profit;
                    }
                }
                $user->save(false); 
                return true;
            }
        }

            //买涨
            // if ($order->rise_fall == self::RISE) {
            //     if ($order->sign_state == self::SIGN_WIN) {
            //         //赢钱平仓
            //         $order->profit = sprintf('%.2f', $order->deposit - $order->one_profit);
            //         $order->sell_deposit = sprintf('%.2f', $order->deposit + $order->profit);
            //     } else {
            //         $wave = -1;
            //         //亏钱平仓
            //         $order->profit = -sprintf('%.2f', $order->deposit - $order->one_profit);
            //         $order->sell_deposit = 0;
            //     }
            // } 
    }

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/

    // Map method of field `order_state`
    public static function getOrderStateMap($prepend = false)
    {
        $map = [
            self::ORDER_POSITION => '持仓中',
            self::ORDER_THROW => '已结算',
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `order_state`
    public function getOrderStateValue($value = null)
    {
        return $this->resetValue($value);
    }

    // Map method of field `rise_fall`
    public static function getRiseFallMap($prepend = false)
    {
        $map = [
            self::RISE => '涨',
            self::FALL => '跌'
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `rise_fall`
    public function getRiseFallValue($value = null)
    {
        return $this->resetValue($value);
    }

    // Map method of field `currency`
    public static function getCurrencyMap($prepend = false)
    {
        $map = [
            self::CURRENCY_RMB => '人民币',
            self::CURRENCY_USD => '美元'
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `currency`
    public function getCurrencyValue($value = null)
    {
        return $this->resetValue($value);
    }

    public static function getProductNameMap($prepend = false)
    {
        $map = Product::find()->andWhere(['on_sale' => Product::ON_SALE_YES, 'state' => Product::STATE_VALID])->map('id', 'name');

        return self::resetMap($map, $prepend);
    }

    public function getProductNameValue($value = null)
    {
        return $this->resetValue($value);
    }

    // Map method of field `is_console`
    public static function getIsConsoleMap($prepend = false)
    {
        $map = [
            self::IS_CONSOLE_YES => '是',
            self::IS_CONSOLE_NO => '否'
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `is_console`
    public function getIsConsoleValue($value = null)
    {
        return $this->resetValue($value);
    }
}
