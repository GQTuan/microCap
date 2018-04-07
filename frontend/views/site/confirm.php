<?php $this->regCss('price') ?>
<?php $this->regCss('login') ?>

<style type="text/css">
    #wizard-toolbar{
        display: none;
    }
    .box-s {
        box-shadow: none;
    }
    .btn {
        padding: 0;
        border-radius: 0;
    }


    /*头部 区域*/
.mui-bar-nav {
    display: -webkit-flex;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    align-items: center;
    font-size: .36rem;
}
.btn {
    padding-top: .1rem;
}
.top-sch-boxtwo {
    background: none;
    line-height: 1.1rem;
    margin: 0;
    padding: 0;
    font-size: .5rem;
    color: #333;
}
.top-sch-box {
    height: 0.9rem;
    margin: 0 .3rem;
    font-size: .36rem;
    color: #999999;
    -webkit-border-radius: 3px;
    border-radius: 3px;
}
.flex-col {
    display: block;
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    flex: 1;
    width: .1px;
    font-size: .5rem;
    color: #fff;
}

.confirm {
    width: 100%;
    margin-bottom: 3%;
}

.confirm .add {
    background-color: #fff;
    height: 3rem;
    padding: 0 .2rem;
}

.confirm .add .left {
    width: 8%;
    line-height: 1rem;
    margin-top: 1.25rem;
    text-align: center;
}

.confirm .add .left i {
    font-size: .4rem;
    color: #5d6268;
}

.confirm .add .middle {
    width: 80%;
}

.confirm .add .middle .tit {
    font-size: .5rem;
    color: #333333;
    margin-top: .6rem;
}

.confirm .add .middle .fu-tit {
    font-size: .4rem;
    color: #333333;
    margin-top: .3rem;
}

.confirm .lie {
    margin-top: 2%;
    border-top: none;
    border-bottom: none;
    width: 100%;
    margin-bottom: 2%;
    background-color: #fff;
    border-top: 1px solid #e1e1e1;
    border-bottom: 1px solid #e1e1e1;
    padding: .4rem .2rem;
}
.confirm .lie .tu {
    width: 25%;
    text-align: center;
}


.confirm .lie .tu img {
    max-width: 100%;
}

.confirm .lie .right {
    width: 72%;
    margin-left: 3%;
}


.confirm .lie .right .tit {
    color: #333333;
    font-size: .4rem;
    line-height: .8rem;
}


.confirm .lie .right .xia {
    height: .8rem;
    line-height: .8rem;
    width: 100%;
}


.confirm .lie .right .jifen {
    width: 80%;
    color: #f44623;
    font-size: .45rem;
}

.confirm .lie .right .fu-tit {
    color: #999999;
    font-size: .35rem;
}

.confirm .lie .right .jifen {
    margin-top: .2rem;
    font-size: .5rem;
}

.confirm .lie .right span {
    margin-top: .2rem;
    color: #999999;
    font-size: .5rem;
}

.confirm .gmshu {
    width: 100%;
    padding: 0 .2rem;
    background-color: #fff;
    line-height: 1.5rem;
}

.confirm .gmshu .you {
    width: 3rem;
    height: 1rem;
    margin-top: .35rem;
}

.confirm .gmshu .you ul li {
    float: left;
    height: 1rem;
    line-height: .8rem;
    width: 1rem;
    text-align: center;
}

.confirm .gmshu .you ul li img {
    width: 100%;
}

.confirm .gmshu p {
    font-size: .4rem;
    color: #001924;
}

.confirm .gmshu .gcontent {
    border-bottom: 1px solid #dfdfdf;
}

.confirm .gmshutwo .you {
    height: 1.5rem;
    line-height: 1.5rem;
    margin-top: 0;
    font-size: .4rem;
}

.confirm .gmshutwo .you {
    width: auto;
}

.confirm .gmshutwo .xuan {
    float: left;
}

label {
    width: 100%;
    display: block;
    position: relative;
    font-weight: normal;
}

.radiotwo .option {
    width: .4rem;
    height: .4rem;
    position: absolute;
    top: .55rem;
    left: .3rem;
    background-size: cover;
    background: url(/images/check1.png) no-repeat;
    background-size: cover;
}

.radiotwo input[type="radio"] {
    display: inline-block;
    margin-right: .5rem;
    opacity: 0;
}

input[type="radio"]:checked+div {
    background: url(/images/check2.png) no-repeat;
    background-size: cover;
}

.radiotwo .opt-text {
    font-size: .4rem;
}

.confirm .gmshuthree .you {
    width: 80%;
    margin-top: 0;
}

.confirm .gmshuthree .you .text {
    height: 1rem;
    line-height: 1rem;
    color: #333;
    margin: 0;
    padding: 0;
    text-indent: .5rem;
    border: none;
    font-size: .4rem;
}

.confirm .gmshu samp {
    color: #f44623;
    font-size: .4rem;
    font-family: "微软雅黑";
}

label {
    width: 100%;
    display: block;
    position: relative;
    font-weight: normal;
}

