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
    html {
    font-size: 10px
}

@media screen and (min-width:321px) and (max-width:375px) {
    html {
        font-size: 11px
    }
}

@media screen and (min-width:376px) and (max-width:414px) {
    html {
        font-size: 12px
    }
}

@media screen and (min-width:415px) and (max-width:639px) {
    html {
        font-size: 15px
    }
}

@media screen and (min-width:640px) and (max-width:719px) {
    html {
        font-size: 20px
    }
}

@media screen and (min-width:720px) and (max-width:749px) {
    html {
        font-size: 22.5px
    }
}

@media screen and (min-width:750px) and (max-width:799px) {
    html {
        font-size: 23.5px
    }
}
@media screen and (min-width:800px) {
    html {
        font-size: 25px
    }
}
body,h1,h2,h3,h4,h5,h6,hr,p,blockquote,dl,dt,dd,ul,ol,li{
    margin: 0;
    padding: 0;
    -webkit-overflow-scrolling: touch;
}
address,caption,cite,code,dfn,em,th,var,i {
    font-style: normal;
    font-weight: normal;
}
body {
    font: 14px/1.5 tahoma, Verdana, arial, microsoft yahei, "\5b8b\4f53";
    color: #676b70;
}
a {
    color: #676b70;
    text-decoration: none;
    outline: none;
}

ol,ul {
    list-style: none;
}
small {
    font-size: 12px
}
.iconfont {
    font-family: "iconfont" !important;
    font-size: 16px;
    font-style: normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;
}
@font-face {
    font-family: 'iconfont';
    src: url('../fonts/iconfont.woff') format('woff'),
    url('/images/iconfont_ali.svg#uxiconfont?t=4') format('svg');

}

.icon-sousuo:before {
    content: "\e623";
}

.icon-dizhi1:before {
    content: "\e618";
}
.icon-shouye:before {
    content: "\e62b";
}
.icon-icon04:before {
    content: "\e62d";
}
.icon-gouwuche:before {
    content: "\e629";
}

.icon-yonghuming:before {
    content: "\e600";
}

/*全局头部*/
.topbar {
    background: #03A9F4;
}

.back_btn {
    display: block;
    width: 1.5rem;
    height: 1.5rem;
    float: left;
    background: url(/images/back.png) no-repeat;
    background-size: 100%;
}

.back_btn i {
    display: none;
}

.page_title {
    text-align: center;
    height: 1.5rem;
    line-height: 1.5rem;
    font-size: .5rem;
    color: #fff;
    overflow: hidden;
}
/*边框*/

.border_top {
    border-top: solid 1px #dadada;
    -webkit-border-image: url(/images/border.gif) 2 0 round;
    border-image: url(/images/border.gif) 2 0 round;
    border-width: 1px 0 0 0;
}

.border_bottom {
    border-bottom: solid 1px #dadada;
    -webkit-border-image: url(/images/border.gif) 2 0 round;
    border-image: url(/images/border.gif) 2 0 round;
    border-width: 0 0 1px 0;
}

.border_top_bottom {
    border: solid 1px #dadada;
    -webkit-border-image: url(/images/border.gif) 2 0 round;
    border-image: url(/images/border.gif) 2 0 round;
    border-width: 1px 0;
}

.border_left {
    border-left: solid 1px #dadada;
    -webkit-border-image: url(/images/border2.gif) 0 2 round;
    border-image: url(/images/border2.gif) 0 2 round;
    border-width: 0 0 0 1px;
}

.border_right {
    border-right: solid 1px #dadada;
    -webkit-border-image: url(/images/border2.gif) 0 2 round;
    border-image: url(/images/border2.gif) 0 2 round;
    border-width: 0 1px 0 0;
}

/*会员头像*/
.vip-header {
    width: 100%;
    height: 150px;
    background: url(/images/vip_bg1.jpg) no-repeat;
    background-size: 110%;
    position: relative;
    overflow: hidden;
}

.vip-header a {
    color: #fff;
    display: block;
}
.vip-header dl {
    padding: 25px 6% 0 6%;
    overflow: hidden;
}
.vip-header dt {
    width: 65px;
    height: 65px;
    float: left;
    border-radius: 100%;
    border: 4px solid rgba(255, 255, 255, .4);
    overflow: hidden;
}
.vip-header img {
    width: 100%;
    height: 100%;
}
.vip-header dd {
    float: left;
    padding: 7px 0 0 10px;
}
.vip-header h4 {
    font-size: 16px;
    line-height: 32px;
    font-weight: normal;
}
.vip-header h4 span {
    font-size: 13px;
    background: #CDDC39;
    border-radius: 5px;
    padding: 2.6px 5px;
    margin-left: 10px;
}
.vip-header dd p {
    font-size: 14px;
}
.vip-header dd p i {
    color: #ffc601;
    margin: 5px;
}
.vip-header ul {
    width: 100%;
    overflow: hidden;
    position: absolute;
    bottom: 0;
}
.vip-header li {
    width: 33%;
    float: left;
    text-align: center;
    background: rgba(60, 60, 60, .3);
    padding: 3px 0;
    margin-right: .33%;
}
.vip-header li:last-child {
    margin-right: 0;
}
.vip-header li span {
    font-size: 16px;
}
/*会员俱乐部*/
.vip-club,.vip-list-icon {
    margin-top: 10px;
    background: #fff;
    overflow: hidden;
}
.vip-club li a {
    font-size: 14px;
    color: #686868;
    width: 25%;
    float: left;
    text-align: center;
    padding: 8px 0;
}
.vip-club li a i {
    font-size: 26px;
    line-height: 32px;
}
.vip-club-title {
    line-height: 44px;
    padding: 0 8px;
}
.vip-club-title span {
    color: #252525;
    font-size: 16px;
}
.vip-club-title span i {
    font-size: 20px;
    color: #4caf50;
    margin-right: 8px;
}
.vip-club-title a {
    float: right;
    color: #a8a9ab;
    font-size: 15px;
}
.vip-club-title a i {
    margin-left: 5px;
    font-size: 14px;
}
.vip-account .vip-club-title span i {
    color: #ff7979;
}
.vip-account .color_f44623 {
    color: #f44623;
    font-size: 18px;
    line-height: 26px;
}
.vip-account .color_f4a425 {
    color: #f4a425;
    font-size: 18px;
    line-height: 26px;
}
.vip-account .color_45a1de {
    color: #45a1de;
    font-size: 18px;
    line-height: 26px;
}
.vip-account .color_1dccaa {
    color: #1dccaa;
    font-size: 18px;
    line-height: 26px;
}
.vip-list-icon li {
    width: 100%;
    line-height: 30px;
    padding: 8px 0;
    overflow: hidden;
    text-align: center;
}
.vip-list-icon li:last-child {
    border-bottom: none;
}
.vip-list-icon li a {
    display: block;
    width: 49.8%;
    float: left;
    font-size: 15px;
}
.vip-list-icon li i {
    width: 36px;
    display: inline-block;
    color: #34a2f1;
    font-size: 21px;
    text-align: left;
}

