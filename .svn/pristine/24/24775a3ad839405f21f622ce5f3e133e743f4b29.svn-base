<?php

namespace common\models;

use Yii;

/**
 * 这是表 `user_integral` 的模型
 */
class UserIntegral extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['integral_types', 'user_id'], 'required'],
            [['integral_types', 'user_id', 'integral_value'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'integral_types' => '积分类型',
            'user_id' => 'User ID',
            'integral_value' => '积分值',
            'created_at' => '获得时间',
            'updated_at' => '使用时间',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getIntegral()
    {
        return $this->hasOne(Integral::className(), ['integral_type' => 'integral_types']);
    }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'userIntegral.id' => $this->id,
                'userIntegral.integral_types' => $this->integral_types,
                'userIntegral.user_id' => $this->user_id,
                'userIntegral.integral_value' => $this->integral_value,
            ])
            ->andFilterWhere(['like', 'userIntegral.created_at', $this->created_at])
            ->andFilterWhere(['like', 'userIntegral.updated_at', $this->updated_at])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
    // Map method of field `integral_types`
    public static function getIntegralTypesMap($prepend = false)
    {
        $map = [
            self::PLACE => '下单',
            self::LOG   => '登录',
            self::SIGN  => '签到',

        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `integral_types`
    public function getIntegralTypesValue($value = null)
    {
        return $this->resetValue($value);
    }
}
