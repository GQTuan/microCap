<?php

/**
 * 优云宝支付配置参数 逻辑定义
 * Class AlipayPayment
 * @package Home\Payment
 */

class youyunbao
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
        $this->urlDo = URLDO;
        $this->do_key = DOKEY;

        $this->merchant_id = MERCHANT_APPID;

        $this->notify_url = url(['site/yyb-notify'], true);
        $this->main_conf = [
            'pid' => $this->merchant_id,
            'url' => $this->notify_url,
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
        $this->main_conf['money'] = $order['order_amount'];
        $this->main_conf['data'] = $order['order_sn'];//订单号
        $this->main_conf['lb'] = $order['pay_type'];//支付类型
        return self::buildRequestForm($this->main_conf, 'POST', '确认');
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