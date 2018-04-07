<?php

namespace common\models;

use Yii;

/**
 * 这是表 `user_ranking` 的模型
 */
class UserRanking extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['nickname', 'profit'], 'required'],
            [['profit', 'created_at'], 'number'],
            [['state'], 'integer'],
            [['nickname', 'face'], 'string', 'max' => 100],
            [['hot'], 'string', 'max' => 10]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => '昵称',
            'face' => '头像',
            'profit' => '盈亏',
            'hot' => '排序',
            'state' => '状态',
            'created_at' => 'Created At',
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
                'userRanking.id' => $this->id,
                'userRanking.profit' => $this->profit,
                'userRanking.state' => $this->state,
                'userRanking.created_at' => $this->created_at,
            ])
            ->andFilterWhere(['like', 'userRanking.nickname', $this->nickname])
            ->andFilterWhere(['like', 'userRanking.face', $this->face])
            ->andFilterWhere(['like', 'userRanking.hot', $this->hot])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
}
