<?php $this->regCss('price') ?>
<?php $this->regCss('login') ?>

<style type="text/css">
    #wizard-toolbar{
        display: none;
    }
    .db {
        display: inline;
    }

    header p {
    font-size: .5rem;
    margin-top: 0.05rem;
}
.shopcar {
    width: 100%;
}

.shopcar .list {
    width: 100%;
    height: 4rem;
    background-color: #fff;
    margin-bottom: 3%;
    padding: .5rem .2rem;
}

.shopcar .list .xuan {
    width: .8rem;
    height: .8rem;
    margin-top: 1.1rem;
}

label {
    width: 100%;
    display: block;
    position: relative;
    font-weight: normal;
    left: .4rem;
}

.radio input[type="checkbox"] {
    display: inline-block;
    margin-right: 15px;
    width: 14px;
    height: 14px;
}

.radio input[type="radio"] {
    display: inline-block;
    margin-right: 15px;
    opacity: 0;
}

.shopcar .list .tu {
    width: 3rem;
    height: 3rem;
    font-size: 0;
    border: 1px solid #e2e2e2;
    text-align: center;
    margin-left: .4rem;
}

.shopcar .list .tu span {
    display: inline-block;
    height: 100%;
    line-height: 0;
    vertical-align: middle;
}

.shopcar .list .tu img {
    max-width: 100%;
}

.shopcar .list .right {
    height: 3rem;
    width: 57%;
    margin-left: 2%;
}

.shopcar .list .right .tit {
    color: #333333;
    font-size: .5rem;
    line-height: .8rem;
}

.shopcar .list .right .fu-tit {
    color: #999999;
    font-size: .35rem;
}

.shopcar .list .right .jifen {
    font-size: .5rem;
    color: #f44623;
    margin-top: .2rem;
}

.shopcar .list .right .bottom {
    width: 100%;
    margin-top: .2rem;
}

.shopcar .list .right .bottom .zuo ul li {
    float: left;
    color: #333;
    font-size: .4rem;
    width: .5rem;
    height: .5rem;
    text-align: center;
    line-height: .5rem;
}

.shopcar .list .right .bottom .zuo ul li img {
    width: 100%;
}

.shopcar .list .right .bottom i {
    line-height: .8rem;
    color: #9e9e9e;
    font-size: .5rem;
}

.settlement {
    width: 100%;
    height: 1.8rem;
    position: fixed;
    bottom: 1.3rem;
    border-top: 1px solid #f4f4f4;
    background-color: #fff;
}

.settlement .zuo {
    width: 60%;
    height: 1.8rem;
    line-height: 1.8rem;
    padding: 0 .5rem;
    font-size: .5rem;
    color: #666666;
}

.settlement .zuo span {
    color: #ff4141;
}

