<?php

namespace frontend\models;

use Yii;

class Product extends \common\models\Product
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            // [['field1', 'field2'], 'required', 'message' => '{attribute} is required'],
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
    //获取首页三个上架的产品
    public static function getIndexProduct($bool = false)
    {
        $products = self::find()->with(['dataAll', 'priceExtend'])->where(['on_sale' => self::ON_SALE_YES, 'state' => self::STATE_VALID])->limit(5)->orderBy('hot DESC')->all();
        if ($bool) {
            $arr = [];
            foreach ($products as $product) {
                $arr[$product->id] = $product->name; 
                $product->on_sale = self::isTradeTime($product->id) ? 1 : -1;
            }
            return [$products, $arr];
        }
        return $products;
    }

    //获取首页三个上架的产品
    public static function getDetailProduct()
    {
        $products = self::find()->with(['dataAll'])->where(['on_sale' => self::ON_SALE_YES, 'state' => self::STATE_VALID])->orderBy('hot DESC')->all();
        $arr = [];
        foreach ($products as $product) {
            $arr[$product->id] = $product->name; 
            $product->on_sale = self::isTradeTime($product->id) ? 1 : -1;
        }
        return [$products, $arr];
    }

    //获取上架的产品数组
    public static function getProductArray()
    {
        return self::find()->where(['on_sale' => self::ON_SALE_YES, 'state' => self::STATE_VALID])->orderBy('hot DESC')->map('id', 'name');
    }
}
