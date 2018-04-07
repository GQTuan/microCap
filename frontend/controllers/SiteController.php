<?php

namespace frontend\controllers;

use Yii;
use common\helpers\Curl;
use frontend\models\User;
use frontend\models\UserCoupon;
use frontend\models\Product;
use frontend\models\Order;
use frontend\models\ProductPrice;
use frontend\models\DataAll;
use frontend\models\UserPrize;
use frontend\models\Prize;
use frontend\models\UserIntegral;    
use frontend\models\Integral;    
use frontend\models\Retail;
use frontend\models\AdminDeposit;
use frontend\models\AdminUser;
use frontend\models\UserCharge;
use frontend\models\UserWithdraw;
use common\models\ProductParam;
use common\helpers\FileHelper;
use common\helpers\Json;

class SiteController extends \frontend\components\Controller
{
    public function beforeAction($action)
    {
        if(!config('web_state', 1)) {
            return $this->redirect('/user/maintain');
        }

        $actions = ['ajax-update-status', 'wxtoken', 'wxcode', 'test', 'captcha', 'zynotify', 'login', 'register', 'forget', 'update-user', 'verify-code', 'znnotify', 'outnotify', 'out-money', 'with-status', 'update'];
        if (user()->isGuest && !in_array($this->action->id, $actions)) {
            $this->redirect(['site/login']);
            return false;
            // $wx = session('wechat_userinfo');
            // if (!empty($wx)) {
            //     $user = User::find()->where(['open_id' => $wx['openid']])->one();
            //     $user->login(false);
            // } else {
            //     $code = get('code');
            //     if (empty($code)) {
            //         $this->redirect(['/wechart.php']);
            //         return false;
            //     } else {
            //         User::registerUser($code);
            //     }
            // }
        }
        if (!parent::beforeAction($action)) {
            return false;
        } else {
            return true;
        }
    }

    public function actionIndex()
    {
        $this->view->title = wechatInfo()->ring_name;
        //找三个上架的产品ON_SALE_YES
        $productArr = Product::getIndexProduct();
        if (!isset($productArr)) {
            return $this->redirect(['user/wrong']);
        }
        // 优惠券
        $count = UserCoupon::getAllUserCouponCount();
        //排名
        $rankings = self::db("SELECT * FROM `user_ranking` WHERE state=1 ORDER BY hot LIMIT 3")->queryAll();

        $user = User::findOne(u()->id);
        if ($user->admin_id == 0) {
            $user->admin_id = wechatInfo()->admin_id;
            $user->update();
        }
        return $this->render('index', compact('productArr', 'rankings', 'count'));
    }

    /********* 商城 - start *********/

    // 商城首页
    public function actionShop()
    {
        $this->view->title = '商城';
        $confirm_true = session('confirm_true');

        return $this->render('shop', compact('confirm_true'));
    }

    // 修改交易密码
    public function actionModify()
    {
        $this->view->title = '修改交易密码';
        return $this->render('modify');
    }

    // 商城详情
    public function actionDetail()
    {
        $this->view->title = '商品详情';
        return $this->render('detail');
    }

    // 确认订单
    public function actionConfirm()
    {
        $this->view->title = '确认订单';
        return $this->render('confirm');
    }

    // 支付
    public function actionPay()
    {
        $this->view->title = '支付订单';
        return $this->render('pay');
    }

    // 购物车
    public function actionCart()
    {
        $this->view->title = '购物车';
        return $this->render('cart');
    }

    // 个人中心
    public function actionMy()
    {
        $this->view->title = '个人中心';

        if (user()->isGuest) {
            return $this->redirect('/site/login');
        }
        $user = User::findModel(u()->id);
        $manager = '申请经纪人';
        //如果是经纪人
        if ($user->is_manager == User::IS_MANAGER_YES) {
            $manager = '我是经纪人';
        }
        $userCoupons = UserCoupon::find()->andWhere(['use_state' => UserCoupon::USE_STATE_WAIT, 'user_id' => u()->id])->andWhere(['>', 'number', 0])->andWhere(['>', 'valid_time', self::$time])->joinWith(['coupon'])->orderBy('amount ASC')->count();

        return $this->render('my', compact('manager', 'user', 'userCoupons'));


    }
    /********* 商城 - end *********/


