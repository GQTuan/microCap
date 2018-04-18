<?php use common\helpers\Html; ?>
<?php use frontend\models\Product; ?>
<?php use common\models\Order; ?>

<?php common\assets\HighStockAsset::register($this) ?>
<?php $this->regJs('candle') ?>
<?php $this->regCss('swiper.min') ?>
<?php $this->regJs('swiper.min') ?>
<?php $this->regCss('login') ?>
<?php $this->regCss('price') ?>
<style type="text/css">
body{
    width:100vw;
    overflow-x:hidden;
 }
 .line-container,.detail-container div{
    overflow-x: hidden;
 }
 .qiandao-btn:hover{
    color: #655934;
 }


 .detail-container .product-list li {
    position: relative;
    width: 3.6rem;
    margin-right: 0!important;
    padding-top: 0.4rem;
}
body{
    background: #fff
}
a.qiandao-btn:hover{
        color: #655934;
     }
     .index-title {
        background: #f7f7f7;
        border-bottom: 1px solid #ddd!important;
    }
    .index-title span {
        color: #333;
    }
    .my-btn-noflex {
        background: #e4393c;
        color: #fff;
    }
    .section .title {
        background: #fff;
        color: #333;
        margin-bottom: 0;
        border-bottom: .04rem solid #ddd;
    }
    .section .title a {
        color: #333;
    }
    .section .product-list {
        background: #fff;
    }
    .section .product-list li+li {
        border-left: 1px solid #ddd;
    }
    .item-list {
        background: #fff;
    }
    .item-list li a {
        color: #666;
    }
    .ranking-list {
        background: #fff;
    }
    .detail-container .product-list li p:nth-child(1) {
        color: #666;
    }
    .detail-container .product-list li.active p:nth-child(1) {
        color: #666;
    }
    .detail-container .product-list li.active:after {
        border-bottom: 2px solid #aa917a;
    }
    .graph-kind {
        padding: .2rem .6rem;
        background: #f5f5f5;
    }
    #feature-tab li a {
        color: #989898;
    }
    #feature-tab li.active a {
        background: #eb8e88;
        color: #fff;
    }
    .main-panel {
        background: #f5f5f5;
    }
    .pro-name {
        color: #666;
    }
    .info-item p {
        color: #666;
    }
    .line-container {
        background: #fff;
    }
    .btn-group-container {
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        background: #fff;
    }
    .section {
        margin-bottom: 0;
    }
    .main-panel {
        padding: 0.1rem .4rem;
    }
    .detail-container .product-list li {
        padding-top: 0.26rem;
    }
    .section .product-list {
        height: 1.5rem;
    }


    @keyframes sponde{
    0%{width:6px;height:6px;opacity:1;}
    100%{width:30px;height:30px;opacity:0;}
  }
  @-webkit-keyframes sponde{
    0%{width:6px;height:6px;opacity:1;}
    100%{width:30px;height:30px;opacity:0;}
  }
  @-moz-keyframes sponde{
    0%{width:6px;height:6px;opacity:1;}
    100%{width:30px;height:30px;opacity:0;}
  }
  @-ms-keyframes sponde{
    0%{width:6px;height:6px;opacity:1;}
    100%{width:30px;height:30px;opacity:0;}
  }
  @-o-keyframes sponde{
    0%{width:6px;height:6px;opacity:1;}
    100%{width:30px;height:30px;opacity:0;}
  }
  .aniContainer{
    position:absolute;
    width:50px;
    height:50px;
    display:flex;
    display:-webkit-box;/* android 2.1-3.0, ios 3.2-4.3 */
    display:-webkit-flex;/* Chrome 21+ */
    align-items:center;
    justify-content:center;
    -webkit-box-pack: center;/* android 2.1-3.0, ios 3.2-4.3 */
    -webkit-box-align: center;/* android 2.1-3.0, ios 3.2-4.3 */
    /*bottom: 94px;*/


    justify-content: center;
    -webkit-box-pack:center;
    -webkit-justify-content: center;
    -ms-flex-pack:center;
    justify-content:center;


    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    -ms-align-items: center;
    -o-align-items: center;
    align-items: center;
    right: -14px;
    visibility:hidden;
    transition: all 0.4s;
    -webkit-transition: all 0.4s;
    /*opacity:0;*/

    overflow-x: visible!important;
    z-index: 999;
  }
  .line-container{
    overflow-x: visible!important;
  }
  .aniContainer .core{
    position:absolute;
    width:3px;
    height:3px;
    border-radius:50%;
    background:#2158ED;
    top:24px;
    left:24px;
  }
  .aniContainer .aniBorder{
      border-radius:50%;
     /* border:6px solid #2158ED;*/
     background:#2158ED;
      -webkit-animation:sponde 1s infinite;
     -moz-animation:sponde 1s infinite;
     -ms-animation:sponde 1s infinite;
     -o-animation:sponde 1s infinite;
     animation:sponde 1s infinite;
  }
</style>

