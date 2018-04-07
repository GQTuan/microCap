<?php use common\helpers\Html; ?>
<?php use frontend\models\Product; ?>
<?php common\assets\HighStockAsset::register($this) ?>
<?php $this->regJs('rem') ?>
<?php $this->regJs('candle') ?>
<?php //$this->regCss('swiper.min') ?>
<?php //$this->regJs('swiper.min') ?>
<?php $this->regCss('login') ?>
<?php $this->regCss('price') ?>


<style type="text/css">
    .up{
        display: inline-block;
        width:10px;
        height: 13px;
        background: url(/images/shang.png) no-repeat center center;
        background-size: 10px 13px;
    }
    .down{
        display: inline-block;
        width:10px;
        height: 13px;
        background: url(/images/xia.png) no-repeat center center;
        background-size: 10px 13px;
    }
    .deposit {
        background: #fff;
        color: #888; 
    }
</style>

   <!--头部导航--> 
    <div class="user_self head" style="margin-bottom:0;padding:0">
         <div class="user_img">
            <a href="<?= url(['user/index']) ?>">
            <div class="my_img">
                <img src="<?= u()->face ?>" width="720" height="440">
            </div>
            <div class="user_text">
              <p>个人账户(元)</p>
              <p ><?= u()->account - u()->blocked_account ?></p>
            </div>
            </a>
         </div>
        <div class="user_btn">
            <a class="btn_price overallPsd" data-url="<?= ZH_PAY_DOMAIN.url(['user/recharge', 'user_id' => u()->id]) ?>">充值</a>
        </div>
        <div class="user_btn">
            <a class="btn_with overallPsd" data-url="<?= url(['user/withDraw']) ?>">提现</a>
        </div>
    </div>
    
     <!--中间内容-->
    <div class="container mar_b100">  
        <div class="row bg_e">
            <ul class="sel_box" style="border:0">
                <li>
                    <div class="input_box  bank-select po_re">
                      <ul class="form-control selectProduct flex-nowrap" id="province" data-name="">
                            <?php $bool=true;foreach ($productArr as $key => $arr): 
                            $class=($key==$pid)?'active':'';?>
                            
                            <li value="<?= $key ?>" data-name="<?= $arr['table_name'] ?>" data-price="<?= $arr['price'] ?>" class="<?= $class ?>">
                            <a href="<?= url(['site/index', 'pid' => $key]) ?>">
                                <?= $arr['name'] ?>
                                <span class="number"><?= $arr['price'] ?> <span class="up"></span></span>
                                <!-- down-number  和  up-number 控制number字体颜色 -->
                            </a>
                            </li>
                            
                            <?php endforeach ?>
                      </ul>
                       
                     </div>
                </li>
            </ul>
        </div>
        <!--tab 选项卡-->
        <div class="row">
            <div class="time-container">
                <ul class="nav nav-tabs bor_0 " id="feature-tab">
                    <li class="active"><a  data-unit="-1">分时线</a></li>
                    <li><a data-unit="0">1分钟</a></li>
                    <li><a data-unit="1">5分钟</a></li>
                    <li><a data-unit="2">15分钟</a></li>
                </ul>
            </div>
            <div class="tab-content" style="position:relative">
               <!--  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="230px" width="2px" style="position:absolute;left:9px;top:45px;display:none" class="svg">
                    <line x1="0" y1="0" x2="0" y2="100%" style="stroke:#c0d0e0;stroke-width:2"/>
                </svg> -->
                <div id="areaContainerPare" style="height: 300px; min-width: 310px; width:100%;">
                    <div id="areaContainer" style="height: 300px; min-width: 310px; width:100%">
                    </div>
                </div>
                <div id="kContainer" style="height: 300px; min-width: 310px; width:100%; display: none;">
                    
                </div>
                <div id="report" style="position: absolute;top:0;left:0;z-index:50;display: none;color:#fff;width:100%;font-size:12px">  
                   
                </div>
            </div>
        </div>    
        <p class="ts trans-time"><?= $timeHtml ?></p>
        <div class="row mar_t10">
            <?php $boolProduct = !Product::isTradeTime($productPrice[0]['product_id'], 300); $gray = '';
                  $price = $newData->price; $priceValue = 1; if ($boolProduct) {$priceValue = -1; $gray = 'gray';} ?>
            <ul class="down-up">
                <li id="btnLogin" style="float:left;width:33%;margin-left:3%;">
                    <a data-url="<?= url(['site/ajaxRiseFall']) ?>" data-type="2" class="riseFall <?= $gray ?>">
                        <p class="font_18"><span class="glyphicon glyphicon-arrow-down font_20"></span>跌</p>
                        <?php $returnRate = floatval($productPrice[0]['one_profit']) + 100 ?>
                        <P class="fallRate">回报率：<?= $returnRate ?>%</P>
                    </a>
                </li>
                <li style="width:27%;">
                        <p class="font_14 now-price" style="color:#fff;">当前价格</p>
                        <P class="font_20 co_cd curArrow" style="width:103%"><span class="curPrice" data-name="<?= $product->table_name ?>" data-value="<?= $priceValue ?>"><?= $price ?></span><img src="/images/arrow-top.png" style="width: 13px;vertical-align: top;"></P>

                </li>
                <li id="btnLogin1" style="float:right;width:33%;margin-right:3%">
                    <a data-url="<?= url(['site/ajaxRiseFall']) ?>" data-type="1" class="riseFall <?= $gray ?>">
                        <p class="font_18"><span class="glyphicon glyphicon-arrow-up  font_20"></span>涨</p>
                        <P class="riseRate">回报率：<?= $returnRate ?>%</P>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<!-- 看涨看跌弹窗开始 -->
