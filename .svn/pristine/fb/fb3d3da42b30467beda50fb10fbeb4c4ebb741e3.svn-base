<?php

namespace console\models;

use Yii;
use common\models\Order;
use common\models\Product;
use common\models\DataAll;
use common\helpers\Curl;
use common\helpers\StringHelper;

class Sign extends \yii\base\Object
{
    use \common\traits\ChisWill;


    public function run()
    {
        // 获取所有止盈止损订单ID
        $ids = self::db('SELECT id from `order` where (order_state = ' . Order::ORDER_POSITION . ' AND sign_state > ' . Order::SIGN_NO . ')')->queryAll();
        array_walk($ids, function ($value) {
            Order::sellSignOrder($value['id']);
        });
    }
}
