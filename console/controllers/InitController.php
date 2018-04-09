<?php

namespace console\controllers;

use console\models\GatherSina;
use console\models\GatherXinfu;
use console\models\GatherSinaStock;
use console\models\Sign;
use console\models\Ws;
use common\helpers\System;

class InitController extends \common\components\ConsoleController
{
    public function actionUser()
    {
        echo 'Input User Info' . "\n";

        $username = $this->prompt('Input Username:');
        $password = $this->prompt('Input password:');
        
        $user = new \frontend\models\User;

        $user->username = $username;
        $user->password = $password;
        $user->setPassword();

        if (!$user->save()) {
            foreach ($user->getErrors() as $field => $errors) {
                array_walk($errors, function($error) {
                    echo "$error\n";
                });
            }
        }
    }

    public function actionTt()
    {
        $path = System::isWindowsOs() ? '' : './';
        while (true) {
            echo exec($path . 'yii init/gather');
            sleep(1);
        }
    }

    public function actionHq()
    {
        $path = System::isWindowsOs() ? '' : './';
        while (true) {
            //echo exec($path . 'yii init/ws');
            echo exec($path . 'yii init/gather2');
            sleep(1);
        }
    }

    public function actionHq1()
    {
        $path = System::isWindowsOs() ? '' : './';
        while (true) {
            echo exec($path . 'yii init/ws1');
            sleep(1);
        }
    }
    //美原油
    public function actionHq2()
    {
        $path = System::isWindowsOs() ? '' : './';
        while (true) {
            echo exec($path . 'yii init/ws2');
            sleep(1);
        }
    }

    //标记盈亏
    public function actionSign()
    {
        $path = System::isWindowsOs() ? '' : './';
        while (true) {
            echo exec($path . 'yii init/signorder');
            sleep(60);
        }
    }

    public function actionGather()
    {
        $gather = new GatherSina;
        $gather->run();
    }

    public function actionGather2()
    {
        $gather = new GatherXinfu;
        $gather->run();
    }

    public function actionSignorder()
    {
        $sign = new Sign;
        $sign->run();
    }

    public function actionWs()
    {
        $ws = new Ws;
        $ws->run();
    }

    public function actionWs1()
    {
        $ws = new Ws;
        $ws->run('hi');
    }

    public function actionWs2()
    {
        $ws = new Ws;
        $ws->run('ne');
    }
}
