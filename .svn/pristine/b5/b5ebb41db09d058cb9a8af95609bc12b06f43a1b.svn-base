<?php

namespace frontend\models;

use Yii;

class Integral extends \common\models\Integral
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
    /**
     * @authname  赠送积分
     */
    public function getintegral($type)
    {
        $todayTime= date("Y-m-d 00:00:00");
        $userIntegral= UserIntegral::find()->where(['user_id' => u()->id, 'integral_types' => $type])->andWhere(['>', 'created_at', $todayTime])->one();
        if(empty($userIntegral)){
            $integral = Integral::find()->where(['integral_type' => $type])->one();
            if(!empty($integral)){
                $user = User::find()->where(['id' => u()->id])->one();
                $user->integral += $integral->integral_value;
                $user->save();
                $userIntegrals = new UserIntegral;
                $userIntegrals->integral_types = $type;
                $userIntegrals->user_id = u()->id;
                $userIntegrals->integral_value = $integral->integral_value;
                $userIntegrals->save();
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }

    }
}
