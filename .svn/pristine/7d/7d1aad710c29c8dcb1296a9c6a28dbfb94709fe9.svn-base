<?= $this->regJs('awardRotate') ?>
<?= $this->regCss('demo') ?>
<script type="text/javascript">
$(function() { 
        $(".pointer").click(function() {
                lottery()
                function lottery(){
                    var prize = $(".prize-v").html(); 
                    var integral = $(".integral-v").html(); 
                    if(prize == 0 || integral == 0) {
                        $.alert("您没有抽奖机会了");
                        return;
                    }
                    $.post("<?= url(['site/getPrize']) ?>", function(msg){
                        if(msg.state) {
                            var obj = msg.info;
                            var angle = obj.angle; //指针角度  
                            var prize = obj.prize; //中奖奖项标题  
                            $(".rotate").rotate({ 
                                duration: 3000,//转动时间 ms 
                                angle: 0, //从0度开始 
                                animateTo: 10800 + angle,//转动角度  
                                easing: $.easing.easeOutSine, //easing扩展动画效果 
                                callback: function() { 
                                    $(".integral-v").html(msg.info.integral);
                                    $(".prize-v").html( Math.floor( (msg.info.integral / "<?= config('web_integral',10)?>") ) );
                                    var resulte = $.confirm('恭喜您中得' + prize + '\n想要继续吗？',function(){
                                        lottery();
                                    }); 
                                } 
                            }); 
                        }else {
                            $.alert(msg.info);
                        }
                    });
            }
        }); 
}); 
</script>
<style type="text/css">
    /*.turntable-bg{
        transform:scale(0.5);
        transform-origin:left;
    }*/
</style>
</head>
<body>

<!-- lottery -start -->
<div class="lottery-container">
    <div class="turntable-bg">
        <!--<div class="mask"><img src="images/award_01.png"/></div>-->
        <div class="pointer"><img src="/images/pointer.png" alt="pointer"/></div>
        <div class="rotate" ><img id="rotate" src="/images/turntable.png" alt="turntable"/></div>
    </div>
    <h1 class="sy-count">剩余抽奖次数 <span class="prize-v"><?= $integrals ?></span> 次</h1>
    <h1 class="sy-count jf-count">我的积分 <span class="integral-v"><?= $user->integral ?></span> </h1>
    <p class="my-jilu"><a href="/user/lottery-record">我的抽奖记录</a></p>


    <!-- modal-start -->
    <a class="detail-btn">活动详情</a>
   <div class="my-modal">
        <div>
            <ol class="my-modal-content">
            <?php foreach($prize as $prizes): ?>
                <li><?= $prizes->prize.'为'.$prizes->prize_num.'张代金券' ?><li/>
            <?php endforeach ?>
            </ol>
            <a class="close-btn"></a>
        </div>
    </div>
</div>
<!-- lottery-end -->



<script type="text/javascript">
    $(".detail-btn").click(function(){
        $(".my-modal").css("display","block");
    });
    $(".close-btn").click(function(){
        $(".my-modal").css("display","none");
    });
    
</script>
<?= $this->render('/layouts/_footer') ?>