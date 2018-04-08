<?php $this->regCss('login') ?>
<style type="text/css">
    body{
        background: #fff;
    }
    .buy-title {
        background: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }
    .price-name {
        font-size: .44rem;
        color: #666;
        text-align: center;
    }
    .choice-cost {
        background: #f5f5f5;
        padding: .3rem;
        text-align: center;
    }
    .choice-cost p:first-child {
        color: #666;
    }
    .price-options a.active {
        border-color: #e4393c;
        color: #FB433A;
    }
    .price-options a:after {
        color: #666;
    }
    .price-options a {
        color: #666;
    }
    .per-wing {
        color: #666;
    }
    .choice-hands .title {
        color: #666;
        border-top: 1px solid #ddd;
        background: #f5f5f5;
    }
    .nav-content {
        background: #f5f5f5;
    }
    .nav-content span.active {
        background: #e4393c;
        border-color: #e4393c;
        color: #fff;
    }
    .nav-content span {
        color: #666;
    }
    .coupon-list {
        background: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }
    .coupon-list div+div {
        border-left: 1px solid #ddd;
    }
    .coupon-title {
        font-size: .4rem;
        color: #666;
    }
    .quan {
        color: #fff;
    }
    .classOptions a {
        font-size: .38rem;
        color: #666;
        border: 1px solid #999;
        padding: .04rem .1rem;
        border-radius: .06rem;
    }
    .coupon-btn span {
        color: #666;
    }
    .coupon-btn {
        border: 1px solid #999;
    }
    .coupon-btn span+span {
        border-left: 1px solid #999;
    }
    .zyzs {
        background: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .zyzs p {
        color: #666;
    }
    .zyzs p a.active {
        border-color: #e4393c;
        color: #fff;
        background: #e4393c;
    }
    .zyzs p a {
        color: #666;
    }
    .warning span {
        color: #999;
    }
    .jiancang {
        background: #f5f5f5;
        border-top: 1px solid #ddd;
    }
</style>
<div class="buy-container">
    <div class="buy-title">
        <p class="price up">计算中</p>
        <p class="price-name"><?= $product->name ?>价格</p>
    </div>
    <div class="choice-cost" data-id="<?= $product->id ?>">
        <p>选择建仓成本</p>
        <p class="flex-nowrap price-options">
        <?php $i=1;foreach($productPrices as $productPrice): ?>
            <a class="<?php if ($i == 1) {echo 'active';} ?>" data-deposit="<?= $productPrice->deposit ?>" data-fee="<?= $productPrice->fee ?>" data-profit="<?= $productPrice->one_profit ?>">￥<?= floatval($productPrice->deposit) ?></a>
        <?php $i++;endforeach ?>
        </p>
        <p class="per-wing">每点波动 <span></span></p>
    </div>
    <div  class="choice-hands">
        <p class="title">选择手数</p>
        <p class="hands-nav flex-nowrap" style="display: none;">
            <a class="active" href="">1-10</a>
            <a href="">10-20</a>
        </p>
        <p class="nav-content clear-fl">
            <span class="active">1</span>
            <span>2</span>
            <span>3</span>
            <span>4</span>
            <span>5</span>
            <span>6</span>
            <span>7</span>
            <span>8</span>
            <span>9</span>
            <span>10</span>
        </p>
    </div>

    <div class="flex-nowrap coupon-list">
        <div>
        <?php if(!empty($couponArr)): ?>
            
            <p class="coupon-title">
                <span class="quan">券</span>
                使用代金券
                <span data-max="" class="quan-count count">0</span><!-- data-max : 代金券总数 -->
                <span>张</span>
            </p>
            <p class="classOptions">
                <?php foreach($couponArr as $key => $val): ?>
                    <a data-max="<?= $val ?>" data-val="<?= $key ?>"><?= $key ?>元共<?= $val ?>张</a >
                <?php endforeach ?>
            </p>
            
            <p class="coupon-btn clear-fl">
                <span class="minus-btn">-</span>
                <span class="quan-count count">0</span>
                <span class="plus-btn">+</span>
            </p>
        <?php else: ?>
            <p class="coupon-title">
                <span class="quan">券</span>
                使用代金券
                <span data-max="" class="quan-count count">0</span><!-- data-max : 代金券总数 -->
                <span>张</span>
            </p>
            <p class="classOptions">
                    <a data-max="0" data-val="0">共0张</a >
            </p>
            
            <p class="coupon-btn clear-fl">
                <span class="minus-btn">-</span>
                <span class="quan-count">0</span>
                <span class="plus-btn">+</span>
            </p>
        <?php endif; ?>
        </div>
        <div>
            <!--<p class="coupon-title">
                <span class="pai">牌</span>
                使用免死金牌
                <span data-max="<?/*=  $medalArr?$medalArr:0 */?>" class="pai-count count">0</span>
                <span>块</span>
                <p class="mianKuai">共<?/*=  $medalArr?$medalArr:0 */?>块</p>
            </p>
            <p class="coupon-btn clear-fl">
                <span class="minus-btn">-</span>
                <span class="pai-count count">0</span>
                <span class="plus-btn">+</span>
            </p>-->
        </div>
    </div>

    <div class="zyzs">
        <p class="zy">止盈: 
            <a class="active" href="">不设</a> 
            <a href="">10%</a> 
            <a href="">20%</a> 
            <a href="">30%</a> 
            <a href="">40%</a> 
            <a href="">50%</a> 
        </p>
        <p class="zs">止损: 
            <a class="active" href="">不设</a> 
            <a href="">10%</a> 
            <a href="">20%</a> 
            <a href="">30%</a> 
            <a href="">40%</a> 
            <a href="">50%</a> 
        </p>
    </div>

    <p class="warning">
        <span>注意事项</span><br/>
        1.每个规则可分别持仓一笔，平仓后继续加仓<br/>
        2.持仓不支持过夜<br/>
        3.手续费标准有头角平台设置
    </p>
    <p class="clear-fl jiancang">
        <span class="nowprice">￥110.00</span>
        <a class="jiancang-btn <?=  $parmar==1?'up':'down'; ?>" href="">建仓看<?= $parmar==1?'涨':'跌' ?></a>
        <span class="fee">手续费：<span><?= $productPrices[0]['fee'] ?></span>元</span>
    </p>
</div>

<?php $this->regCss('price') ?>


<script type="text/javascript">
    $(function(){
        var point = 1;
        if ('<?= $product->id ?>' == '7') {
            point = 0.01;
        }
        $(".per-wing span").html(parseFloat($(".price-options a.active").data("profit")) * point);
    });
    calcAmount();
    $(".price-options").on("click" , "a" , function(e){
        e.preventDefault();
        $(this).addClass("active").siblings(".active").removeClass("active");
        var point = 1;
        if ('<?= $product->id ?>' == '7') {
            point = 0.01;
        }
        $(".per-wing span").html(parseFloat($(this).data("profit")) * point);
        calcAmount();
    });

    $(".nav-content").on("click" , "span" , function(e){
        $(this).addClass("active").siblings(".active").removeClass("active");
        calcAmount();
    });

    $(".hands-nav").on("click" , "a" , function(e){
        e.preventDefault();
        var dataId = $(".choice-cost").data("id");
        if(dataId == 1 || dataId == 3 || dataId == 7){
            return false;
        }
        $(this).addClass("active").siblings(".active").removeClass("active");
        var arr = [[1,2,3,4,5,6,7,8,9,10],[11,12,13,14,15,16,17,18,19,20]];
        if($(this).html() == "1-10"){
            $(".nav-content span").each(function(index, el) {
                $(this).html(arr[0][index]);
            });
        }else{
            $(".nav-content span").each(function(index, el) {
                $(this).html(arr[1][index]);
            });
        }
        
    });

    $(".coupon-list>div").click(function(e) {
        var max;
        if($(this).find(".classOptions").length > 0){
            if($(".classOptions>a.active").length == 0){
                if($($(".classOptions>a")[0]).data("max") == 0){return false;}
                $.alert("请选择代金券面额");
                return false;
                //提示选代金券面额
            }
            max = $(".classOptions>a.active").data("max");
        }else{
            max = $(".pai-count").data("max");
            if(max > 1){max = 1;}
        }
        if( $(e.target).attr("class") == "minus-btn"){
            var count = $(this).find(".count").html();
            if(count <= 0){return false;}
            count --;
            $(this).find(".count").html(count)
        }else if( $(e.target).attr("class") == "plus-btn"){
            var count = $(this).find(".count").html();
            count ++;
            if(count > max){return false;}
            $(this).find(".count").html(count)
        }
    });

    $(".zyzs").on("click","a",function(e){
        e.preventDefault();
        $(this).addClass("active").siblings(".active").removeClass("active");
    });

    //手续费，总费用地 计算都在此方法中完成，切记
    function calcAmount(){
        var handsCount = $(".nav-content>span.active").html(); //手数
        var price = $(".price-options>a.active").html().substring(1, $(".price-options>a.active").html().length); //每手价格
        var fee = $(".price-options>a.active").data("fee") * $(".nav-content>span.active").html();
        $(".fee>span").html(fee);
        var amount = handsCount * price + fee;
        $(".nowprice").html( "￥" + amount);
    }



    //点击建仓按钮
    $(".jiancang-btn").click(function(e){
        e.preventDefault();
        //取到所有数据，存放在obj中
        var obj = {};
        obj.price = $(".price-options>a.active").html().substring(1, $(".price-options>a.active").html().length); //每手价格
        obj.hand = $(".nav-content>span.active").html(); //手数
        obj.quanCount = $(".quan-count").html(); //代金券张数
        obj.quanLevel = $(".classOptions>a.active").data("val"); //代金券面值
        obj.paiCount = $(".pai-count").html(); //免死牌张数
        obj.zhiying = $(".zy>a.active").html(); //止盈点
        obj.zhisun = $(".zs>a.active").html(); //止损点
        if(obj.zhiying != "不设"){
            obj.zhiying = parseFloat(obj.zhiying);
        }else {
            obj.zhiying = 0;
        }
        if(obj.zhisun != "不设"){
            obj.zhisun = parseFloat(obj.zhisun);
        }else {
            obj.zhisun = 0;
        }
        obj.amount = $(".nowprice").html().substring(1, $(".nowprice").html().length); //总价
        obj.fee = $(".fee>span").html(); //手续费
        obj.deposit = obj.amount - obj.fee; //保证金
        obj.product_id = <?= $product->id ?>;
        obj.rise_fall = <?= get('rise_fall') ?>;
        // console.log(obj); 
        $.post("<?= url(['order/ajaxSaveOrder'])?>", {data: obj}, function(msg) {
            if (msg.state) {
                window.location.href = '<?= url(['order/position']) ?>';
            } else {
                if (msg.info == '风险提示！') {
                    $("#myModal").modal("show");
                    return;
                }
                // $('.right .deposit_price').attr('price', data.price_rate * data.hand);
                $.alert(msg.info);
                if (msg.info == '您的余额已不够支付，请充值！') {
                   window.location.href = "<?= url(['/user/recharge', 'user_id' => u()->id]) ?>"; 
                }
            }
        }, 'json');

    })

    $(".classOptions").on("click","a",function(e){
        e.preventDefault();
        $(this).addClass("active").siblings(".active").removeClass("active");
        $(".quan-count").html(0);
    });
        //期货数据跳动
    function futuresPrice(){
        //是否属于期货
        var futures = '<?= $product->table_name ?>';
        $.post("<?= url('site/ajaxNewProductPrice')?>", {data: futures}, function(msg) {
            if (msg.state) {
                var nowPrice = $(".price").html();
                if(nowPrice <= msg.info.price){
                    $(".price").removeClass("down").addClass("up");
                }else{
                    $(".price").removeClass("up").addClass("down");
                }
                $('.price').html(msg.info.price);
            } else {
                tes(msg.info);
            }
        }, 'json');
    }
    setInterval(futuresPrice, 1000);
</script>
