<?php

namespace common\models;

use Yii;

/**
 * 这是表 `prize` 的模型
 */
class Prize extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['prizes_id', 'prize_num', 'probability', 'prize_state'], 'integer'],
            [['min'], 'string', 'max' => 100],
            [['prize', 'max'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prizes_id' => '奖项id',
            'min' => '概率最小角度（请勿修改）',
            'prize' => '奖品名称',
            'max' => '最大角度（请勿修改）',
            'prize_num' => '赠送代金券数量',
            'probability' => '概率',
            'prize_state' => '-1为删除1为未删除',
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
                'prize.id' => $this->id,
                'prize.prizes_id' => $this->prizes_id,
                'prize.prize_num' => $this->prize_num,
                'prize.probability' => $this->probability,
                'prize.prize_state' => $this->prize_state,
            ])
            ->andFilterWhere(['like', 'prize.min', $this->min])
            ->andFilterWhere(['like', 'prize.prize', $this->prize])
            ->andFilterWhere(['like', 'prize.max', $this->max])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
}