    //期货的最新价格数据集
    public function actionAjaxNewProductPrice()
    {
        $name = post('data');
        //周末休市
        // if (date('w') == 6 || date('w') == 0) {
        //     return success(['name' => $name, 'price' => '休市', 'diff' => '休市', 'diff_rate' => '休市']);
        // }
        //期货的最新价格数据集
        $newData = DataAll::newProductPrice($name);
        if (!empty($newData)) {
            return success($newData->attributes);
        }
        return error('无此期货数据！');
    }

    //买涨买跌
    public function actionAjaxBuyState()
    {
        if (strlen(u()->password) <= 1) {
            return $this->redirect(['site/setPassword']);
        }
        //如果要体现必须要有手机号
        if (strlen(u()->mobile) <= 10) {
            return $this->redirect(['site/setMobile']);
        }
        $data = post('data');
        $productPrice = ProductPrice::find()->where(['id' => $data['id']])->with(['product'])->one();
        $data = $productPrice->attributes;
        $data['name'] = $productPrice->product->name;
        //查找用户体验卷
        $couponType = UserCoupon::getNumberType(0);
        $coupon['couponNum'] = array_sum($couponType);
        $coupon['couponTypeHtml'] = $this->renderPartial('_couponList', compact('couponType' , 'coupon'));
        
        return success($data, $coupon);
    }

    //产品参数
    public function actionAjaxProductConfig()
    {
        $productId = post('id');
        // $string = Product::getProductTradeTime($productId);
        $string = config('web_trade_time', '交易时间：周一至周五，9:00-23:00');
        if (Product::isTradeTime($productId)) {
            $isTime = 1;
        } else {
           $isTime = -1; 
        }
        $productPrice = ProductPrice::getSetProductPrice($productId);
        $product = Product::find()->andWhere(['id' => $productId])->with('dataAll')->one();
        return success(['list' => $this->renderPartial('_unitList', compact('productPrice')), 'isTime' => $isTime, 'time' => $string, 'price' => $product->dataAll->price], $productPrice);
    }

    //产品单位参数
    public function actionAjaxProductUnit()
    {
        $productPrice = ProductPrice::findModel(post('id'));
        return success($productPrice->one_profit);
    }
    //设置交易密码
    public function actionAjaxSetPassword()
    {
        $data = trim(post('data'));
        if (strlen($data) < 6) {
            return error('交易密码长度不能少于6位！');
        }
        $user = User::findModel(u()->id);
        $user->password = $data;
        if ($user->hashPassword()->save()) {
            $user->login(false);
            return success();
        }
        return error('设置失败！');
    }

    //全局控制用户跳转链接是否设置了交易密码
    public function actionAjaxOverallPsd()
    {
        if (strlen(u()->password) <= 1) {
            // return error($this->renderPartial('_setPsd'));
            return success(url(['site/setPassword']), -1);
        }
        //如果要体现必须要有手机号
        if (strlen(u()->mobile) <= 10) {
            return success(url(['site/setMobile']), -1);
        }
        return success(post('url'));
    }

    //第一次设置交易密码
    public function actionSetPassword()
    {
        $this->view->title = '请设置交易密码';
        if (strlen(u()->password) > 1) {
            return $this->success(Yii::$app->getUser()->getReturnUrl(url(['site/index'])));
        }
        $model = User::findModel(u()->id);
        $model->scenario = 'setPassword';
        if ($model->load(post())) {
            if ($model->validate()) {
                $model->hashPassword()->save(false);
                return $this->success(Yii::$app->getUser()->getReturnUrl(url(['site/index'])));
            } else {
                return error($model);
            }
        }
        $model->password = '';

        return $this->render('setPassword', compact('model'));
    }

    //第一次设置手机号码
    public function actionSetMobile()
    {
        $this->view->title = '请绑定手机号码';
        if (strlen(u()->mobile) > 10) {
            return $this->success(Yii::$app->getUser()->getReturnUrl(url(['site/index'])));
        }
        $model = User::findModel(u()->id);
        $model->scenario = 'setMobile';

        if ($model->load(post())) {
            $model->username = $model->mobile;
            if ($model->verifyCode != session('verifyCode')) {
                return error('短信验证码不正确');
            }
            if ($model->validate()) {
                $model->save(false);
                session('verifyCode', '');
                return $this->success(Yii::$app->getUser()->getReturnUrl(url(['site/index'])));
            } else {
                return error($model);
            }
        }
        $model->mobile = '';

        return $this->render('setMobile', compact('model'));
    }

