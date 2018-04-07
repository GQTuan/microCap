<?php

namespace frontend\models;

use Yii;
use common\helpers\ImagesUploadFile;
use frontend\components\WebUser;
use common\helpers\FileHelper;
use common\models\AdminUser;
use common\helpers\System;

class User extends \common\models\User
{
    // 虚拟字段
    public $oldPassword;
    public $withdrawPassword;
    public $newPassword;
    public $cfmPassword;
    public $rememberMe;
    public $confirmDeal;
    public $newDealPassword;
    public $verifyCode;
    public $captcha;
    public $code;
    public $adminId;

    protected $_identity;

    public function rules()
    {
        return array_merge(parent::rules(), [
            // 密码规则，注册和修改密码时复用同一个规则
            [['password', 'newPassword'], 'match', 'pattern' => '/[a-z0-9~!@#$%^]{6,}/Ui', 'on' => ['register', 'password', 'forget'], 'message' => '{attribute}至少6位'],
            // 注册场景的基础验证
            [['cfmPassword', 'verifyCode', 'code', 'nickname', 'mobile'], 'required', 'on' => ['register', 'forget']],
            //注册经纪人
            [['oldPassword', 'cfmPassword', 'verifyCode'], 'required', 'on' => ['managerReg']],
            //第一次填写手机号
            // [['mobile'], 'required', 'on' => ['setMobile1']],
            // 注册场景密码和确认密码的验证
            [['password'], 'compare', 'compareAttribute' => 'cfmPassword', 'on' => ['register', 'forget', 'setPassword']],
            //经纪人注册验证
            [['oldPassword'], 'compare', 'compareAttribute' => 'cfmPassword', 'on' => ['managerReg']],
            // 修改密码场景的基础验证
            [['oldPassword', 'newPassword', 'cfmPassword'], 'required', 'on' => ['password']],
            // 用户提现
            [['withdrawPassword'], 'required', 'on' => ['withdraw']],
            // 修改密码验证旧密码
            [['oldPassword'], 'validateOldPassword'],
            // 修改手机号
            [['mobile', 'verifyCode'], 'required', 'on' => ['changePhone', 'setMobile']],
            // 提现验证密码
            [['withdrawPassword'], 'validateWithdrawPassword', 'on' => ['withdraw']],
            // 修改密码场景新密码与验证密码的验证
            [['newPassword'], 'compare', 'compareAttribute' => 'cfmPassword'],
            // 短信验证码
            [['verifyCode'], 'verifyCode'],
            [['invide_code'], 'verifyCode'],
            // 验证码
            [['captcha'], 'captcha'],
            [['newDealPassword', 'confirmDeal'], 'required', 'on' => 'deal_password'],
            [['newDealPassword', 'confirmDeal'], 'match', 'pattern' => '/[a-z0-9~!@#$%^]{6,}/Ui', 'on' => ['deal_password'], 'message' => '{attribute}至少6位'],
            [['newDealPassword'], 'compare', 'compareAttribute' => 'confirmDeal', 'on' => ['deal_password']],
          
        ]);
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'register' => ['mobile','password', 'cfmPassword', 'verifyCode','code'],
            'login' => ['username', 'password', 'rememberMe'],
            'password' => ['oldPassword', 'newPassword', 'cfmPassword'],
            'forget' => ['password', 'cfmPassword', 'verifyCode', 'mobile'],
            'changePhone' => ['mobile', 'verifyCode'],
            'setPassword' => ['password', 'cfmPassword'],
            'setMobile' => ['mobile', 'verifyCode'],
            'withdraw' => ['withdrawPassword'],
            'managerReg' => ['oldPassword', 'cfmPassword', 'verifyCode'],
            'deal_password' => ['newDealPassword', 'confirmDeal']

        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'oldPassword' => '旧密码',
            'newPassword' => '新密码',
            'cfmPassword' => '确认密码',
            'rememberMe' => '记住我',
            'verifyCode' => '短信验证码',
            'withdrawPassword' => '交易密码',
            'captcha' => '动态码',
            'code' => '邀请码',
            'newDealPassword' => '交易密码',
            'confirmDeal' => '确认交易密码'
        ]);
    }

    public function verifyCode()
    {
        if ($this->verifyCode != session('verifyCode')) {
            $this->addError('verifyCode', '短信验证码不正确');
        }
    }

    public function validateOldPassword()
    {
        if (!u()->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', '旧密码不正确');
        }
    }

    public function validateWithdrawPassword()
    {
        if (!u()->validatePassword($this->withdrawPassword)) {
            $this->addError('withdrawPassword', '交易密码不正确！');
        }
    }

    protected function beforeLogin()
    {
        if (!$this->username) {
            $this->addError('username', '请输入用户名');
        }
        if (!$this->password) {
            $this->addError('password', '请输入密码');
        }
        if ($this->hasErrors()) {
            return false;
        }

        $identity = $this->getIdentity();
        if (!$identity || !$identity->validatePassword($this->password)) {
            $this->addError('password', '用户名或密码错误');
            return false;
        } else {
            return true;
        }
    }

    protected function getIdentity()
    {
        if ($this->_identity === null) {
            $this->_identity = WebUser::find()->where(['username' => $this->username])->one();
        }

        return $this->_identity;
    }

    public function login($runValidation = true)
    {
        if ($runValidation && !$this->beforeLogin()) {
            return !$this->hasErrors();
        }
        // session('verifyCode', null);

        return user()->login($this->getIdentity(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    public static function getWeChatUser($code = '')
    {
        $files = \common\helpers\FileHelper::findFiles(Yii::getAlias('@vendor/wx'), ['only' => ['suffix' => '*.php']]);
        array_walk($files, function ($file) {
            require_once $file;
        });

        $info = session('wechat_userinfo');
        if (empty($info)) {
            if (!empty($code)) {
                $wx = new \WxTemplate();
                $info = $wx->getWechatUser($code);

                session('wechat_userinfo', $info, 144000);
            } else {
                test('请在微信里登录！');
                return false;
            }
        }
    }

    //微信注册用户
    public static function registerUser($code = '')
    {
        //session微信数据
        self::getWeChatUser($code);
        $wx = session('wechat_userinfo');
        $user = User::find()->where(['open_id' => $wx['openid']])->one();
        if (empty($user)) {
            $user = new User();
            $user->face = $wx['headimgurl'];
            $user->nickname = $wx['nickname'];
            $user->open_id = $wx['openid'];
            $user->username = 0;
            $user->mobile = 0;
            $user->password = 0;
            $user->insert(false);
            $user = User::find()->where(['open_id' => $wx['openid']])->one();
        }
        //如果是消息推送进来的，没有头像 
        if ($user->face == 0) {
            $user->face = $wx['headimgurl'];
            $user->nickname = $wx['nickname'];
            $user->update();
        }
        $user->login(false);
    }

    //是否增加一个新用户
    public static function isAddUser($openid, $pid = 0)
    {
        $user = User::find()->where(['open_id' => $openid])->one();
        if (empty($user)) {
            $user = new User();
            $user->face = 0;
            $user->nickname = 0;
            $user->open_id = $openid;
            $user->username = 0;
            $user->mobile = 0;
            $user->password = 0;
            $user->insert(false);
        }
        // $ringWechat = RingWechat::find()->where(['url' => $_SERVER['HTTP_HOST']])->one();
        $managerUser = User::find()->where(['manager_id' => $pid, 'is_manager' => self::IS_MANAGER_YES, 'member_id' => wechatInfo()->admin_id])->one();

        if (!empty($managerUser)) {
            if (empty($user->pid)) {
                $user->pid = $managerUser->id;
            }
            //如果不是经纪人
            if (empty($user->admin_id)) {
                $user->admin_id = $managerUser->admin_id;
            }
            $user->update();
        }
    }

    //每个用户生成一个二维码
    public static function isHaveUserCode()
    {
        $filePath = Yii::getAlias('@webroot/' . config('uploadPath') . '/images/');
        FileHelper::mkdir($filePath);
        $src = $filePath . 'code_' . u()->id . '.jpg';
        if (!file_exists($src)) {
            $url = UserExtend::getManagerCodeImg();
            $data = file_get_contents($url);
            $src = $filePath . 'code_' . u()->id . '.jpg';
            file_put_contents($src, $data);
            return true;
        }
    }

    //直属客户搜索
    public function customerQuery($array)
    {
        $this->load(get());
        return $this->search()
                    ->andWhere(['in', 'id', $array])
                    ->andWhere(['state' => self::STATE_VALID])
                    ->andFilterWhere(['like', 'mobile', $this->mobile])
                    ->orderBy('created_at DESC');
    }
    /**
     * 头像修改
     * @return bool
     */
    public function saveAvatar()
    {
        if(isset($_FILES['avatar']['name'])) {
            $result = ImagesUploadFile::uploadFiles('avatar');
            $result = json_decode($result, true);
            if($result['code'] == 0)
            {
                $user = User::findOne(u()->id);
                $user->face = $result['data']['url'].$result['data']['new_name'];
                if($user->update()) return true;
            }
        }
        return false;
    }
}
