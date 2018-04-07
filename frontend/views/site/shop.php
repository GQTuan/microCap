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
    .db {
        display: inline;
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
    <!--头部区域-->
    <header class="mui-bar mui-bar-nav" id="header">
        <h4>积分商城</h4>
    </header>
    <div id="main" class="clearfloat warp">         
        <div class="mui-content">
            <!--banner开始-->
            <div class="banner swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="javascript:void(0)"><img class="swiper-lazy" data-src="/images/banner4.jpg" alt=""></a></div>
                    <div class="swiper-slide"><a href="javascript:void(0)"><img class="swiper-lazy" data-src="/images/banner1.jpg" alt=""></a></div>
                    <div class="swiper-slide"><a href="javascript:void(0)"><img class="swiper-lazy" data-src="/images/banner3.jpg" alt=""></a></div>
                </div>
            </div>
            <!--第一栏分类开始-->
            <div class="cation clearfloat box-s">
                <ul>
                    <li>
                        <a href="#">
                            <img src="/images/ico5.png"/>
                            <p>新品专区</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/images/ico2.png"/>
                            <p>送礼首选</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?= url(['site/index']) ?>">
                            <img src="/images/ico3.png"/>
                            <p>惠赚钱</p>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="/images/ico4.png"/>
                            <p>私人定制</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!--第一栏分类结束-->
            
        
            <!--1F家居用品、电器-->
            <div class="theme clearfloat">
                <div class="boutit clearfloat">
                    <span></span>
                    <samp>1F家居用品、电器</samp>
                </div>
                <div class="content clearfloat">
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f1.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">利仁（Liven） DHG-233A 电火锅</p>
                                <p><span>积分:</span><span class="over db red">11000</span></p>
                            </div>
                        </a>
                    </div>

                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f2.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">九阳（Joyoung）榨汁机家用果汁机（汁渣分离</p>
                                <p><span>积分:</span><span class="over db red">11000</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f3.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">亿嘉IJARL LOTOTO 时尚创意 带盖马克杯 水杯 绿色兔子 FM491008TZM</p>
                                <p><span>积分:</span><span class="over db red">1500</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f2.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">九阳（Joyoung）榨汁机家用果汁机（汁渣分离</p>
                                <p><span>积分:</span><span class="over db red">11000</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f3.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">亿嘉IJARL LOTOTO 时尚创意 带盖马克杯 水杯 绿色兔子 FM491008TZM</p>
                                <p><span>积分:</span><span class="over db red">1500</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="list clearfloat fl">
                        <a href="<?= url(['site/detail']) ?>">
                            <div class="tu clearfloat fr">
                                <span></span>
                                <img src="/images/1f1.jpg" />
                            </div>
                            <div class="shang clearfloat fl box-s">
                                <p class="tit over">利仁（Liven） DHG-233A 电火锅</p>
                                <p><span>积分:</span><span class="over db red">11000</span></p>
                            </div>
                        </a>
                    </div>
                </div>                          
            </div>
            <!--4F手机、数码配件-->
            <div class="theme clearfloat">
                <div class="boutit clearfloat">
                    <span></span>
                    <samp>4F手机、数码配件</samp>
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
                                <p><span>积分:</span><span class="over db red">100000</span></p>
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
                                <p><span>积分:</span><span class="over db red">2900</span></p>
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
                                <p><span>积分:</span><span class="over db red">2680</span></p>
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
                                <p><span>积分:</span><span class="over db red">3980</span></p>
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
                                <p><span>积分:</span><span class="over db red">1000</span></p>
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
                                <p><span>积分:</span><span class="over db red">1000</span></p>
                            </div>
                        </a>
                    </div>
                </div>                          
            </div>
            
    <!--footer star-->
    <footer class="page-footer fixed-footer" id="footer">
        <ul>
            <li class="active">
                <a href="<?= url(['site/shop']) ?>">
                    <i class="iconfont icon-shouye"></i>
                    <p>首页</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['order/position']) ?>">
                    <i class="iconfont icon-icon04"></i>
                    <p>订单</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['site/cart']) ?>">
                    <i class="iconfont icon-gouwuche"></i>
                    <p>购物车</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['site/my']) ?>">
                    <i class="iconfont icon-yonghuming"></i>
                    <p>我的</p>
                </a>
            </li>
        </ul>
    </footer>
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
        layer.prompt({
                formType:1,
                title:'请输入交易密码',
            },
            function(value, index, elem){
                $.post({
                    url: "<?=url(['user/check-deal-pwd'])?>",
                    data: {deal_pwd:value},
                    dataType:'json',
                    success: function (ret) {
                        layer.closeAll();
                        if (ret.info == -1) {
                            $.alert(ret.data);
                            window.location.href='/user/setreal'
                        }else if(ret.info == -2)
                        {
                            $.alert(ret.data);
                        }
                        else if(ret.info == -3)
                        {
                            $.alert(ret.data);
                        }
                        else {
//                            window.location.href = '/site/index';
                        }
                    }
                });
            });
    }
</script>