    /**
     * @authname 抽奖
     */
    public function actionGetPrize()
    {
        $prize = new Prize;
        // 扣去积分
        $user =User::find()->where(['id' => u()->id])->one();
        if($user->integral <= 0) {
            return error('积分不够了');
        }
        $user->integral -= config('web_integral',10);
        if($user->integral < 0) {
            $user->integral = 0;
        }

        $user->save();
        $info = $prize->luckDraw();
        $info['integral'] = $user->integral;
        return success($info);
    }

    public function actionLottery()
    {
        test(); die;
        if (user()->isGuest) {
            return $this->redirect(['site/login']);
        }
        $this->view->title = '幸运抽奖';
        $user = User::find()->where(['id' => u()->id])->one();
        $integrals = floor($user->integral / config('web_integral',10));
        $prize = Prize::find()->all();
        return $this->render('lottery', compact('user', 'integrals', 'prize'));
    }

    /**
     * @authname 获取签到状态
     */
    public function actionGetSign()
    {
        $todayTime= date("Y-m-d 00:00:00");
        $userIntegral= UserIntegral::find()->where(['user_id' => u()->id, 'integral_types' => Integral::SIGN])->andWhere(['>', 'created_at', $todayTime])->one();
        if($userIntegral) {
            return true;
        }
    }

    /**
     * @authname  签到
     */
    public function actionSigns()
    {
        // 送积分
        $integral = new Integral;
        $info = $integral->getintegral(Integral::SIGN);  //具体的操作在Integral下的getintegral方法中
        if($info) {
            return true;
        }
    }

    public function actionRegister()
    {
        if (!user()->isGuest) {
             return $this->redirect(['site/index']);
        }
        $this->view->title = '注册';
        // $this->layout = 'empty';
        $model = new User(['scenario' => 'register']);

        if ($model->load(post())) {
            $model->username = $model->mobile;
            $wx = session('wechat_userinfo');
            if (!empty($wx)) {
                $model->face = $wx['headimgurl'];
                $model->open_id = $wx['openid'];
                $model->nickname = $wx['nickname'];
            }
            if ($model->validate()) {
                $retail = Retail::find()->joinWith(['adminUser'])->andWhere(['adminUser.power' => 9995])->andWhere(['retail.code' => $model->code])->one();
                if (!empty($retail)) {
                    $model->admin_id = $retail->adminUser->id;
                } else {
                    return error('请填写正确的邀请码(如果有邀请人手机号，邀请码可以为空！)');
                }
                if (!empty($model->open_id)) {
                    $user = User::find()->where(['open_id' => $model->open_id, 'username' => 0])->one();
                    if (!empty($user)) {
                        $user->mobile = $model->mobile;
                        $user->username = $model->mobile;
                        $user->nickname = $model->nickname;
                        $user->password = $model->password;
                        $user->admin_id = $model->admin_id;
                        $user->face = $model->face;
                        $user->hashPassword()->update(false);
                        $user->login(false);
                        return success(url(['site/index']));
                    }
                }
                $model->hashPassword()->insert(false);
                $model->login(false);
                return success(url(['site/index']));
                // return $this->goBack();
            } else {
                return error($model);
            }
        }
        //session微信数据
        User::getWeChatUser(get('code'));
        $wx = session('wechat_userinfo');
        $user = User::find()->where(['open_id' => $wx['openid'], 'username' => 0])->one();
        $model->code = '';
        if (!empty($user)) {
            $retail = Retail::find()->joinWith(['adminUser'])->where(['adminUser.id' => $user->admin_id])->one();
            $model->code = isset($retail)?$retail->code:'';
        }

        return $this->render('register', compact('model', 'user'));
    }

    public function actionLogin()
    {
        if (!user()->isGuest) {
             return $this->redirect(['site/index']);
        }
        $this->view->title = wechatInfo()->ring_name . '-登录';;
        // $this->layout = 'empty';
        $model = new User(['scenario' => 'login']);

        if ($model->load(post())) {
            $user = User::find()->where(['username' => $model->username])->one();
            if($user->state == User::STATE_INVALID) {
                return error('您的账户暂时不能登录');
            }
            if ($model->login()) {
                // 送积分
                $integral = new Integral;
                $integral->getintegral(Integral::LOG);
                return success(url('site/index'));
                // return $this->goBack();
            } else {
                return error($model);
            }
        }

        return $this->render('login', compact('model'));
    }

