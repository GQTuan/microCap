<?php $this->regCss('experience.css') ?>
<style type="text/css">
  .flex-nowrap{
    height:40px;
    line-height: 40px;
    background: #292D36;
    padding:0 30px;
  }
  .flex-nowrap li{
    width: 100%;
    text-align: center;
    color: #fff;
    font-size: 15px;
    box-sizing:border-box;
    margin:0 20px;
    position: relative;
  }
  .flex-nowrap li+li:after{
    content: "";
    position: absolute;
    height:18px;
    border-left:1px solid #21252B;
    left: -20px;
    top: 11px;
  }
  .flex-nowrap li.active{
    color:#DCAB05;
    border-bottom:1px solid #DCAB05;
  }
  .price_btn{
    background: #1E2327;
    position: relative;
    margin:0 30px;
    margin-top:15px;
    width:calc(100% - 60px);
    height:120px;
    border-radius:6px;
    border:1px solid #454E5F;
    overflow: hidden;
  }
  .djq{
    position: absolute;
    padding:0 10%;
    background: #292D36;
    height:120px;
    left: -20%;
    top:0;
    -webkit-writing-mode: vertical-rl;
    writing-mode: tb-rl;
    writing-mode: vertical-rl;
    text-align: center;
    font-size:18px;
    color:#bdbdbd;
  }
  .col-xs-4.mar{
    width: 100%;
  }
  .acount{
    position: absolute;
    width:100%;
    text-align: center;
    margin-left:20%;
  }
  .syzs{
    position: absolute;
    width:100%;
    text-align: center;
    margin-left:20%;
    top:46px;
    font-size:15px;
    color:#6d7891;
  }
  .text-container{
    position: absolute;
    width:100%;
    text-align: center;
    margin-left:20%;
    top:75px;
    font-size:15px;
    color:#fff;
  }
</style>
<!--头部导航-->
    <div class="container">
       <div class="row">
         <div class="header">
           <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
           我的代金券
         </div>
       </div>
   </div>
<!--中间内容-->
<ul class="flex-nowrap">
  <li class="active"><a href="">未使用(0)</a></li>
  <li><a href="">已使用(1)</a></li>
  <li><a href="">已过期(1)</a></li>
</ul>
<div class="container mar_t10">
    <?php foreach ($userCoupons as $userCoupon) :?>
        <div class="row">
            <div class="price_btn">
                <div class="djq">代金券</div>
                <div class="col-xs-4 mar">
                    <p class="mar_t10 acount">￥<span class="font_28"><?= $userCoupon->coupon->amount ?></span></p>
                    <p class="syzs">剩余<?= $userCoupon->number ?>张</p>
                </div>
                <div class="mar col-xs-8 font_12 text-right text-container">
                    <span class="mar">过期天数</span>
                    <span><?= round((strtotime($userCoupon->valid_time) - time())/86400, 0) ?></spanp>
                    <span class="mar_t20">请尽快使用</span>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
