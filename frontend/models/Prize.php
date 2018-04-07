<?php

namespace frontend\models;

use Yii;

class Prize extends \common\models\Prize
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
     * @authname 抽奖
     */
    public function luckDraw()
    {
        $prize_arr = Prize::find()->all();
        function getRand($proArr) { 
            $data = ''; 
            $proSum = array_sum($proArr); //概率数组的总概率精度  
            foreach ($proArr as $k => $v) { //概率数组循环 
                $randNum = mt_rand(1, $proSum); 
                if ($randNum <= $v) { 
                    $data = $k; 
                    break; 
                }else { 
                    $proSum -= $v; 
                } 
            } 
            unset($proArr); 
         
            return $data; 
        }
        foreach ($prize_arr as $v) { 
            $arr[$v['prizes_id']] = $v['probability']; 
        } 
        $prize_id = getRand($arr); //根据概率获取奖项id  
         
        $res = $prize_arr[$prize_id - 1]; //中奖项  
        $min = $res['min']; 
        $max = $res['max']; 
        // if ($res['id'] == 7) { //七等奖  
            // $i = mt_rand(0, 5); 
            // $data['angle'] = mt_rand($min, $max); 
        // } else { 
        $data['angle'] = mt_rand($min, $max); //随机生成一个角度  
        // } 
        $data['prize'] = $res['prize'];
        // 添加用户记录

        $userPrize = new UserPrize;
        $userPrize->user_id = u()->id;
        $userPrize->prize_id =  $res['prizes_id'];
        $userPrize->insert(false);
        return $data;
    }
}
