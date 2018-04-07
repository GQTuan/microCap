<?php

namespace admin\models;

use Yii;
use common\helpers\Html;

class User extends \common\models\User
{
    public $out_account;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['account', 'number', 'min' => '0', 'tooSmall' => '余额不足以出金！'],
            [['out_account'], 'safe'],
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
            'state' => '状态',
            // 'field2' => 'description2',
        ]);
    }

    public function getParentLink($name = 'id')
    {
        if ($this->pid) {
            return Html::a($this->parent->nickname, ['', 'search[' . $name . ']' => $this->pid], ['class' => 'parentLink']);
        } else {
            return '无';
        }
    }

    public function listQuery()
    {
        return $this->search()
            ->joinWith(['parent', 'admin'])
            ->andFilterWhere(['>', 'user.created_at', $this->created_at]);
    }

    public function managerQuery()
    {
        return $this->search()
            ->with(['parent', 'userExtend', 'admin'])
            ->manager()
            ->andWhere(['is_manager' => User::IS_MANAGER_YES]);
    }

    public function managerListQuery()
    {
        return $this->search()
            ->joinWith(['parent', 'userExtend', 'admin'])
            ->manager()
            ->andWhere(['user.is_manager' => User::IS_MANAGER_YES]);
    }
}