<div id="mask" style="display:none;"></div>
        <div id="login" style="display:none;">
            <div class="loginCon myContent">
                <div id="close" class="look-close">X
                </div>
                <section class="hashTabber-sandstone-wrapper">
                    <div class="model-tab">
                        <input type="hidden" value="1" class="orderRiseFall">
                        <ol class="hashTabber-nav hashTabber-sandstone buys" data-hashtabber-id="dinosaurs" data-hashtabber-default="pterosaur">
                            <li data-type="1" class="active">
                                <a>使用现金</a>
                            </li>
                            <li data-type="2" class="">
                                <a>使用代金劵</a>
                            </li>
                        </ol>
                    </div>
                    <div class="my-content">
                        <p class="content-title">
                            <span class="product-info">
                                <span class="iconRiseFall">跌</span>
                                <span class="product-name"><?= $product->name ?></span>
                            </span>
                            <span class="now-price">
                                <span>当前价格:</span>
                                <span class="acount ">
                                    <span class="up-text nowPrice"><?= $newData->price ?></span>
                                    <span class="up"></span>
                                </span>
                            </span>
                        </p>

                        <section class="jssj-section">
                            <p class="jssj">结算时间</p>
                            <ul class="jssj-list">
                            <?php $bool=true;foreach ($productPrice as $data): ?>
                                <li class="<?= $bool==true?'active':'' ?>">
                                    <p class="shijian" data-id="<?= $data['id'] ?>" data-profit="<?= floatval($data['one_profit']/100) ?>" data-deposit="<?= floatval($data['deposit']) ?>">
                                        <span><?= $data['point'] ?></span><span>m</span>
                                    </p>
                                    <p class="shouyi">收益<span><?= floatval($data['one_profit']) ?></span>%</p>
                                </li>
                            <?php $bool=false;endforeach ?>
                            </ul>
                        </section>

                        <section class="jssj-section">
                            <p class="jssj">投资金额</p>
                            <ul class="tzje-list">
                                <li class="active">100</li>
                                <li>200</li>
                                <li>500</li>
                                <li>1000</li>
                                <li>2000</li>
                                <li><input class="deposit" value="100" placeholder="其他金额"/></li>
                            </ul>
                            <p class="my-balance">
                                <span class="kyye">
                                    可用余额<span><?= u()->account - u()->blocked_account ?></span>元
                                </span>

                                <span class="yjsy">
                                    预计收益<span><?= 100  * (100 + $productPrice[0]['one_profit'])/100 ?></span>元
                                </span>
                            </p>
                        </section>
                        
                    </div>
                                
                    <div class="row mar">
                        <button class="col-xs-8 font_18 payable">
                        <a><span class="userCouponHtml"> 应付： ￥ <b class="font_22 userCouponNum"><?= 100 + config('web_order_fee', 2) ?></b>  </span></a></button>
                        <button class="col-xs-4 font_18 text-center balance orderBalance disabled"><a data-type="2"><span>下单</span></a></button>
                    </div>
                
                        
                </section>
            </div>
        </div>
<!-- 看涨看跌弹窗结束 -->




<input type="hidden" id="productId" value="<?= $product->id ?>">
<input type="hidden" id="fallRate" value="<?= $returnRate ?>">
<div id="jsonData" style="display: none;"><?= $json ?></div>

<!-- <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script> -->
<script type="text/javascript">