    public function actionWeChart()
    {
        $this->view->title = wechatInfo()->ring_name . '跳转';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='. WX_APPID . '&redirect_uri=http%3a%2f%2f' . $_SERVER['HTTP_HOST'] . '/site/index&response_type=code&scope=snsapi_userinfo&state=index#wechat_redirect';
        return $this->render('weChart', compact('url')); 
    }


    public function actionDetails()
    {
        $this->view->title = '商品详情';
        return $this->render('details', compact('url'));
    }

    public function actionBuy()
    {
        $this->view->title = '忘记密码';
        return $this->render('buy', compact('url')); 
    }



    public function actionForget()
    {
        $this->view->title = '忘记密码';
        // $this->layout = 'empty';
        $model = new User(['scenario' => 'forget']);
        if ($model->load(post())) {
            $user = User::find()->andWhere(['mobile' => post('User')['mobile']])->one();
            if (!$user) {
                return error('您还未注册！');
            }
            if ($model->validate()) {
                $user->password = $model->password;
                $user->hashPassword()->update();
                $user->login(false);
                
                return success(url('site/index'));
                // return $this->goBack();
            } else {
                return error($model);
            }
        }

        return $this->render('forget', compact('model'));
    }
    //投资学院
    public function actionInvestSchool()
    {
        $this->view->title = '忘记密码';
        return $this->render('investSchool');
    }

    public function actionLogout()
    {
        user()->logout(false);
        session('confirm_true', null);

        return $this->redirect(['site/login']);
    }

    // public function actionVerifyCode()
    // {
    //     $mobile = req('mobile');
    //     // 生成随机数，非正式环境一直是1234
    //     $randomNum = YII_ENV_PROD ? rand(1024, 9951) : 1234;
    //     $res = sendsms($mobile, $randomNum);
    //     // $res = ['info' => 'OK', 'code' => 2];
    //     if ($res['code'] == 2) {
    //         // 记录随机数
    //         session('verifyCode', $randomNum, 1800);
    //         return success($res['info']);
    //     } else {
    //         return error($res['info']);
    //     }
    // }


    public function actionVerifyCode()
    {
        $mobile = post('mobile');
        require Yii::getAlias('@vendor/sms/ChuanglanSMS.php');
        // 生成随机数，非正式环境一直是1234
        $randomNum = YII_ENV_PROD ? rand(1024, 9951) : 1234;
        // $res = sendsms($mobile, $randomNum);
        if (!preg_match('/^1[34578]\d{9}$/', $mobile)) {
            return success('您输入的不是一个手机号！');
        }
        $ip = str_replace('.', '_', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);

        if (session('ip_' . $ip)) {
            return success('短信已发送请在60秒后再次点击发送！');
        }

        $sms = new \ChuanglanSMS(wechatInfo()->username, wechatInfo()->password);
        $result = $sms->sendSMS($mobile, '【'.wechatInfo()->sign_name.'】您好，您的验证码是' . $randomNum);
        $result = $sms->execResult($result);
        // $randomNum = 1234;
        // $result[1] = 0;
        if (isset($result[1]) && $result[1] == 0) {
            session('ip_' . $ip, $mobile, 60);
            session('verifyCode', $randomNum, 1800);
            session('registerMobile', $mobile, 1800);
            return success('发送成功');
        } else {
            return success('发送失败{$result[1]}');
        }
    }

    /**
     * 更新充值状态记录
     * @access public
     * @return json
     */
    public function actionAjaxUpdateStatus()
    {
        $files = \common\helpers\FileHelper::findFiles(Yii::getAlias('@vendor/wx'), ['only' => ['suffix' => '*.php']]);
        array_walk($files, function ($file) {
            require_once $file;
        });
        $wxPayDataResults = new \WxPayResults();
        //获取通知的数据
        $xml = file_get_contents('php://input');
        //如果返回成功则验证签名
        try {
            $result = \WxPayResults::Init($xml);
            //这笔订单支付成功
            if ($result['return_code'] == 'SUCCESS') {
                $userCharge = UserCharge::find()->where('trade_no = :trade_no', [':trade_no'=>$result['out_trade_no']])->one();
                //有这笔订单
                if (!empty($userCharge)) {
                    if ($userCharge->charge_state == UserCharge::CHARGE_STATE_WAIT) {
                        $user = User::findOne($userCharge->user_id);
                        $user->account += floatval($userCharge->amount * (1 - config('charge_rate', '0')));
                        if ($user->save()) {
                            $userCharge->charge_state = 2;
                        }
                    }
                    $userCharge->update();
                    //输出接受成功字符
                    $array = ['return_code'=>'SUCCESS', 'return_msg' => 'OK'];
                    \WxPayApi::replyNotify($this->ToXml($array));
                    exit;
                }
            }
            test($result);
        } catch (\WxPayException $e){
            $msg = $e->errorMessage();
            self::db("INSERT INTO `test`(message, 'name') VALUES ('".$msg."', '微信回调')")->query();
            return false;
        }
    }

