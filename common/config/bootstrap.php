<?php
/**
 * 公共常量定义
 */
const PAGE_SIZE = 10;
const THEME_NAME = 'basic';
const SECRET_KEY = 'ChisWill';

const WX_APPID = 'wxe98733d8a93debfe';
const WX_MCHID = '1408477002';
const WX_KEY = 'VKcJg2LUnnRPjmYtPX3Tfm8vqradppF9';
const WX_APPSECRET = 'c9c25283bacee3469ff3edf1a4eb8477';
const WX_TOKEN = 'jgZBoGWXMKzwixhJ';

const HX_ID = '182017';
const HX_TID = '1820170015';
const HX_MERCERT = 'yAhvTKEWKupquqvvkcVN0AwhKzEoo6MA0xDT7t0okTmQ4fXB3wRN85HLE55pV10ROlALRJEWRTJESMd10zglSQYmRMMWeg2v3LbPpA0oOXzMaD5RL2STrD6FtZq5dOnY';
const HX_RETURN_URL = '';// 如果不设置，表示支付完成后，回到当前域名的主页
const HX_NOTIFY_URL = '';// 如果不设置，表示支付完成后，异步通知将访问当前域名的`site/notify`
const ZH_PAY_DOMAIN = 'http://pay.pifawenju.cn';

//中云支付
const ZYPAY_ID = '12191';
const ZYPAY_KEY = 'PtzoxIimfUKIGxFVd38JaKttAiXImV';

//中南支付
const ZNPAY_ID = '168666999001180';
const ZNPAY_KEY = 'ppyqdid95zg4s4wk';

//代付
const OUTPAY_ID = '162666000001219';
const OUTPAY_KEY = 'yp9ju3oujnesfab1';

const ATTR_CREATED_AT = 'created_at';
const ATTR_CREATED_BY = 'created_by';
const ATTR_UPDATED_AT = 'updated_at';
const ATTR_UPDATED_BY = 'updated_by';

const EXCHANGE_ID = '990584000011042';
const EXCHANGE_MDKEY = '4302B794A1BF2F1B7FB628216694C6A3';


/**
 * 路径别名定义
 */
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
/**
 * 引入自定义函数
 */
$files = common\helpers\FileHelper::findFiles(Yii::getAlias('@common/functions'), ['only' => ['suffix' => '*.php']]);
array_walk($files, function ($file) {
    require $file;
});
/**
 * 公共变量定义
 */
common\traits\ChisWill::$date = date('Y-m-d');
common\traits\ChisWill::$time = date('Y-m-d H:i:s');
/**
 * 绑定验证前事件，为每个使用`file`验证规则的字段自动绑定上传组件
 */
common\components\Event::on('common\components\ARModel', common\components\ARModel::EVENT_BEFORE_VALIDATE, function ($event) {
    foreach ($event->sender->rules() as $rule) {
        if ($rule[1] === 'file') {
            $fieldArr = (array) $rule[0];
            foreach ($fieldArr as $field) {
                $event->sender->setUploadedFile($field);
            }
        }
    }
});
/**
 * 日志组件的全局默认配置
 */
Yii::$container->set('yii\log\FileTarget', [
    'logVars' => [],
    'maxLogFiles' => 5,
    'maxFileSize' => 1024 * 5,
    'prefix' => ['common\models\Log', 'formatPrefix']
]);
Yii::$container->set('yii\log\DbTarget', [
    'logVars' => [],
    'prefix' => ['common\models\Log', 'formatPrefix']
]);