.radiothree .option {
    width: .6rem;
    height: .6rem;
    position: absolute;
    top: .5rem;
    left: .0;
    background-size: cover;
    background: url(/images/queren1.png) no-repeat;
    background-size: cover;
}

.radiothree input[type="checkbox"] {
    display: inline-block;
    margin-right: .5rem;
    opacity: 0;
}

input[type="checkbox"]:checked+div {
    background: url(/images/queren.png) no-repeat;
    background-size: cover;
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
    background-color: #00cc7d;
    font-size: .5rem;
    color: #fff;
    text-align: center;
}
p {
    margin: 0;
}
.settlement {
    bottom: 0;
}


</style>

<script type="text/javascript">
    sessionStorage.url = "confirm";
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
        <div class="top-sch-box top-sch-boxtwo flex-col">
                      确认订单
        </div>
    </header>
    <!--header end-->
    
    <div class="warp warptwo clearfloat">
        <div class="confirm clearfloat">
            <div class="add clearfloat box-s">
                <a href="address.html">
                    <div class="left clearfloat fl">
                        <i class="iconfont icon-dizhi1"></i>
                    </div>
                    <div class="middle clearfloat fl">
                        <p class="tit">
                            收货人：小王&nbsp;&nbsp;&nbsp;&nbsp;1580888888
                        </p>
                        <p class="fu-tit over2">
                            收货地址：湖南省长沙市高新区拓基城市广场金座A2002
                        </p>
                    </div>
                    <div class="left clearfloat fr">
                        <i class="iconfont icon-jiantou1"></i>
                    </div>
                </a>
            </div>
            <div class="lie clearfloat">
                <a href="<?= url(['site/detail']) ?>">
                    <div class="tu clearfloat fl">
                        <img src="/images/xj.jpg"/>
                    </div>
                </a>
                <div class="right clearfloat fl">
                    <a href="<?= url(['site/detail']) ?>">
                        <p class="tit over">单反相机，彰显你的风格</p>
                        <p class="fu-tit">颜色：蓝色  内存：120G</p>
                    </a>
                    <div class="xia clearfloat">
                        <a href="<?= url(['site/detail']) ?>">
                            <p class="jifen fl over">100000积分</p>
                        </a>
                        <span class="fr db">×1</span>
                    </div>
                </div>
            </div>
            <div class="gmshu clearfloat box-s fl">
                <div class="gcontent clearfloat">
                    <p class="fl">购买数量</p>
                    <div class="you clearfloat fr">
                        <ul>
                            <li><img src="/images/jian.jpg"/></li>
                            <li>1</li>
                            <li><img src="/images/jia.jpg"/></li>
                        </ul>
                    </div>
                </div>                  
            </div>
            <div class="gmshu gmshutwo clearfloat box-s fl">
                <div class="gcontent clearfloat">
                    <p class="fl">配送方式</p>
                    <div class="you clearfloat fr">
                        <span>快递 免邮</span>
                        <i class="iconfont icon-jiantou1"></i>
                    </div>
                </div>                  
            </div>
            <div class="gmshu gmshutwo clearfloat box-s fl">
                <div class="gcontent clearfloat">
                    <p class="fl">发票信息</p>
                    <div class="you clearfloat fr">
                        <div class="xuan clearfloat">
                            <div class="radiotwo" > 
                                <label>
                                    <input type="radio" name="fapiao" value="" checked/>
                                    <div class="option"></div>
                                    <span class="opt-text">需要发票</span>
                                </label>
                            </div>
                        </div>
                        <div class="xuan clearfloat">
                            <div class="radiotwo" > 
                                <label>
                                    <input type="radio" name="fapiao" value=""/>
                                    <div class="option"></div>
                                    <span class="opt-text">不需要发票</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>                  
            </div>
            <div class="gmshu gmshuthree clearfloat box-s fl">
                <div class="gcontent clearfloat">
                    <p class="fl">买家留言</p>
                    <div class="you clearfloat fl">
                        <input type="text" name="" id="" value="" class="text" placeholder="选填 对本次交易需求给商家留言" />
                    </div>
                </div>                  
            </div>
            <div class="gmshu clearfloat box-s fl">
                <p class="fr">共1件商品   合计<samp>100000积分</samp></p>               
            </div>
            
        </div>
    </div>      
    
    <!--settlement star-->
    <div class="settlement clearfloat">
        <div class="zuo clearfloat fl box-s">
            共<span>1</span>件  总积分：<span>100000</span>
        </div>
        <a href="<?= url(['site/pay']) ?>" class="fl db">
            提交订单
        </a>
    </div>
    <!--settlement end-->
    
    <!--footer star-->
    <!-- <footer class="page-footer fixed-footer" id="footer">
        <ul>
            <li class="active">
                <a href="<?= url(['site/shop']) ?>">
                    <i class="iconfont icon-shouye"></i>
                    <p>首页</p>
                </a>
            </li>
            <li>
                <a href="<?= url(['site/classfiy']) ?>">
                    <i class="iconfont icon-icon04"></i>
                    <p>分类</p>
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
    </footer> -->
    <!--footer end-->
</body>