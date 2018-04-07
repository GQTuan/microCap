<?php

namespace frontend\models;

use Yii;

class UserMedal extends \common\models\UserMedal
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
    public static function deleteUserMedal()
    {
        $userMedal = UserMedal::find()->andWhere(['user_id' =>u()->id, 'use_state' => UserMedal::STATE_VALID])->andWhere(['>', 'number', 0])->one();
        if($userMedal->number == UserMedal::STATE_VALID) {
            $userMedal->use_state = UserMedal::STATE_INVALID;
        }elseif($userMedal->number > UserMedal::STATE_VALID) {
            $userMedal->number -= UserMedal::STATE_VALID;
        }
        $userMedal->update();
    }
}
