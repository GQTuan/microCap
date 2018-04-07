<?php

namespace frontend\components;

use Yii;
use frontend\models\User;

/**
 * frontend 控制器的基类
 */
class Controller extends \common\components\WebController
{
    public function init()
    {
        // if (!strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && YII_DEBUG) {
        //     $user = User::findModel('100001');
        //     $user->login(false);
        // }

        parent::init();
    }
    
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        } else {
            return true;
        }
    }
}
