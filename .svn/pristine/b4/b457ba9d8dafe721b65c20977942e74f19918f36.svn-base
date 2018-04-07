<?php use common\helpers\Html; ?>
<?php common\assets\HighStockAsset::register($this) ?>
<?php $this->regJs('candle') ?>
<?php $this->regCss('jiaoyi') ?>
<?php $this->regCss('trade') ?>
<?php $this->regCss('geren') ?>
<?php $this->regCss('common.css') ?>
    <div>
        <div class="transaction indexContent">
            <div class="tra_ad" style="display: none;">
                <a href=""><img src=""></a>
            </div>
            <!--账户资产-->
            <div class="boxflex assets-wrap">
                <div class="userinfo-wrap">
                    <a href="<?= url(['user/index']) ?>"><img src="<?= u()->face ?>"></a>
                    <p>个人中心</p>
                </div>
                <div class="cash-asset box_flex_1">
                    <div class="asset">
                        个人账户(元)<span id="userProfit" style="color:#eb7d12;"><?= u()->account - u()->blocked_account ?></span>
                    </div>
                    <div class="btn-withdraw-wrap">
                        <div class="recharge overallPsd" data-url="<?= url(['user/recharge']) ?>"><span>充值</span></div><div class="withdraw overallPsd" data-url="<?= url(['user/withDraw']) ?>"><span>提现</span></div>
                   
                    </div>
                </div>
                <!--账户资产-金币-->
                <div class="coin-asset orderCountDown" <?php if ($time >= 30) {$style = 'hidden';$time=30;$disClass='';} else {$style='visible';$disClass='disabled';} ?> style="visibility: <?= $style ?>;">
                    <label>下单倒计时</label>
                    <div>
                        <i class="icon-clock"></i>
                        <span class="redsymbol countDown">00:<?= $time?></span>
                    </div>
                </div>
            </div>
            <!-- 商品列表 -->
            <div class="goodslist-wrap">
                <ul class="boxflex selectProcut">
                    <?php foreach ($productArr as $key => $value): ?>
                    <li class="box_flex_1 <?php if ($key == $product->id){ echo 'active';} ?>" data-pid="<?= $key ?>" data-name="<?= $value['table_name'] ?>" data-close="<?= $value['close'] ?>" style="width: 33%;">
                    <?php $class='down';if ($value['price'] > $value['close']){ $class = 'up';} $price=$value['price'];if (date('w') == 6 || date('w') == 0) {$price='休市';} ?>
                        <div class="gooddetail"><?= $value['name'] ?><br><span class="price price-<?= $class ?>"><span><?= $price ?></span>
                        <?php if ($price != '休市'): ?>
                            <i class="arrow arrow-<?= $class ?>"></i>
                        <?php endif ?></span></div>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
            <!-- 商品详情以及走势图K线 -->
            <div class="goodinfo-wrap">
                <div class="goodinfo boxflex">
                    <span class="key">昨收:</span>
                    <span class="value closeprice"><?= floatval($newData['close']) ?></span>
                    <span class="box_flex_1"></span>
                    <span class="key">今开:</span>
                    <span class="value openprice"><?= floatval($newData['open']) ?></span>
                    <span class="box_flex_1"></span>
                    <span class="key">最高:</span>
                    <span class="value maxprice"><?= floatval($newData['high']) ?></span>
                    <span class="box_flex_1"></span>
                    <span class="key">最低:</span>
                    <span class="value minprice"><?= floatval($newData['low']) ?></span>
                </div>
                
                <div id="areaContainer" style="height: 200px; min-width: 310px; width:100%"></div>
                <div id="kContainer" style="height: 200px; min-width: 310px; width:100%; display: none;"></div>

                <div class="graph-kind">
                    <ul id="feature-tab" class="boxflex" style="width: 100%; transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 500ms; transform: translate(0px, 0px) translateZ(0px);">
                        <li class="box_flex_1 active"><a data-value="" data-unit="-1">今日走势</a></li>
                        <!-- <li class="box_flex_1"><a data-value="1" data-unit="0">1分钟K线</a></li> -->
                        <!-- <li class="box_flex_1"><a data-value="2" data-unit="1">5分钟K线</a></li> -->
                        <li class="box_flex_1"><a data-value="5" data-unit="2">15分钟K线</a></li>
                        <li class="box_flex_1"><a data-value="6" data-unit="3">30分钟K线</a></li>
                        <li class="box_flex_1"><a data-value="3" data-unit="4">60分钟K线</a></li>
                        <!-- <li class="box_flex_1"><a data-value="10" data-unit="5">日K线</a></li> -->
                    </ul>
                </div>
            </div>

            <div class="deal-btn-wrap <?= $disClass ?>">
                <div class="table">
                    <div class="table-cell btnrise-wrap buyProduct" data-type="1">
                        <label><span>看涨</span></label>
                    </div>
                    <div class="table-cell btndown-wrap buyProduct" data-type="2">
                        <label><span>看跌</span></label>
                    </div>
                </div>
                <p>交易时间：周一~周五9:00~1:00 每日4:30~7:00休市结算</p>
            </div>
            <div class="holdlist-wrap"><ul></ul></div>
        </div>
        <div class="footer_cont table">
            <i class="table-cell arrow arrow-tip"></i>
            <span class="table-cell">
                <marquee direction="left" scrollamount="3" class="active">利用大数据行情，抓住大波动收益机会！&nbsp;&nbsp;&nbsp;&nbsp;温馨提醒：微信提现额度已达上限时，建议交易商使用银联提现通道！</marquee>
            </span>
        </div>
        <div class="myContent">

        </div>
        <div class="myButtom">
            <div class="holdlist-wrap">
                <ul>
                <?= $this->render('_orderList', compact('orders')) ?>
                </ul>
            </div>   
        </div>
    </div>
