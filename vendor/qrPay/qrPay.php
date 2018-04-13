<?php

class qrPay
{
    public $notify_url;
    public $urlDo;//接入互联网网关地址
    public $main_conf;
    public $do_key;
    public $merchant_id;

    /**
     * 析构流函数
     */
    public function  __construct() {
        $this->merchant_id = QR_PAY_USER_ID;
        $this->urlDo = QR_PAY_URL;
        $this->do_key = QR_PAY_USER_KEY;

        $this->notify_url = url(['site/qr-notify'], true);
        $this->main_conf = [
            'payType' => 'syt',
            'partner' => $this->merchant_id,
        ];

    }
    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $config_value    支付方式信息
     */
    function getPay($order)
    {
        //构造要请求的参数数组，无需改动
        $this->main_conf['orderId'] = $order['order_sn'];
        $this->main_conf['orderAmount'] = $order['order_amount'];//订单号
        $this->main_conf['version'] = '1.0';
        $this->main_conf['signType'] = 'MD5';
        $this->main_conf['payMethod'] = $order['pay_method'];// 11：微信22：支付宝33:QQ支付
        $this->main_conf['notifyUrl'] = $this->notify_url;
        ksort($this->main_conf);
        $sign = self::createSign($this->main_conf);
        $this->main_conf['sign'] = $sign;

        return self::buildRequestForm($this->main_conf, 'POST', '确认');
    }
    public function createSign($parameters)
    {
        unset($parameters['notifyUrl']);
        $stringToRequest = "";
        $i = 0;
        foreach ($parameters as $k => $v) {
            if ($i == 0) {
                $stringToRequest .= "$k" . "=" . "$v";
            } else {
                $stringToRequest .= "&" . "$k" . "=" . "$v";
            }
            $i++;
        }
        $sign = md5($stringToRequest.$this->do_key);
        $sign = strtoupper($sign);
        return $sign;
    }

    function buildRequestForm($para_temp, $method, $button_name="确认") {
        //待请求参数数组
        $para = $para_temp;
        $sHtml = "<form style='display:none' id='myform' name='myform' action='".$this->urlDo."' method='".$method."'>";
        while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";

        $sHtml = $sHtml."<script>document.forms['myform'].submit();</script>";

        return $sHtml;
    }

}