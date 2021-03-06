<?php $this->regCss('price') ?>
<?php $this->regCss('login') ?>
<style type="text/css">
    body{
        width:100vw;
        overflow-x:hidden;
        background: #f5f5f5;
     }
     div{
        overflow-x: hidden;
     }
     a.qiandao-btn:hover{
        color: #655934;
     }
     .index-title {
        background: #fff;
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
    .product-list li {
        padding-top: .4rem;
    }
    .item-list li+li {
        border-left: 1px solid #ddd;
    }
    .section .title {
        height: 1.2rem;
        line-height: 1.2rem;
    }
    .flex-nowrap li p:nth-child(1) {
        font-size: .42rem;
        color: #666;
    }
    .findbox {
        margin: 12px;
        background: #FFFFFF;
        border-radius: 6px;
        box-shadow: 0rem 0rem 0.5rem 0rem rgba(0, 0, 0, 0.12);
    }
    .findbox .categorys {
        padding: 14px 0;
        border-bottom: solid 1px #D9D8DB;
        display: flex;
    }
    .findbox .categorys .item {
        text-align: center;
        flex: 1;
        font-size: 12px;
    }
    .findbox .categorys .item .on {
        padding: 1px 4px;
        background-color: #354162;
        color: #ffffff;
        border-radius: 2px;
    }
    .yincan{
        width: calc(100% - 24px)!important;
        height: 71px!important;
        position: absolute!important;
        background-color: #FFFFFF!important;
        filter: alpha(opacity=0)!important;
        right: 12px!important;
        left: 12px!important;
        padding-top: 20px;
    }
    .yincan p{
        line-height: 24px!important;
    }
    .server_mask{
        position: fixed;
        width: 100vw;
        height: 100vh;
        z-index: 999999999999;
        left: 0;
        top: 0;
        background: rgba(0,0,0,.8);
        padding: 140px 70px 0 70px;
        box-sizing: border-box;
        display: none;
    }
    .server_mask img{
        width: 100%;
    }
    
</style>
<p class="flex-nowrap index-title">
<a class="img-link" href="<?= url(['user/index']) ?>">
    <img class="flex-none" src="<?= u()->face ?>">
</a>
    <span class="name"></span>
    <span class="balance">余额￥ <span><?= u()->account - u()->blocked_account ?></span></span>
    <a class="my-btn-noflex flex-none" href="<?= url(['user/recharge']) ?>">充值</a>
    <a class="my-btn-noflex flex-none my-btn qiandao-btn">签到</a>
</p>
<div class="banner">
    <!-- <img src="/images/banner.jpg"> -->
    <div id="myCarousel" data-ride="carousel" data-interval="2500" class="carousel slide">

        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <div class="item active flex-nowrap">
                <img src="/images/banner.png">
            </div>
            <div class="item flex-nowrap">
                <img src="/images/banner.png">
            </div>
            <div class="item flex-nowrap">
                <img src="/images/banner.png">
            </div>
        </div>
        <!-- 轮播（Carousel）导航 -->
        <a id="left" class="carousel-control left" href="#myCarousel" 
           data-slide="prev"></a>
        <a id="right" class="carousel-control right" href="#myCarousel" 
           data-slide="next"></a>
    </div> 
</div>
<div class="section">
    <p class="title ">
       <a href="<?= url(['order/transDetail', 'id' => $productArr[0]['id']]) ?>">热门交易品种</a> 
    </p>
    <ul class="flex-nowrap product-list">
        <?php foreach ($productArr as $product): ?>
            <li data-name=<?= $product->table_name ?>>
                <a href="<?= url(['order/transDetail', 'id' => $product->id]) ?>">
                    <p><?= $product->name ?></p>
                    <p class="price down"><?= floatval($product->dataAll->price) ?></p>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<!-- <ul class="flex-nowrap item-list">
    <li>
        <a href="#">
            转盘抽奖
        </a>
    </li>
    <li>
        <a href="">
            新手指引
        </a>
    </li>
    <li>
        <a href="javascript:showKefu();">
            联系客服
        </a>
    </li>
</ul>
 -->


<div class="section">
    <iframe id="iframe"  height="3500px"  width="100%"  frameborder="0"  scrolling="no"  src="http://rili-d.jin10.com/open.php"></iframe>
</div>
<script type="text/javascript">
    //持仓数据跳动
    function data(){
        var mydate = new Date();
        //交易时间：周一至周五，上午10:00至次日凌晨02:00 mydate.getHours(); //获取当前小时数(0-23)
        if (mydate.getDay() == 0 || (mydate.getDay() == 6 && mydate.getHours() >= 6) || (mydate.getDay() == 1 && mydate.getHours() <= 4)) {
            $(".price").html("休市");
            $(".my-rate").css("display","none");
            return $('#now_price').html('休市');
        }
        $.get('/price.json?' + Math.random(), function(newData) {
            var nowProduct = $('#productTableName').val(),
                price = parseFloat(newData[nowProduct]);
            $('.product-list li').each(function(){
                //console.log(item);
                var close = $(this).find('.price').html(),
                    name = $(this).data('name');
                if (newData[name] != close) {
                    $('.price',$(this)).removeClass("down").removeClass("up");
                }
                if (newData[name] > close) {
                    $('.price',$(this)).addClass('up');
                    console.log(123);
                } else if (newData[name] < close) {
                    $('.price',$(this)).addClass('down');
                    console.log(321);
                }
                $(this).find('.price').html(newData[name]);
            });
        }, 'json');
    }
    setInterval(data, 1500);
    $(".qiandao-btn").click(function(){
        if($(this).hasClass("active")){return;}
        $.post("<?= url(['site/signs']) ?>",function(msg){
            // console.log(msg);
            if (msg == 1) {
                $.alert('签到成功');
                $(".qiandao-btn").addClass("active").html("已签到");
            }else {
                $.alert('已签到');
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
</script>


<script type="text/javascript">
$(function(){
    $('#myCarousel').hammer().on('swipeleft', function(){
        $(this).carousel('next');
    });
    $('#myCarousel').hammer().on('swiperight', function(){
        $(this).carousel('prev');
    });
})
    
</script>
<script>
    function showKefu()
    {
        layer.open({
            title:" ",
            type: 1,
            area: ['230px','350px'],
            content: '<image style="width:100%;" src="/images/kefu1.png">' //这里content是一个普通的String
        });
    }
</script>