//屏蔽所有右上角功能
// function onBridgeReady(){
//     WeixinJSBridge.call('hideOptionMenu');
// }

// if (typeof WeixinJSBridge == "undefined"){
//     if( document.addEventListener ){
//         document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
//     }else if (document.attachEvent){
//         document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
//         document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
//     }
// } else {
//     onBridgeReady();
// }

$(function() {
    //关闭弹窗
    $('#close').on('click', function() {
        $('#mask').hide();
        $('#login').hide();
    });

    $('.buys>li').click(function() {
        if ($(this).data('type') == 1) {
            $('.buyContent1').show();
            $('.buyContent2').hide();
        } else {
            return $.alert('暂未开通！');
            $('.buyContent2').show();
            $('.buyContent1').hide();
        }
        $(this).addClass("active").siblings().removeClass("active");
    });

    //使用代金劵的切换
    $('.myContent').on('change', '.couponType', function() {
        var account = $(this).find("option:selected").data('account');
        if (account == 0) {
            $('.userCouponHtml').html('<b class="font_22 userCouponNum">'+$(this).val()+'</b> 个未使用');
            $('.buyContent2 .orderBalance').addClass('disabled');
        } else {
            $('.userCouponHtml').html('使用一张使用代金劵');
            $('.buyContent2 .orderBalance').removeClass('disabled');
        }
        var rate = $('#fallRate').val();
        $('.orderCouponNum').html('可用代金劵:' + $(this).val() + '张');
        $('.myContent .buyContent2 .orderProfit').html(rate * account / 100);
        // $('.buyContent2').html('可用代金劵:' + $(this).val() + '张');
    });

    //买涨买跌
    var swiper;
    $('.riseFall').click(function() {
        if ($(this).hasClass('gray')) {
            return false;
        }
        var data = {};
        data.id = $(".selectUnit .city").find("option:selected").val(),
        data.type = $(this).data('type');
        $('.orderRiseFall').val(data.type);
        // $('.imgRiseFall img').remove();
        if (data.type == 1) {
            $('.iconRiseFall').addClass('up-icon');
            $('.iconRiseFall').removeClass('down-icon');
            $('.iconRiseFall').html('涨');
            // $('.imgRiseFall').prepend('<img src="/images/icon_zhang.png" style="width:26px;margin-right:8px;">');
        } else {
            $('.iconRiseFall').addClass('down-icon');
            $('.iconRiseFall').removeClass('up-icon');
            $('.iconRiseFall').html('跌');
            // $('.imgRiseFall').prepend('<img src="/images/icon_die.png" style="width:26px;margin-right:8px;">');
        }
        $('#mask').show();
        $('#login').show();
        // $.post("<?= url('site/ajaxBuyState')?>", {data: data}, function(msg) {
        //     if (msg.state) {
        //         var info = msg.info,
        //             max = parseInt(info['deposit'] / 100),
        //             coupon = msg.data,
        //             rate = $('#fallRate').val(),
        //             account = $('.orderAccount').data('account');
        //         $('.orderUnit').html(info['unit']+info['name']);
        //         $('.orderProfit').attr('data-rate', parseInt(info['one_profit']) + 100);
        //         $('.orderBuy').attr('data-max', parseInt(info['deposit']));
        //         $('.buyContent1 .orderProfit').html(rate);
        //         $('.orderDeposit').html('￥ 100');
        //         $('.orderBuy').val(100);

        //         if (account >= 100) {
        //             $('.buyContent1 .orderBalance').html('<a data-type="1"> <span>下单</span> </a>');
        //         } else {
        //             $('.buyContent1 .orderBalance').html('<a data-type="0"> <span>余额不足<br>去充值</span> </a>');
        //         }

        //         if (coupon['couponNum'] == 0) {
        //             $('.orderCoupon').html('你还没有可使用的代金劵');
        //         } else {
        //             $('.orderCoupon').html(coupon['couponTypeHtml']);
        //         }
        //         $('.orderCouponNum').html('可用代金劵:'+coupon['couponNum']+'张');
        //         $('.userCouponNum').html(coupon['couponNum']);
        //         if (coupon['couponNum'] == 0) {
        //             $('.buyContent2 .orderBalance>span').html('没有代金劵');
        //         } else {
        //             $('.buyContent2 .orderBalance>span').html('下单');
        //         }
                
        //         $('.buyContent2 .orderBalance').addClass('disabled');
        //         $('#mask').show();
        //         $('#login').show();
        //         var swiperWrapperLayer = $('.swiper-wrapper');
        //         if (swiperWrapperLayer.data('type') == 1) {
        //             $('.swiper-container .swiper-wrapper').html('');
        //             for (var i = 0; i < max; i++) {
        //                 var money = 0 + i * max * 5;
        //                 swiperWrapperLayer.append('<div class="swiper-slide"><div class="money">' + money + '</div></div><div class="swiper-slide"></div><div class="swiper-slide"></div><div class="swiper-slide"></div><div class="swiper-slide"></div>');
        //                 if(i == max-1){
        //                     swiperWrapperLayer.append('<div class="swiper-slide"><div class="money">' + (i+1)*(max)*5 + '</div></div>')
        //                 }
        //             }
        //                 swiper = new Swiper('.swiper-container', {
        //                 slidesPerView: 32, //设置slider容器能够同时显示的slides数量(carousel模式)。
        //                 centeredSlides: true, //设定为true时，活动块会居中，而不是默认状态下的居左。
        //                 spaceBetween: 0, //slide之间的距离（单位px）。
        //                 grabCursor: true, //设置为true时，鼠标覆盖Swiper时指针会变成手掌形状，拖动时指针会变成抓手形状
        //                 observer: true,
        //                 initialSlide : 5
        //             });
        //              $(document).ready(function() {
        //                 swiper.onResize();
        //             });
        //             swiperWrapperLayer.attr('data-type', 2);
        //         }
        //     } else {
        //         $.alert(msg.info);
        //     }

        // }, 'json');
    })


     //数字累加累减
    $(".myContent").on("click", '.btn-coin', function() {
        var price = parseInt($('.orderBuy').val());
        var max = parseInt($('.orderBuy').data('max'));
        var value = parseInt($(this).data('value'));
        price = price + value;
        if (price < 0 || price > max) {
            return false;
        }
        var rate = $('#fallRate').val(),
            account = $('.orderAccount').data('account'),
            colsum = parseInt(price/20);
            swiper.slideTo(colsum, 300, false);//切换到第一个slide，速度为1秒
        //用户点击增加购买金额
        if (account >= price) {
            $('.buyContent1 .orderBalance').html('<a data-type="1"> <span>下单</span> </a>');
        } else {
            $('.buyContent1 .orderBalance').html('<a data-type="0"> <span>余额不足<br>去充值</span> </a>');
        }
        $('.buyContent1 .orderProfit').html(rate * price / 100);
        $('.orderDeposit').html('￥' + price);
        $('.orderBuy').val(price);
    });

    //下单
    $(".myContent").on("click", '.orderBalance', function() {

        var data = {};
        // data.type = $(this).find('a').data('type');
        data.priceId = $(".jssj-list li.active .shijian").data('id');
        data.deposit = $(".deposit").val();
        data.rise_fall = $('.orderRiseFall').val();
        $.post("<?= url('order/ajaxSaveOrder')?>", {data: data}, function(msg) {
            if (msg.state) {
                // $('#mask').hide();
                // $('#login').hide();
                $.alert('购买成功！');
                window.location.href = "<?= url(['order/position']) ?>";
            } else {
                $.alert(msg.info);
            }
        }, 'json');
    });
});
</script>
<!-- <script src="/js/swiperWrapper.js"></script> -->