    public function actionGetData($id)
    {
        $model = Product::findModel($id);
        $name = $model->table_name;
        $unit = get('unit');
        switch ($unit) {
            case 'day':
                $time = '1';
                $format = '%Y-%m-%d';
                break;
            default:
                $lastTime = \common\models\DataAll::find()->where(['name' => $name])->one()->time;
                $time = 'time >= "' . date('Y-m-d 00:00:00', time() - 5 * 3600 * 24) . '"';
                $format = '%Y-%m-%d %H:%i';
                break;
        }

        $response = Yii::$app->response;

        $response->format = \yii\web\Response::FORMAT_JSON;

        $response->data = self::db('SELECT
                sub.*, cu.price close, UNIX_TIMESTAMP(DATE_FORMAT(time, "' . $format . '")) * 1000 time
        FROM
            (
                SELECT
                    min(d1.price) low,
                    max(d1.price) high,
                    d1.price open,
                    max(d1.id) id
                FROM
                    data_' . $name . ' d1
                where ' . $time . '
                group by
                    DATE_FORMAT(time, "' . $format . '")
            ) sub,
            data_' . $name . ' cu
        WHERE
            cu.id = sub.id')->queryAll();
        $response->send();
    }

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    private function ToXml($array)
    {
        $xml = "<xml>";
        foreach ($array as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }

    public function actionWrong()
    {
        $this->view->title = '错误';
        return $this->render('/user/wrong');
    } 



    /******************end首次token验证****************/
    public function actionWxtoken()
    {
        if (YII_DEBUG) {
            require Yii::getAlias('@vendor/wx/WechatCallbackapi.php');

            $wechatObj = new \WechatCallbackapi();
            echo $wechatObj->valid(); die;
        } else {
            $xml = file_get_contents('php://input');
            try {
                $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                //消息类型，event
                if (isset($array['MsgType']) && $array['MsgType'] == 'event') {
                    if (!isset($array['Event'])) {
                        return false;
                    }
                    // 用户未关注时，进行关注后的事件推送Event=>SCAN | 用户已关注时的事件推送 Event=>subscribe  Event=>SCAN
                    if (in_array($array['Event'], ['subscribe', 'SCAN'])) {
                        $isUser = User::find()->where(['open_id' => $array['FromUserName']])->one();
                        //关注欢迎语
                        if (!empty($isUser)) {
                            $result = wechatXml($array, '欢迎再次关注' . wechatInfo()->ring_name . '！'); 
                        } else {
                            $result = wechatXml($array, '欢迎关注' . wechatInfo()->ring_name . '！'); 
                        }

                        if (is_numeric($array['EventKey'])) {
                            //扫描经纪人进来的下线用户
                            User::isAddUser($array['FromUserName'], $array['EventKey']);
                        } elseif (isset($array['EventKey'])) {
                            $eventKey = explode('_', $array['EventKey']);
                            if (isset($eventKey[1])) {
                                //扫描经纪人进来的下线用户
                                User::isAddUser($array['FromUserName'], $eventKey[1]);
                            } else {
                                User::isAddUser($array['FromUserName']);
                            }
                        }

                        echo $result;die;
                    }

                    //华中服务 点击菜单拉取消息时的事件推送CLICK   EventKey   事件KEY值，与自定义菜单接口中KEY值对应
                    if ($array['Event'] == 'CLICK') {
                        require Yii::getAlias('@vendor/wx/WxTemplate.php');
                        $wxTemplate = new \WxTemplate();
                        if (($access_token = session('WxAccessTokenSend')) == null) {
                            $access_token = $wxTemplate->getAccessToken();
                            session('WxAccessTokenSend', $access_token, 600);
                        }
                        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $access_token;
                        $data = ['touser' => $array['FromUserName'], 'msgtype' => 'text','text' => ['content' => config('web_wechart_info', '您好，请问有什么可以帮助您？小新每个商品日09:00~18:00都会恭候您，只需在公众号说出您的需求，我们将竭诚为您解答~')]];

                        $json = Json::encode($data);

                        $result = Curl::post($url, $json, [
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_AUTOREFERER => true
                        ]);
                        echo 'success';die;
                    }
                }

                return false;
            } catch (Exception $e){
                return false;
            }
        }
    }

    public function actionNotify()
    {
        $serialize = serialize(post());

        // $serialize = 'a:1:{s:13:"paymentResult";s:674:"<Ips><GateWayRsp><head><ReferenceID></ReferenceID><RspCode>000000</RspCode><RspMsg><![CDATA[交易成功！]]></RspMsg><ReqDate>20161108150748</ReqDate><RspDate>20161108150846</RspDate><Signature>2eed493d33e9771bed47dc5151fe51f0</Signature></head><body><MerBillNo>BillNo478588834115</MerBillNo><CurrencyType>156</CurrencyType><Amount>0.01</Amount><Date>20161108</Date><Status>Y</Status><Msg><![CDATA[支付成功！]]></Msg><IpsBillNo>BO20161108150716028831</IpsBillNo><IpsTradeNo>2016110803114868511</IpsTradeNo><RetEncodeType>17</RetEncodeType><BankBillNo>7109343965</BankBillNo><ResultType>0</ResultType><IpsBillTime>20161108150846</IpsBillTime></body></GateWayRsp></Ips>";}';
        $xml = simplexml_load_string(unserialize($serialize)['paymentResult'], 'SimpleXMLElement', LIBXML_NOCDATA);
        preg_match('#.*(<body>.*</body>).*#Ui', $serialize, $match);
        $body = isset($match[1]) ? $match[1] : '';
        $MerCode = HX_ID;
        $mercert = HX_MERCERT;
        $sign = md5($body . $MerCode . $mercert);

        if ($sign == $xml->xpath("GateWayRsp/head/Signature")[0]) {
            $userCharge = UserCharge::find()->where('trade_no = :trade_no', [':trade_no' => $xml->GateWayRsp->body->MerBillNo])->one();
            //有这笔订单
            if (!empty($userCharge)) {
                if ($userCharge->charge_state == UserCharge::CHARGE_STATE_WAIT) {
                    $user = User::findOne($userCharge->user_id);
                    $user->account += $userCharge->amount;
                    if ($user->save()) {
                        $userCharge->charge_state = UserCharge::CHARGE_STATE_PASS;
                    }
                }
                $userCharge->update();
            }
        } else {
            //失败的测试
            throwex('支付失败,body:' . $body, 500);
        }
    }    

    //微信token验证
    public function actionWxcode()
    {
        require Yii::getAlias('@vendor/wx/WxTemplate.php');
        $wxTemplate = new \WxTemplate();
        if (($access_token = session('WxAccessToken')) == null) {
            $access_token = $wxTemplate->getAccessToken();
            session('WxAccessToken', $access_token, 7200);
        }
        tes($access_token);
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        $data = ['action_name' => 'QR_LIMIT_SCENE', 'action_info' => ['scene' => ['scene_id' => '100000']]];
        $json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            test($ch);
        } else {
            curl_close($ch);
            $object = json_decode($result);
            $qcode = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $object->ticket;
            test($qcode);
        }
        // $result = Curl::post($url, $json, ['CURLOPT_SSL_VERIFYPEER' => false, 'CURLOPT_SSL_VERIFYHOST' => false, 'CURLOPT_USERAGENT' => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)', 'CURLOPT_FOLLOWLOCATION' => 1, 'CURLOPT_AUTOREFERER' => 1, 'CURLOPT_RETURNTRANSFER' => true]);
        test($qcode);
    }     

    //微信token验证
    public function actionTest()
    {
        // $a = 1;

        test(1); die;
        // $start = '2017-06-07 00:00:00';
        // $stop = '2017-06-14 15:18:00';
        // $userCharges = UserCharge::find()->andWhere(['charge_state' => 2])->andWhere(['>', 'created_at', $start])->andWhere(['<', 'created_at', $stop])->all();
        // foreach ($userCharges as $userCharge) {
        //     $amount =  $userCharge->amount * (1000 - config('web_charge_fee', 6)) / 1000;
        //     $am = $userCharge->amount - $amount;
        //     $admin = AdminDeposit::find()->andWhere(['amount' => $amount])->andWhere(['>', 'created_at', $start])->andWhere(['<', 'created_at', $stop])->all();
        //     foreach ($admin as $admins) {
        //         $ams = $admins->amount - $am;
        //         $adminUsers = AdminUser::find()->with(['retail'])->where(['id' => $admins->admin_id])->all();
        //         foreach ($adminUsers as $adminUser) {
        //             $adminUser->retail->deposit += $ams;
        //             $adminUser->retail->save();
        //         }
        //     }
        // }
        $tableName = get('name', 'ne');
        $productList = [
            'ce' => [
               'name' => '德指',
               'url' => 'http://db2015.wstock.cn/wsDB_API2/stock.php?market=CE&u=a173199732&p=a173199732&num=5&r_type=2&query=Date,Symbol,Name,LastClose,Open,High,Low,NewPrice',
               'typeprefix' => ''
            ],
            'hi' => [
               'name' => '恒指',
               'url' => 'http://db2015.wstock.cn/wsDB_API2/stock.php?market=HI&u=a173199732&p=a173199732&num=55&r_type=2&query=Date,Symbol,Name,LastClose,Open,High,Low,NewPrice',
               'typeprefix' => ''
            ],
            'ne' => [
               'name' => '美原油',
               'url' => 'http://db2015.wstock.cn/wsDB_API2/stock.php?market=NE&u=a173199732&p=a173199732&num=5&r_type=2&query=Date,Symbol,Name,LastClose,Open,High,Low,NewPrice',
               'typeprefix' => ''
            ],
        ];
        
        $info = $productList[$tableName];
        $data = Curl::json($info['url']);
        $month = date('n') + 1;
        tes($data);
        if (!isset($data->errcode)) { //4003 Exceed Access frequency
            foreach ($data as $key => $val) {
                $name = false;
                switch ($tableName) {
                    case 'ce':
                        //小德指1
                        if ($val->Symbol == 'CEDAXA0') {
                            $name = 'ce1';
                        }
                        //小德指2
                        // if ($val->Name == 'DAX0'.$month) {
                        //     $name = 'ce2';
                        // }

                        break;
                    case 'hi':
                        // $num = $key + 1;
                        //恒指
                        if ($val->Symbol == 'HIMHIF') {
                            $name = 'hi1';
                        }

                        break;

                    case 'ne':
                        //美原油
                        switch ($val->Symbol) {
                            case 'NECLA0':
                                $name = 'ne1';
                                break;

                            // case 'NECLI0':
                            //     $name = 'ne2';
                            //     break;

                            // case 'NECLM0':
                            //     $name = 'ne3';
                            //     break;
                        }

                        break;
                    
                    default:
                        # code...
                        break;
                }
                if ($name) {
                    $info = [
                        'price' => $val->NewPrice,
                        'open' => $val->Open,
                        'high' => $val->High,
                        'low' => $val->Low,
                        'close' => $val->LastClose,
                        'diff' => 0,
                        'diff_rate' => 0,
                        'time' => $val->Date
                    ];
                    tes($name, $info);
                    // $this->insert($name, $info);
                }
            }
        }
        test('success');
    } 

    public function actionZynotify() //中云支付回调
    {
        $data = $_GET;
        if (isset($data['returncode']) && $data['returncode'] == '00') {
            $return = [
                "memberid" => $data["memberid"], // 商户ID
                "orderid" =>  $data["orderid"], // 订单号
                "amount" =>  $data["amount"], // 交易金额
                "datetime" =>  $data["datetime"], // 交易时间
                "returncode" => $data["returncode"]
            ];
            ksort($return);
            reset($return);
            $string = '';
            foreach($return as $key => $v) {
                $string .= "{$key}=>{$v}&";
            }
            $string .= "key=" . ZYPAY_KEY;
            $newSign = strtoupper(md5($string));
            if ($data['sign'] == $newSign) {
                $userCharge = UserCharge::find()->where('trade_no = :trade_no', [':trade_no' => $data['orderid']])->one();
                //有这笔订单
                if (!empty($userCharge)) {
                    $tradeAmount = $data['amount'];
                    if ($userCharge->charge_state == UserCharge::CHARGE_STATE_WAIT) {
                        $user = User::findOne($userCharge->user_id);
                        $user->account += $tradeAmount;
                        if ($user->save()) {
                            $userCharge->charge_state = UserCharge::CHARGE_STATE_PASS;
                        }
                    }
                    $userCharge->update();
                }
                exit('ok');
            }
        }
        exit('fail');
    }

    public function actionZnnotify() //中南支付回调
    {
        $data = $_POST;
        if ($data['return_code'] == '10000' && $data['trade_result'] == 'success') {
            $string = ZNPAY_ID . $data['out_trade_no']. $data['pay_num'] . $data['total_fee'] . ZNPAY_KEY;
            $newSign = strtoupper(md5($string));
            if ($data['sign'] == $newSign) {
                $userCharge = UserCharge::find()->where('trade_no = :trade_no', [':trade_no' => $data['pay_num']])->one();
                //有这笔订单
                if (!empty($userCharge)) {
                    $fee = $data['total_fee'] * config('web_charge_fee', 6) / 100000;
                    $amount = $data['total_fee'] / 100;
                    AdminDeposit::depositCharge($fee, $userCharge);
                    if ($userCharge->charge_state == UserCharge::CHARGE_STATE_WAIT) {
                        $user = User::findOne($userCharge->user_id);
                        $user->account += $amount;
                        if ($user->save()) {
                            $userCharge->charge_state = UserCharge::CHARGE_STATE_PASS;
                        }
                    }
                    $userCharge->update();
                }
                exit('success');
            }
        }
        exit('fail');
    }

    public function actionOutnotify() //出金回调
    {
        $data = $_POST;

        if (isset($data['return_code']) && $data['return_code'] == '10000') {
            $sign = strtoupper(md5(OUTPAY_ID . $data['trade_no'] . $data['pay_num'] . $data['total_fee'] . OUTPAY_KEY));
            if ($data['sign'] == $sign) {
                $model = UserWithdraw::find()->where(['op_state' => UserWithdraw::OP_STATE_MID, 'trade_no' => $data['pay_num']])->one();
                if (!empty($model)) {
                    $model->op_state = UserWithdraw::OP_STATE_PASS;
                    $model->update();
                }
            }
            echo 'success';die;
        }
        echo 'fail';die;
    }

    /**
    * @authname  投资学院页面
    */
    public function actionInvestment()
    {
        return $this->render('investment');
    }


    public function actionTransPwd()
    {
        return $this->render('transPwd');
    }

    //每五分钟执行一次出金脚本
    public function actionOutMoney()
    {
        // $models = UserWithdraw::find()->with('user.userAccount')->where(['op_state' => UserWithdraw::OP_STATE_WAIT])->all();
        // foreach ($models as $model) {
        //     $info = $model->outUserMoney();
        //     if (isset($info['return_code']) && $info['return_code'] == '10000') {
        //         $model->op_state = UserWithdraw::OP_STATE_MID;
        //     } else {
        //         $model->user->account += $model->amount + config('web_out_money_fee', 2);
        //         $model->user->update(); 
        //         $model->op_state = -1;
        //     }

        //     $model->update();
        // }
        test('success');
    } 

    //每30分钟查询一次出金状态
    public function actionWithStatus()
    {
        $models = UserWithdraw::find()->with('user.userAccount')->where(['op_state' => UserWithdraw::OP_STATE_MID])->all();
        foreach ($models as $model) {
            $info = $model->searchStatus();
            switch ($info['return_code']) {
                case '10000':
                    $model->op_state = UserWithdraw::OP_STATE_PASS;
                    break;

                case '10010':
                    $model->op_state = UserWithdraw::OP_STATE_MID;
                    break;

                case '10011':  //失败
                    $model->op_state = UserWithdraw::OP_STATE_DENY;
                    $model->user->account += $model->amount + config('web_out_money_fee', 2);
                    $model->user->update(); 
                    break;

                case '90009':  //余额不足
                    $model->op_state = UserWithdraw::OP_STATE_DENY;
                    $model->user->account += $model->amount + config('web_out_money_fee', 2);
                    $model->user->update(); 
                    break;
                
                default:
                    # code...
                    break;
            }
            $model->update();
        }
        echo 'success';exit;
    } 

    //每五分钟更新账户异常
    public function actionUpdateUser()
    {
        $bool = self::db('UPDATE `user` SET blocked_account= 0 WHERE blocked_account < 0')->queryAll();
        test($bool);
    } 

    //每天凌晨4点自动平仓
    public function actionUpdate()
    {
        $ids = self::db('SELECT id from `order` where order_state = ' . Order::ORDER_POSITION)->queryAll();
        array_walk($ids, function ($value) {
            Order::sellOrder($value['id'], true);
        });
        exit;
    } 
}
