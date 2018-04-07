<?php

namespace frontend\models;

use Yii;
use common\helpers\FileHelper;

class UserCharge extends \common\models\UserCharge
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

    //中云第三方支付 ShaoBeiZfb
    public static function payExchange($reurl, $amount, $acquirer_type = 'WXZF', $tongdao = 'WftWx')
    {
        //保存充值记录
        $userCharge = new UserCharge();
        $userCharge->user_id = u()->id;
        $userCharge->trade_no = u()->id . date("YmdHis") . rand(1000, 9999);
        $userCharge->amount = $amount;
        $userCharge->charge_state = self::CHARGE_STATE_WAIT;
        if ($acquirer_type == 'alipay') {
            $userCharge->charge_type = self::CHARGE_TYPE_ALIPAY;
        }
        if (!$userCharge->save()) {
            return false;
        }
        // 微信、支付宝交易
        $url = 'http://zf.cnzypay.com/Pay_Index.html';

        $data['pay_memberid'] = ZYPAY_ID; //商户id
        $data['pay_orderid'] = $userCharge->trade_no;
        $data['pay_amount'] = $amount;
        $data['pay_applydate'] = self::$time; //请求时间
        $data['pay_bankcode'] = $acquirer_type; //银行编号
        $data['pay_notifyurl'] = url(['site/zynotify'], true); //异步回调地址  融智付异步商户url
        $data['pay_callbackurl'] = 'http://' . $reurl . '/site/index'; //页面返回地址
        // 商户id、应用id、商户订单号、订单金额、加密key
        $string = '';
        ksort($data);
        reset($data);
        foreach($data as $key => $v) {
            $string .= "{$key}=>{$v}&";
        }
        $string .= "key=" . ZYPAY_KEY;
        $data['tongdao'] = $tongdao;
        $data['pay_md5sign'] = strtoupper(md5($string));
        if ($tongdao == 'WftGzh') {
            $str = '<form id="Form1" name="Form1" method="post" action="' . $url . '">';
            foreach ($data as $key => $val) {
                $str = $str . '<input type="hidden" name="' . $key . '" value="' . $val . '">';
            }
            $str = $str . '<input type="hidden" value="提交">';
            $str = $str . '</form>';
            $str = $str . '<script>';
            $str = $str . 'document.Form1.submit();';
            $str = $str . '</script>';
            return $str;
        }
        $result = httpRequest($url, $data);
        preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $result, $match);
        if (isset($match[2])) {
            return 'http://zf.cnzypay.com/' . $match[2];
        }
        return false;
    }

    //易支付银行卡绑定
    public static function epayBankCard($bankCard)
    {
        // test($bankCard->bank_name);
        $data['ORDER_ID'] = u()->id . date("YmdHis");
        $data['ORDER_TIME'] = date("YmdHis");
        $data['USER_TYPE'] = '02';
        $data['USER_ID'] = EXCHANGE_ID;
        $data['SIGN_TYPE'] = '03';
        $data['BUS_CODE'] = '1011';
        $data['CHECK_TYPE'] = '01';
        $data['ACCT_NO'] = $bankCard->bank_card;  // 卡号
        $data['PHONE_NO'] = $bankCard->bank_mobile; //  手机号
        $data['ID_NO'] = $bankCard->id_card;

        $string = '';
        foreach($data as $key => $v) {
            $string .= "{$key}={$v}&";
        }
        $signSource = $string . EXCHANGE_MDKEY;
        // tes($signSource);
        $mdStr = strtoupper(md5($signSource)); //加密算法第一步大写
        $data['SIGN'] = strtoupper(substr(md5($mdStr . EXCHANGE_MDKEY), 8, 16)); //16位的md5
        $data['NAME'] = $bankCard->bank_user; // 姓名
        $value = '';
        foreach($data as $key => $v) {
            $value .= "{$key}={$v}&";
        }
        $value = substr($value, 0, strlen($value)-1);
        // tes($data, $value);
        // $url = 'http://163.177.40.37:8888/NPS-API/controller/pay';
        $url = 'http://npspay.yiyoupay.net/NPS-API/controller/pay';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $value);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $str = "<RESP_CODE>0000</RESP_CODE>";
        if(strpos($result,$str)) {
            return true;
        }else {
            return false;
        }
    }

    //第三方支付
    public static function payExtend($amount)
    {
        //保存充值记录
        $userCharge = new UserCharge();
        $userCharge->user_id = u()->id;
        $userCharge->trade_no = u()->id . date("YmdHis");
        $userCharge->amount = $amount;
        $userCharge->charge_type = self::CHARGE_TYPE_HUAN;
        $userCharge->charge_state = UserCharge::CHARGE_STATE_WAIT;
        if (!$userCharge->save()) {
            return false;
        }
        if (0 && System::isMobile()) {
            $url = 'https://mobilegw.ips.com.cn/psfp-mgw/paymenth5.do';
        } else {
            $url = 'https://newpay.ips.com.cn/psfp-entry/gateway/payment.do';
        }
        $MerCode = HX_ID;
        $Account = HX_TID;
        $mercert = HX_MERCERT;
        $MerBillNo = $userCharge->trade_no;
        $Amount = YII_DEBUG ? '0.01' : $userCharge->amount . '.00';
        $Date = date('Ymd');
        $GatewayType = '01'; //借记卡：01，信用卡02，IPS账户支付03
        $Merchanturl = HX_RETURN_URL ?: req()->hostInfo;
        $ServerUrl = HX_NOTIFY_URL ?: req()->hostInfo . '/site/notify';// 支付成功回调
        $GoodsName = config('web_name') . '_用户充值';
        $MsgId = 'm'. $MerBillNo;
        $ReqDate = date('Ymdhis');

        $ips = '<Ips><GateWayReq>';
        $body = "<body><MerBillNo>{$MerBillNo}</MerBillNo><Amount>{$Amount}</Amount><Date>{$Date}</Date><CurrencyType>156</CurrencyType ><GatewayType>{$GatewayType}</GatewayType><Lang>GB</Lang><Merchanturl>{$Merchanturl}</Merchanturl><FailUrl></FailUrl><Attach></Attach><OrderEncodeType>5</OrderEncodeType><RetEncodeType>17</RetEncodeType><RetType>1</RetType><ServerUrl>{$ServerUrl}</ServerUrl><BillEXP>1</BillEXP><GoodsName>{$GoodsName}</GoodsName><IsCredit>0</IsCredit><BankCode></BankCode><ProductType>0</ProductType></body>";
        $Signature = md5($body . $MerCode . $mercert);
        $head = "<head><Version>v1.0.0</Version><MerCode>{$MerCode}</MerCode><MerName></MerName><Account>{$Account}</Account><MsgId>{$MsgId}</MsgId><ReqDate>{$ReqDate}</ReqDate><Signature>{$Signature}</Signature></head>";
        $ips .= $head;
        $ips .= $body;
        $ips .= '</GateWayReq></Ips>';
        return ['url' => $url, 'content' => $ips];
    }

    //中南支付
    public static function znpay($amount, $pay_type = 'wxpay')
    {
        $amount = sprintf("%.2f", $amount);
        $user = User::findModel(u()->id);
        $bankCard = BankCard::find()->where(['user_id' => $user->id])->one();
        // test($pay_type);
        //保存充值记录
        $userCharge = new UserCharge();
        $userCharge->user_id = $user->id;
        $userCharge->trade_no = $user->id . date("YmdHis") . rand(1000, 9999);
        $userCharge->amount = $amount;
        $userCharge->charge_type = self::CHARGE_TYPE_ZFWECHART;
        if ($pay_type == 'alipay') {
            $userCharge->charge_type = self::CHARGE_TYPE_ALIPAY;
        }
        $userCharge->charge_state = self::CHARGE_STATE_WAIT;
        if (!$userCharge->save()) {
            return false;
        }
        $url = 'http://api.zhongnanpay.com:3022/hmpay/online/createWxOrder.do';
        $data['merchant_no'] = ZNPAY_ID; //商户id
        $data['total_fee'] = $amount * 100;
        $data['pay_num'] = $userCharge->trade_no;
        $data['notifyurl'] =  url(['site/znnotify'], true); //异步回调地址  融智付异步商户url
        $string = $data['merchant_no'] . $data['total_fee'] . date("Ymd") . ZNPAY_KEY;
        $data['sign'] = md5($string);//验证签名    sign    必填，sign = MD5(merchant_no+total_fee+today+key)；
        $data['pay_type'] = $pay_type;
        if ($pay_type == 'qkpay') {
            $data['return_url'] = url(['site/index'], true);
            $data['card_no'] = $bankCard->bank_card;
            $str = '<form id="Form1" name="Form1" method="post" action="' . $url . '">';
            foreach ($data as $key => $val) {
                $str = $str . '<input type="hidden" name="' . $key . '" value="' . $val . '">';
            }
            $str = $str . '<input type="hidden" value="提交">';
            $str = $str . '</form>';
            $str = $str . '<script>';
            $str = $str . 'document.Form1.submit();';
            $str = $str . '</script>';
            return $str;
        }

        $result = httpRequest($url, $data);
        $object = json_decode($result);
        if (isset($object->return_code) && $object->return_code == '10000') {
            //生成二维码
            require Yii::getAlias('@vendor/phpqrcode/phpqrcode.php');
            $codeUrl = $object->code_url; //二维码内容
            $errorCorrectionLevel = 'L';//容错级别   
            $matrixPointSize = 6;//生成图片大小   
            $filePath = Yii::getAlias('@webroot/' . config('uploadPath') . '/znpay/');
            FileHelper::mkdir($filePath);
            $src = $filePath . $pay_type . $user->id . '.png';
            //生成二维码图片   
            \QRcode::png($codeUrl, $src, $errorCorrectionLevel, $matrixPointSize, 2);
            return config('uploadPath') . '/znpay/' . $pay_type . $user->id . '.png';  
        }
        return false;
    }
}
