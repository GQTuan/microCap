<?php

namespace common\models;

use Yii;

/**
 * 这是表 `bank_info` 的模型
 */
class BankInfo extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['bank_simple', 'bank_elect', 'bank_name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_simple' => '开户行简号',
            'bank_elect' => '电子联行号',
            'bank_name' => '银行名称',
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
                'bankInfo.id' => $this->id,
            ])
            ->andFilterWhere(['like', 'bankInfo.bank_simple', $this->bank_simple])
            ->andFilterWhere(['like', 'bankInfo.bank_elect', $this->bank_elect])
            ->andFilterWhere(['like', 'bankInfo.bank_name', $this->bank_name])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
}
