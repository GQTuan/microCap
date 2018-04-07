<?php

namespace common\models;

use Yii;

/**
 * 这是表 `user_prize` 的模型
 */
class UserPrize extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['prize_id', 'state'], 'string', 'max' => 100]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'prize_id' => '奖项id',
            'state' => '状态',
            'created_at' => '获得时间',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPrize()
    {
        return $this->hasOne(Prize::className(), ['prizes_id' => 'prize_id']);
    }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'userPrize.id' => $this->id,
                'userPrize.user_id' => $this->user_id,
            ])
            ->andFilterWhere(['like', 'userPrize.prize_id', $this->prize_id])
            ->andFilterWhere(['like', 'userPrize.state', $this->state])
            ->andFilterWhere(['like', 'userPrize.created_at', $this->created_at])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
    // Map method of field `State`
    public static function getStateMap($prepend = false)
    {
        $map = [
            self::STATE_VALID => '已领取',
            self::STATE_INVALID => '未领取',
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `State`
    public function getStateValue($value = null)
    {
        return $this->resetValue($value);
    }
}