<script type="text/javascript">
    $(function(){
        var fee = <?= config('web_order_fee', 2) ?>;
        $(".jssj-list").on("click","li",function(){
            $(this).addClass('active').siblings(".active").removeClass('active');
            fillVale();
            fillProfit()
        });
        $(".tzje-list").on("click","li",function(){
            $(this).addClass('active').siblings(".active").removeClass('active');
            var $val = $(this).text();
            $(".tzje-list input").val($val);
            fillVale();
            fillProfit()
        });
        $(".deposit").bind("input propertychange", function () {
            var deposit = $(this).val(), 
                max = $(".jssj-list li.active .shijian").data('deposit'); 
            if ((/^(\+|-)?\d+$/.test( deposit )) && deposit > 0 && deposit <= max){  
            } else {  
                $(this).val(100) 
            }  
            fillVale();
            fillProfit()
        });
        //应付数额填值
        function fillVale(){
            var $val = parseFloat($(".tzje-list input").val()) * (100 + fee) / 100;
            $(".userCouponNum").html($val);
        }
        //预计收益填值
        function fillProfit(){
            var rate = $(".jssj-list li.active .shijian").data('profit');
            var account =  $(".tzje-list input").val();
            var profit = parseFloat(account * (1 + rate));
            $(".yjsy span").html((profit).toFixed(2));
        }
    })
</script>