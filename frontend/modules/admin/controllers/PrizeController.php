<?php

namespace admin\controllers;

use Yii;
use admin\models\Prize;
use admin\models\UserPrize;
use admin\models\User;
use admin\models\UserMedal;

class PrizeController extends \admin\components\Controller
{
    /**
     * @authname 奖品设置
     */
    public function actionPrizeList()
    {
        $query = Prize::find();

        $html = $query->getTable([
            'prize',
            'probability' => ['header' => '概率   %（总和不能大于100）','type' => 'text', 'width' => '20%'],
            'prize_num' => ['type' => 'text']
        ], [
            // 'addBtn' => ['createCoupon' => '添加代金券']
        ]);

        return $this->render('prizeList', compact('html'));
    }

    /**
     * @authname 奖品记录表
     */
    public function actionUserPrizelList()
    {
        $model = new UserPrize;
        $query = $model->search()->joinWith(['prize', 'user'])->orderBy('userPrize.created_at DESC');

        $html = $query->getTable([
            'user.nickname',
            'user.mobile',
            'prize.prize',
            'state',
            'created_at' => '获得时间'
        ], [
            'searchColumns' => [
                'user.nickname',
                'user.mobile',
            ]
        ]);

        return $this->render('userPrizelList', compact('html'));
    }

    /**
     * @authname 免死金牌记录表
     */
    public function actionMedalList()
    {
        $model = new UserMedal;
        $query = $model->search()->joinWith(['user'])->orderby('userMedal.created_at DESC');
        $html = $query->getTable([
            'user.nickname',
            'user.mobile',
            'use_state' => '状态',
            'number' => '数量',
            'created_at',
            'updated_at'
        ], [
            'searchColumns' => [
                'user.nickname',
                'user.mobile',
            ] 
        ]);
        return $this->render('medalList', compact('html'));
    }
}
