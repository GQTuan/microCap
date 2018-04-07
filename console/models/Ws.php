<?php
//微盛 请求式实时行情 HTTP URL API接口

namespace console\models;

use Yii;
use common\models\Order;
use common\models\Product;
use common\models\DataAll;
use common\models\ProductParam;
use common\helpers\StringHelper;
use common\helpers\Curl;

class Ws extends Gather
{
    // 产品列表
    public  $productList = [
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
    // 间隔时间(s) => 参数名称
    public $typeList = [
        300 => '5_fen',
        600 => '10_fen',
        1800 => '30_fen',
        3600 => '60_fen',
        60 => 'fen',
        86400 => 'day'
    ];

    public function run($tableName = 'ce')
    {
        $info = $this->productList[$tableName];
        $data = Curl::json($info['url']);
        $month = date('n') + 1;

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
                    if ($val->NewPrice <= 0) {
                        continue;
                    }
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
                    $this->insert($name, $info);
                }
            }
        }

        // 监听是否有人应该平仓
        $this->listen($tableName);
    }

    protected function getHtml($url, $options = null)
    {
        $options[CURLOPT_HTTPHEADER] = ['Referer: http://www.xftz.cn/hq/ygy9995_utf8.php'];
        return Curl::get($url, $options);
    }
}
