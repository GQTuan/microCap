<?php $this->regCss('base') ?>
<?php $this->regCss('index') ?>
<?php $this->regCss('mui.min') ?>
<?php $this->regCss('loaders.min') ?>
<?php $this->regCss('loading') ?>
<?php $this->regCss('swiper.min') ?>

<?php $this->regJs('rem') ?>
<?php $this->regJs('others') ?>
<?php $this->regJs('swiper.jquery.min') ?>

<style type="text/css">
    #wizard-toolbar{
        display: none;
    }
    * {
        -webkit-user-select: auto!important;
    }
    .db {
        display: inline;
    }
    .banner img {
        display: block;
        width: 100%;
        height: 200px;
    }
    .second_nav li{
        width: 100%!important;
    }
    .second_nav li img{
        width: 60%!important;
        border-radius: 50%;
    }
    .second_nav li  p{
        margin-top: 6px!important;
        color: goldenrod!important;
        font-size: 14px!important;
        line-height: 24px!important;
    }
</style>

<script type="text/javascript">
    $(window).load(function(){
        $(".loading").addClass("loader-chanage")
        $(".loading").fadeOut(300)
    })
</script>
<!--loading页开始-->
<div class="loading">
    <div class="loader">
        <div class="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>
</div>
<!--loading页结束-->

<body>    
        <!-- 交易密码 他弹框 - start -->
        <div class="pwd_mask">
            <div class="pwd_content">
                <h1 class="pwd_title">输入交易密码</h1>
                <div class="pwd_section">
                    <input type="password" />
                    <p class="pwd_tip">
                        <a href="<?= url(['user/modify']) ?>">忘记交易密码</a>
                    </p>
                </div>
                <div class="pwd_section">
                    <a href="javascript:void();" class="pwd_submit">确认</a>
                </div>
            </div>
        </div>
        <!-- 交易密码 他弹框 - end -->



    <!--头部区域-->
<!--    <header class="mui-bar mui-bar-nav" id="header">-->
<!--        <h4>点点商城</h4>-->
<!--    </header>-->
<!--    <div id="main" class="clearfloat warp">-->
    <div id="main" class="clearfloat" style="padding-bottom: 1.9rem;">
        <div class="mui-content">
            <!--banner开始-->
            <div class="banner swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="javascript:void(0)"><img class="swiper-lazy" data-src="/images/shop_banner1.jpg" alt=""></a></div>
                    <div class="swiper-slide"><a href="javascript:void(0)"><img class="swiper-lazy" data-src="/images/shop_banner2.jpg" alt=""></a></div>
                </div>
            </div>
            <!--第一栏分类开始-->
            <div class="cation clearfloat box-s">
                <ul class="flex_nowrap second_nav">
                    <li>
                        <a href="#">
                            <img src="/images/_New.png"/>
                            <p>新品上市</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/images/_Life.png"/>
                            <p>品质生活</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= url(['site/index1']) ?>">
                            <img src="/images/_Money.png"/>
                            <p>惠赚钱</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--第一栏分类结束-->

            <!--4F手机、数码配件-->
            <div class="theme clearfloat">
                <div class="boutit clearfloat">
                    <span></span>
                    <samp>1F手机、数码配件</samp>
                </div>
                <div class="content clearfloat">
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/xj.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">单反相机，彰显你的风格</p>
                                <p><span>提货券:</span><span class="over db red">100000</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/4f2.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">吸盘式手机支架/车载支架/汽车导航支架 </p>
                                <p><span>提货券:</span><span class="over db red">2900</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/4f3.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over"> Lightning数据线 手机数据/充电线 1.2米白色用于苹果</p>
                                <p><span>提货券:</span><span class="over db red">2680</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/4f4.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over"> 8孔位3米插座插排插线板接线板 节能防火插座板</p>
                                <p><span>提货券:</span><span class="over db red">3980</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/4f3.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">Lightning数据线 手机数据/充电线 1.2米白色用于苹果</p>
                                <p><span>提货券:</span><span class="over db red">1000</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/4f2.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">吸盘式手机支架/车载支架/汽车导航支架</p>
                                <p><span>提货券:</span><span class="over db red">1000</span></p>
                                <p><span>余额兑换:</span><span class="over db red">100</span></p>
                            </div>
                        </a>
                    </div>
                </div>                          
            </div>
            
    <!--footer star-->
    <!-- <footer class="page-footer fixed-footer" id="footer">
        <ul>
            <li class="active">
                <a href="<?= url(['site/shop']) ?>">
                    <p>首页</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['order/position']) ?>">
                    <p>订单</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['site/cart']) ?>">
                    <p>购物车</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['site/my']) ?>">
                    <p>我的</p>
                </a>
            </li>
        </ul>
    </footer> -->
    <!--footer end-->
</body>
<script>
    $(function () {
        var confirm_true = <?php
            echo $confirm_true == ""? 0: $confirm_true;
        ?>;
        if(confirm_true != 1){
            checkPwd();
        }
    });
    function checkPwd()
    {
        $(".pwd_mask").show();
    }

    $(".pwd_submit").click(function(){
        var value = $(".pwd_section input").val();
        $.post({
            url: "<?=url(['user/check-deal-pwd'])?>",
            data: {deal_pwd:value},
            dataType:'json',
            success: function (ret) {
                if (ret.info == -1) {
                    $.alert(ret.data);
                    setTimeout(function(){
                        window.location.href='/user/setreal';
                    },1000);
                }else if(ret.info == -2)
                {
                    $.alert(ret.data);
                }
                else if(ret.info == -3)
                {
                    $.alert(ret.data);
                }
                else {
                    $(".pwd_mask").hide();
                }
            }
        });
    });
</script>
