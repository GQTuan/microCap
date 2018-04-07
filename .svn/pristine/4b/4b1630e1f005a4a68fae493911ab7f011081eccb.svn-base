<?php

namespace common\models;

use Yii;

/**
 * 这是表 `bank_code` 的模型
 */
class BankCode extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['aa', 'settAreaCode', 'note'], 'string', 'max' => 200],
            [['bankno', 'settQsBankCode'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 2000]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aa' => 'Aa',
            'bankno' => 'Bankno',
            'settQsBankCode' => 'Sett Qs Bank Code',
            'name' => 'Name',
            'settAreaCode' => 'Sett Area Code',
            'note' => 'Note',
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
                'bankCode.id' => $this->id,
            ])
            ->andFilterWhere(['like', 'bankCode.aa', $this->aa])
            ->andFilterWhere(['like', 'bankCode.bankno', $this->bankno])
            ->andFilterWhere(['like', 'bankCode.settQsBankCode', $this->settQsBankCode])
            ->andFilterWhere(['like', 'bankCode.name', $this->name])
            ->andFilterWhere(['like', 'bankCode.settAreaCode', $this->settAreaCode])
            ->andFilterWhere(['like', 'bankCode.note', $this->note])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
}