<input type="hidden" id="productId" value="<?= $product->id ?>">
<div id="jsonData" style="display: none;"><?= $json ?></div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
//屏蔽所有右上角功能
function onBridgeReady(){
    WeixinJSBridge.call('hideOptionMenu');
}

if (typeof WeixinJSBridge == "undefined"){
    if( document.addEventListener ){
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    }else if (document.attachEvent){
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
} else {
    onBridgeReady();
}

$(function() {
    //倒计时
    var wait = <?= $time ?>;
    function time(obj) {
        if (wait == -1) {
            $('.orderCountDown').css('visibility', 'hidden');
            $('.deal-btn-wrap').removeClass('disabled');
            wait = 30;
            return false;
        }
        if (wait < 10) {
            tes(wait);
            obj.html('00:0' + wait);
        } else {
            tes(wait);
            obj.html('00:' + wait);
        }
        wait--;
        setTimeout(function() {
            time(obj);
        },
        1000);
    }
    //订单是否在倒计时之内
    <?php if ($time < 30): ?>
        setTimeout(function() {
            time($('.countDown'));
        },
        1000);
    <?php endif ?>

    $('.buys a').click(function() {
        $(this).addClass("selects").siblings().removeClass("selects");
    })
    //三个产品的切换
    $('.selectProcut>li').click(function() {
        $('.selectProcut>li').removeClass("active");
        $(this).addClass("active");
        window.location.href = "/site/index?pid="+$(this).data('pid');
    })

    //买涨买跌
    $('.buyProduct').click(function() {
        if ($('.deal-btn-wrap').hasClass('disabled')) {
            return $.alert('下单后30秒之内不能再次下单！');
        }
        var data = {};
        data.pid = <?= $product->id ?>;
        data.type = $(this).data('type');
        $.post("<?= url(['site/ajaxBuyState'])?>", {data: data}, function(msg) {
            if (msg.state) {
                if (msg.data == -1) {
                    window.location.href = msg.info;
                } else {
                    $('.myContent').append(msg.info);
                }
            } else {
                $.alert(msg.info);
            }
        }, 'json');
    })

    //下单
    $(".myContent").on("click", '.payOrder', function() {
        var data = {};
        data.hand = parseInt($('.myContent').find('.hand').val());
        data.deposit = $('.myContent .deposit').find('.active').html();
        //止盈止损点数
        data.point = $('.myContent .point').find('.active').html();;

        //产品id
        data.product_id = <?= $product->id ?>;
        data.rise_fall = $(this).data('type');
        $.post("<?= url(['order/ajaxSaveOrder'])?>", {data: data}, function(msg) {
            if (msg.state) {
                $('.orderCountDown').css('visibility', 'visible');
                $('.deal-btn-wrap').addClass('disabled');
                $.alert('购买成功！');
                $('.myContent').html('');
                $('.myButtom .holdlist-wrap>ul').html(msg.info);
                time($('.countDown'));
            } else {
                $('.right .deposit_price').attr('price', data.price_rate * data.hand);
                $.alert(msg.info);
                if (msg.info == '您的余额已不够支付，请充值！') {
                   window.location.href = '<?= HX_PAY_DOMAIN . url(['user/pay']) ?>'; 
                }
            }
        }, 'json');
    });
});
</script>