.settlement a {
    width: 40%;
    height: 1.8rem;
    line-height: 1.8rem;
    background-color: #f44623;
    font-size: .5rem;
    color: #fff;
    text-align: center;
}
.tu img {
    padding-top: 17px;
}
.checkbox label, .radio label {
    padding-left: 0;
}
p {
    margin: 0;
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
    <!--header star-->
    <header class="mui-bar mui-bar-nav" id="header">
        <a class="btn" href="javascript:history.go(-1)">
            <i class="iconfont icon-fanhui"></i>
        </a>
        <h4>购物车</h4>
    </header>
    <!--header end-->
    
    <div class="warp warptwo clearfloat">
        <div class="shopcar clearfloat">
            <div class="list clearfloat fl">
                <div class="xuan clearfloat fl">
                    <div class="radio" > 
                        <label>
                            <input type="checkbox" name="sex" value="" />
                        </label>
                    </div>
                </div>
                <a href="javascript:void(0)">
                    <div class="tu clearfloat fl">
                        <span></span>
                        <img src="/images/xj.jpg"/>
                    </div>
                    <div class="right clearfloat fl">
                        <p class="tit over">单反相机，彰显你的风格</p>
                        <p class="fu-tit over">颜色：蓝色  内存：120G</p>
                        <p class="jifen over">100000积分</p>
                        <div class="bottom clearfloat">
                            <div class="zuo clearfloat fl">
                                <ul>
                                    <li><img src="/images/jian.jpg"/></li>
                                    <li>1</li>
                                    <li><img src="/images/jia.jpg"/></li>
                                </ul>
                            </div>
                            <i class="iconfont icon-lajixiang fr"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="list clearfloat fl">
                <div class="xuan clearfloat fl">
                    <div class="radio" > 
                        <label>
                            <input type="checkbox" name="sex" value="" />
                        </label>
                    </div>
                </div>
                <a href="javascript:void(0)">
                    <div class="tu clearfloat fl">
                        <span></span>
                        <img src="/images/xj.jpg"/>
                    </div>
                    <div class="right clearfloat fl">
                        <p class="tit over">单反相机，彰显你的风格</p>
                        <p class="fu-tit over">颜色：蓝色  内存：120G</p>
                        <p class="jifen over">100000积分</p>
                        <div class="bottom clearfloat">
                            <div class="zuo clearfloat fl">
                                <ul>
                                    <li><img src="/images/jian.jpg"/></li>
                                    <li>1</li>
                                    <li><img src="/images/jia.jpg"/></li>
                                </ul>
                            </div>
                            <i class="iconfont icon-lajixiang fr"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="list clearfloat fl">
                <div class="xuan clearfloat fl">
                    <div class="radio" > 
                        <label>
                            <input type="checkbox" name="sex" value="" />
                        </label>
                    </div>
                </div>
                <a href="javascript:void(0)">
                    <div class="tu clearfloat fl">
                        <span></span>
                        <img src="/images/xj.jpg"/>
                    </div>
                    <div class="right clearfloat fl">
                        <p class="tit over">单反相机，彰显你的风格</p>
                        <p class="fu-tit over">颜色：蓝色  内存：120G</p>
                        <p class="jifen over">100000积分</p>
                        <div class="bottom clearfloat">
                            <div class="zuo clearfloat fl">
                                <ul>
                                    <li><img src="/images/jian.jpg"/></li>
                                    <li>1</li>
                                    <li><img src="/images/jia.jpg"/></li>
                                </ul>
                            </div>
                            <i class="iconfont icon-lajixiang fr"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="list clearfloat fl">
                <div class="xuan clearfloat fl">
                    <div class="radio" > 
                        <label>
                            <input type="checkbox" name="sex" value="" />
                        </label>
                    </div>
                </div>
                <a href="javascript:void(0)">
                    <div class="tu clearfloat fl">
                        <span></span>
                        <img src="/images/xj.jpg"/>
                    </div>
                    <div class="right clearfloat fl">
                        <p class="tit over">单反相机，彰显你的风格</p>
                        <p class="fu-tit over">颜色：蓝色  内存：120G</p>
                        <p class="jifen over">100000积分</p>
                        <div class="bottom clearfloat">
                            <div class="zuo clearfloat fl">
                                <ul>
                                    <li><img src="/images/jian.jpg"/></li>
                                    <li>1</li>
                                    <li><img src="/images/jia.jpg"/></li>
                                </ul>
                            </div>
                            <i class="iconfont icon-lajixiang fr"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!--settlement star-->
    <div class="settlement clearfloat">
        <div class="zuo clearfloat fl box-s">
            合计：<span></span>
        </div>
        <a href="<?= url(['site/confirm']) ?>" class="fl db">
            立即结算
        </a>
    </div>
    <!--settlement end-->
    
    <!--footer star-->
    <footer class="page-footer fixed-footer" id="footer">
        <ul>
            <li>
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
            <li class="active">
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

    <script type="text/javascript">
        $('input[type="checkbox"]').click(function() { // 找到勾选按钮，绑定事件
            tatol();
        });
        $('.list ul img').click(function() { // 找到加减按钮，绑定点击事件
            var val = $(this).parent().parent().children().eq(1);
            if ($(this).parent().index()) {
                val.html(parseInt(val.html()) + 1);
            } else {
                val.html(val.html() > 1 ? parseInt(val.html()) - 1 : 1);
            }
            tatol();
        });
        $('.icon-lajixiang').click(function() { // 找到删除按钮，绑定点击事件
            var self = this;
            layer.open({
                content: '确定删除？',
                btn: ['确定', '取消'],
                yes: function(index) {
                    $(self).parent().parent().parent().parent().remove();
                    layer.closeAll();
                    tatol();
                }
            });
        });
        var tatol = function() { // 计算总积分
            var count = 0;
            $('.list').map(function(index, item) {
                var $el = $(item);
                if ($el.find('input[type="checkbox"]').is(":checked")) {
                    count += parseFloat($el.find('.jifen').html()) * parseInt($el.find('.zuo li').eq(1).html());
                }
            });
            if (count > 0) {
                $('.settlement span').html(count + '积分');
            }
        }
    </script>
    
</body>




