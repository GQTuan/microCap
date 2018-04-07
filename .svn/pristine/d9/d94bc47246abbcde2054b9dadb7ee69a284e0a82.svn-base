<?php

namespace common\models;

use Yii;

/**
 * 这是表 `user_medal` 的模型
 */
class UserMedal extends \common\components\ARModel
{
    public function rules()
    {
        return [
            [['user_id', 'use_state', 'number'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'use_state' => '-1使用，1未使用',
            'number' => 'Number',
            'created_at' => '获得时间',
            'updated_at' => '使用时间',
        ];
    }

    /****************************** 以下为设置关联模型的方法 ******************************/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /****************************** 以下为公共显示条件的方法 ******************************/

    public function search()
    {
        $this->setSearchParams();

        return self::find()
            ->filterWhere([
                'userMedal.id' => $this->id,
                'userMedal.user_id' => $this->user_id,
                'userMedal.use_state' => $this->use_state,
                'userMedal.number' => $this->number,
            ])
            ->andFilterWhere(['like', 'userMedal.created_at', $this->created_at])
            ->andFilterWhere(['like', 'userMedal.updated_at', $this->updated_at])
            ->andTableSearch()
        ;
    }

    /****************************** 以下为公共操作的方法 ******************************/

    

    /****************************** 以下为字段的映射方法和格式化方法 ******************************/
    // Map method of field `UseState`
    public static function getUseStateMap($prepend = false)
    {
        $map = [
            self::STATE_VALID => '未使用',
            self::STATE_INVALID => '已使用',
        ];

        return self::resetMap($map, $prepend);
    }

    // Format method of field `UseState`
    public function getUseStateValue($value = null)
    {
        return $this->resetValue($value);
    }
}
