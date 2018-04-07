<?php

namespace admin\models;

use Yii;

class UserRanking extends \common\models\UserRanking
{
    public $file1;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['file1'], 'file', 'extensions' => 'jpg, png', 'skipOnEmpty' => true, 'maxSize' => 1024 * 2 * 1000],
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
            'file1' => '头像',
            // 'field2' => 'description2',
        ]);
    }
}