/*底部*/

.page-footer {
    width: 100%;
    height: 1.5rem;
    background-color: #fff;
    border-top: 1px solid #dfdfdf;
    position: fixed;
    bottom: 0;
    left: 0;
}

.page-footer ul {
    width: 100%;
    background-color: #fafafa;
}

.page-footer ul li {
    float: left;
    width: 25%;
    text-align: center;
    padding: 1% 0 2%;
}

.page-footer ul li a {
    width: 100%;
    display: block;
}

.page-footer ul .active a p {
    color: #f44623;
    margin-bottom: 0;
}

.page-footer ul .active {
    width: 25%;
}

.page-footer ul li img {
    width: 25%;
}

.page-footer ul li p {
    font-size: .35rem;
    color: #333;
    
}

.page-footer ul li i {
    font-size: .5rem;
    color: #60636c;
}

.page-footer ul .active i {
    color: #f44623;
}
.vip-list-icon li {
    text-align: left;
}
.vip-list-icon li a{
    padding-left: 30px;
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

<body style="background-color: #f0f0f0">
    <header id="header" style="">
        <div class="topbar">
            <a href="javascript:history.back();" class="back_btn"><i class="iconfont">ş</i></a>
            <h1 class="page_title">会员中心</h1>
        </div>
    </header>
<!-- 会员头像 -->
    <div class="vip-header">
        <a href="javascript:void(0)">
            <dl>
                <dt>
                    <img src="<?=u()->face?>">
                    <input id="avatar" type="file" name="" style="position: absolute;width: 100%;height: 100%;z-index: 999;opacity: 0;right: 0;top: 0;">
                </dt>
                <dd>
                    <h4><?= u()->nickname ?></h4>
                    <p><span>提货券：<i><?=$userCoupons?></i></span>&nbsp;&nbsp;<span>账户余额(元)<i><?=$user->account-$user->blocked_account?></i></span></p>
                </dd>
            </dl>
        </a>
    </div>

    <div class="vip-list-icon border_top_bottom">
        <ul>
            <li class="border_bottom"> 
                <a href="<?= url(['user/recharge']) ?>" class="border_right"><i class="iconfont" style="font-size:23px;"></i><em>充值</em></a>
                <a href="<?= url(['user/withDraw']) ?>"><i class="iconfont" style="font-size:24px;"></i><em>提现</em></a> 
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/balancePayDetail') ?>"><i class="iconfont"></i><em>收支明细</em></a> 
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/transDetail') ?>"><i class="iconfont"></i><em>交易明细</em></a>
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/experience') ?>" class=""><i class="iconfont"></i><em>体验券</em></a>
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/manager') ?>" class=""><i class="iconfont"></i><em><?=$manager?></em></a>
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/share') ?>"><i class="iconfont icon-sousuo"></i><em>邀请码</em></a>
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/password') ?>" class=""><i class="iconfont"></i><em>修改密码</em></a>
            </li>
            <li class="border_bottom">
                <a href="<?= url('user/setreal') ?>" class=""><i class="iconfont"></i><em>修改交易密码</em></a>
            </li>
            <li class="border_bottom"> 
                <a href="<?= url('user/logout') ?>" class=""><i class="iconfont"></i><em>退出</em></a>
            </li>
        </ul>
    </div>
    <!--尾部-->
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
            <li>
                <a href="<?= url(['site/cart']) ?>">
                    <i class="iconfont icon-gouwuche"></i>
                    <p>购物车</p>
                </a>
            </li>
            <li class="active">
                <a href="<?= url(['site/my']) ?>">
                    <i class="iconfont icon-yonghuming"></i>
                    <p>我的</p>
                </a>
            </li>
        </ul>
    </footer>
    <script>
        $("input[type='file']").change(function () {
            var _formData = new FormData();
            _formData.append("avatar", document.getElementById("avatar").files[0]);
            $.ajax({
                url: "<?= url(['user/modifyAvatar']) ?>",
                type: "POST",
                data: _formData,
                contentType: false,
                processData: false,
                success: function (resp) {
                    if (resp.state) {
                        layer.alert("头像修改成功！");
                        window.location.reload();
                    } else {
                        layer.alert(resp.msg);
                    }
                },
                error: function (_err) {
                    layer.alert("头像修改失败！");
                }
            }, 'json');
        });
    </script>
</body>