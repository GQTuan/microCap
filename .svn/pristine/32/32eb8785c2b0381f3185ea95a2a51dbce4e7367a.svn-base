<?php

namespace admin\controllers;

use Yii;
use admin\models\Integral;
use admin\models\UserIntegral;
use admin\models\User;

class IntegralController extends \admin\components\Controller
{
    /**
     * @authname 积分列表
     */
    public function actionIntegralList()
    {
        $query = Integral::find();

        $html = $query->getTable([
            'integral_type',
            'integral_value' => ['type' => 'text'],
            // 'desc' => ['type' => 'text'],
        ], [
            // 'addBtn' => ['createCoupon' => '添加代金券']
        ]);

        return $this->render('integralList', compact('html'));
    }

    /**
     * @authname 积分记录表
     */
    public function actionUserIntegralList()
    {
        $model = new UserIntegral;
        $query = $model->search()->joinWith(['integral', 'user'])->orderBy('userIntegral.created_at desc');

        $html = $query->getTable([
            'user.nickname',
            'user.mobile',
            'integral_types',
            'integral_value',
            'created_at' => '获得时间'
        ], [
            'searchColumns' => [
                'user.nickname',
                'user.mobile',
            ]
        ]);

        return $this->render('userIntegralList', compact('html'));
    }
}
