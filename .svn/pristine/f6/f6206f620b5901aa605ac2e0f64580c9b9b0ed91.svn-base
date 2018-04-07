<?php

namespace common\models;

use Yii;

/**
 * 这是表 `integral` 的模型
 */
class Integral extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['integral_type', 'integral_value', 'desc'], 'string', 'max' => 100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'integral_type' => '积分类型',
            'integral_value' => '积分值',
            'desc' => '描述',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    // public function getRelation()
    // {
    //     return $this->hasOne(Class::className(), ['foreign_key' => 'primary_key']);
    // }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'integral.id' => $this->id,
            ])
            ->andFilterWhere(['like', 'integral.integral_type', $this->integral_type])
            ->andFilterWhere(['like', 'integral.integral_value', $this->integral_value])
            ->andFilterWhere(['like', 'integral.desc', $this->desc])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
        // Map method of field `IntegralType`
    public static function getIntegralTypeMap($prepend = false)
    {
        $map = [
            self::PLACE => '下单',
            self::LOG   => '登录',
            self::SIGN  => '签到',

        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `IntegralType`
    public function getIntegralTypeValue($value = null)
    {
        return $this->resetValue($value);
    }
}
