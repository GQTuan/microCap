<?php

namespace admin\controllers;

use admin\models\Order;
use common\helpers\ArrayHelper;
use Yii;
use admin\models\Product;

class RiskController extends \admin\components\Controller
{
    /**
     * @authname 风险控制
     */
    public function actionCenter()
    {
        $switch = option('risk_switch');
        $products = Product::find()->where(['on_sale' => Product::ON_SALE_YES, 'state' => Product::STATE_VALID])->asArray()->all();
        $risk_product = option('risk_product') ?: [];

        if (req()->isPost) {
            option('risk_switch', post('risk_switch'));
            if ($post = post('product', [])) {
                foreach ($post as $product => $value) {
                    $params[$product] = $value;
                }
                option('risk_product', $params);
            }

            return success();
        }

        return $this->render('center', compact('switch', 'products', 'risk_product'));
    }
    /**
     * @authname 风险控制
     */
    public function actionControl()
    {
        $products = $this->getProducts();

        if (req()->isPost) {
            $data = [];
            foreach ($_POST['product'] as $tableName => list($target, $time, $price)) {
                if ($price && $time) {
                    $data[$tableName] = [
                        'start' => time(),
                        'price' => $price,
                        'target' => $target,
                        'time' => $time
                    ];
                }
            }
            option('risk_product_control', $data);
            return success();
        }
        $orderInfo = $this->actionOrderInfo();

        return $this->render('control', compact('products', 'orderInfo', 'profit', 'amount', 'hand', 'fee'));
    }
    /**
     * @authname 实时下单信息
     */
    public function actionOrderInfo()
    {
        $products = ArrayHelper::map($this->getProducts(), 'id', 'table_name');
        $data = [];
        foreach ($products as $id => $name) {
            $riseQuery = Order::find()->joinWith('product')->where(['order_state' => Order::ORDER_POSITION, 'product.table_name' => $name]);
            $downQuery = clone $riseQuery;
            $riseQuery->andWhere(['rise_fall' => Order::RISE]);
            $downQuery->andWhere(['rise_fall' => Order::FALL]);
            $data[$name]['riseAmount'] = $riseQuery->sum('hand * order.one_profit') ?: 0;
            $data[$name]['downAmount'] = $downQuery->sum('hand * order.one_profit') ?: 0;
            $data[$name]['riseNum'] = $riseQuery->groupBy('order.user_id')->count();
            $data[$name]['downNum'] = $downQuery->groupBy('order.user_id')->count();
        }

        if (req()->isAjax) {
            return success($data);
        } else {
            return $data;
        }
    }
    protected function getProducts()
    {
        return Product::find()->with('dataAll')->where(['on_sale' => Product::ON_SALE_YES, 'state' => Product::STATE_VALID])->asArray()->all();
    }
}