<div class="detail-container">
    <p class="flex-nowrap index-title">
    <a class="img-link flex-none" href="<?= url(['user/index']) ?>">
        <img class="flex-none" src="<?= u()->face ?>">
    </a>
        <span class="name"></span>
        <span class="balance">余额￥ <span><?= u()->account - u()->blocked_account ?></span></span>
        <a class="my-btn-noflex flex-none" href="<?= url(['/user/recharge', 'user_id' => u()->id]) ?>">充值</a>
        <a class="my-btn-noflex flex-none qiandao-btn">签到</a>
    </p>
    <div class="section slid-container swiper-container swiper-container-horizontal swiper-container-free-mode trans-lsit">
        <ul style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);" class="flex-nowrap product-list swiper-wrapper">
            <?php foreach ($allProduct as $pro): ?>
                <li class="<?php if ($pro->id == $id) {$product = $pro; echo 'active';}?>  swiper-slide flex-none" data-name="<?= $pro->table_name ?>" data-sale="<?= $pro->on_sale ?>">
                <a href="<?= url(['order/transDetail', 'id' => $pro->id]) ?>">
                    <p><?= $pro->name ?></p>
                    <p class="price down"><?php if(date('w') == 0 || date('w') == 6){echo '休市';}else{echo $pro->dataAll->price;} ?></p>
                    <!-- <p class="per-swing">每点波动:<span class="up"><?= floatval($pro->priceExtend[0]->one_profit) ?>元</span></p> -->
                </a></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="graph-kind">
        <ul id="feature-tab" class="boxflex  flex-nowrap" style="width: 100%; transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 500ms; transform: translate(0px, 0px) translateZ(0px);">
            <li class="box_flex_1 active"><a data-value="" data-unit="-1">分时</a></li>
            <!-- <li class="box_flex_1"><a data-value="1" data-unit="0">1M</a></li> -->
            <!-- <li class="box_flex_1"><a data-value="2" data-unit="1">5M</a></li> -->
            <li class="box_flex_1"><a data-value="5" data-unit="2">15分钟</a></li>
            <li class="box_flex_1"><a data-value="6" data-unit="3">30分钟</a></li>
            <!-- <li class="box_flex_1"><a data-value="3" data-unit="4">60分钟</a></li> -->
            <li class="box_flex_1"><a data-value="10" data-unit="5">日K线</a></li> 
        </ul>
    </div>
    <div class="main-panel">
        <div class="flex-nowrap">
            <img class="flex-none" src="/images/<?= $id ?>.png">
            <div class="mar-rig flex-none">
                <p class="down now-price"><?= floatval($product->dataAll->price) ?></p>
                <p class="pro-name"><?= $product->name ?>价格</p>
            </div>
            <div class="info-item">
                <p>最高 <span><?= floatval($product->dataAll->high) ?></span></p>
                <p>最低 <span><?= floatval($product->dataAll->low) ?></span></p>
            </div>
            <div class="info-item">
                <p>昨收 <span><?= floatval($product->dataAll->close) ?></span></p>
                <p>今开 <span><?= floatval($product->dataAll->open) ?></span></p>
            </div>
        </div>
    </div>

    <div class="line-container" style="position:relative">
        <div id="areaContainer" style=" min-width: 230px; width:100%;"></div>
        <div id="kContainer" style=" min-width: 230px; width:100%; display: none;"></div>
        <div class="aniContainer">
           <span class="core"></span>
           <span class="aniBorder"></span>
        </div>
    </div> 

    <p class="btn-group-container">
        <a data-id ="<?= $product->id ?>" data-state="<?= $state ?>" data-rise="<?= Order::RISE ?>" href="<?= url(['order/buy', 'rise_fall' => Order::RISE, 'id' => $product->id]) ?>"><!-- <img src="/images/buyUp.png"/> --></a>
        <a data-state ="<?= $state ?>" data-id ="<?= $product->id ?>" data-rise="<?= Order::FALL ?>" href="<?= url(['order/buy', 'rise_fall' => Order::FALL, 'id' => $product->id]) ?>"><!-- <img src="/images/buyDown.png"/> --></a>
    </p>
</div>
<input type="hidden" id="productId" value="<?= $product->id ?>">
<input type="hidden" value="<?= $product->table_name ?>" id="productTableName">
<script type="text/javascript">
       $(".qiandao-btn").click(function(){
        if($(this).hasClass("active")){return;}
        $.post("<?= url(['site/signs']) ?>",function(msg){
            // console.log(msg);
            if (msg == 1) {
                $.alert('签到成功');
                $(".qiandao-btn").addClass("active").html("已签到");
            }
        });
    })
    //判断用户是否签到，修改签到按钮状态
    $(function(){
        $.post("<?= url(['site/getSign']) ?>",function(msg){
            if (msg == 1) {
                // console.log(msg);
                // $.alert('已经签到');
                $(".qiandao-btn").addClass("active").html("已签到");
            }
        });
    });

    $(".goodinfo").click(function(){
        $("#myModal").modal("show");
    });
        $(".pay-btn ").on("click","a",function(e){
        var productId = $(this).data("id");
        var rise = $(this).data("rise");
        var state = $(this).data("state");
        $(".confirm-pay").attr("data-id",productId).attr("data-rise",rise);
        if(state == 1){
            e.preventDefault();
            $("#myModal").modal("show");
        }
    });
    
    $(".confirm-pay").click(function(e){
        e.preventDefault();
        $("#myModal").modal("hide");
        var productId = $(this).data("id");
        var rise = $(this).data("rise");
        $.post("<?= url(['order/invest']) ?>",{productId:productId,rise:rise},function(msg){
            if (msg) {
                window.location.href = msg.info;
            }
        });
    });
</script>

<script>
/*$(function(){
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 30,
        freeMode: true
    });
})*/
    
</script>

<script type="text/javascript">
    /*$(function(){
       var prevLength =  $(".product-list li.active").prevAll("li").length;
       var width = parseFloat($(".product-list li.active").css("width"));
       var l = prevLength * width;
       $(".product-list").css({
            "transform":" translate3d(-" + l + "px, 0px, 0px)"
       });
    });*/
</script>