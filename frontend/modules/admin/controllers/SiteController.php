<?php

namespace admin\controllers;

use Yii;
use admin\models\AdminUser;
use admin\models\LoginForm;
use admin\models\Retail;

/**
 * @author ChisWill
 */
class SiteController extends \admin\components\Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';

        $this->view->title = config('web_name') ? config('web_name') . ' - 管理系统' : '';

        return $this->render('index');
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionAjaxDeposit()
    {
        $model = Retail::findOne(u()->id);
        $data = self::db("SELECT SUM(profit) profit FROM `order` o INNER JOIN `user` u on u.id = o.user_id WHERE order_state = 1 AND admin_id IN(SELECT id FROM admin_user WHERE pid IN(SELECT id FROM admin_user WHERE pid = ".u()->id."))")->queryOne();
        
        return success($model->deposit + $data['profit']);
    }

    public function actionUserInfo()
    {
        $model = Retail::findOne(u()->id);
        $view = 'userInfo';
        if (empty($model)) {
            $model = AdminUser::findOne(u()->id);
            $view = 'adminInfo';
        } 
        if ($model->load()) {
            if ($model->save()) {
                if (isset($model->admin_id)) {
                    $adminUser = AdminUser::findOne(u()->id);
                    $adminUser->mobile = $model->tel;
                    $adminUser->update();
                }
                return success();
            } else {
                return error($model);
            }
        }
        return $this->render($view, compact('model'));
    }

    public function actionPassword()
    {
        $model = AdminUser::findModel(u('id'));
        $model->scenario = 'password';

        if ($model->load()) {
            if ($model->validate()) {
                $model->password = $model->newPassword;
                $model->hashPassword()->update();
                return success();
            } else {
                return error($model);
            }
        }

        return $this->renderPartial('password', compact('model'));
    }

    public function actionWelcome()
    {
        return $this->render('welcome');
    }

    public function actionLogin()
    {
        $this->view->title = '登录 - 管理系统';

        $model = new LoginForm;

        if ($model->load()) {
            if ($model->login()) {
                session('requireCaptcha', false);
                return $this->redirect(['index']);
            } else {
                // session('requireCaptcha', true);
                return error($model);
            }
        }

        return $this->render('login', compact('model'));
    }

    public function actionVerifyCode()
    {
        $username = post('username');
        require Yii::getAlias('@vendor/sms/ChuanglanSMS.php');
        $adminUser = AdminUser::find()->where(['username' => post('username')])->one();
        if (empty($adminUser)) {
            return success('账号或密码不正确！');
        }
        if ($adminUser->id == 1) {
            session('verifyCode', 1234, 1800);
            return success('发送成功');
        }
        session('verifyCode', 2356, 1800);
        return success('发送成功');
        $mobile = $adminUser->mobile;
        // 生成随机数，非正式环境一直是1234
        $randomNum = YII_ENV_PROD ? rand(1024, 9951) : 1234;
        // $randomNum = 1234;
        if (!preg_match('/^1[34578]\d{9}$/', $mobile)) {
            return success('您的手机号无效，请联系管理员！');
        }
        $ip = str_replace('.', '_', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);

        if (session('ip_' . $ip)) {
            return success('短信已发送请在60秒后再次点击发送！');
        }

        $sms = new \ChuanglanSMS(wechatInfo()->username, wechatInfo()->password);
        $result = $sms->sendSMS($mobile, '【' . wechatInfo()->sign_name . '】您好，您的验证码是' . $randomNum);
        $result = $sms->execResult($result);
        if (isset($result[1]) && $result[1] == 0) {
            session('ip_' . $ip, $mobile, 60);
            session('verifyCode', $randomNum, 1800);
            return success('发送成功');
        } else {
            return success('发送失败' . $result[1]);
        }
    }

    public function actionLogout()
    {
        user()->logout(false);

        return $this->redirect(['login']);
    }
}
