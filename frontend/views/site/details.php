<?php use common\helpers\Html; ?>
<?php use frontend\models\Product; ?>
<?php common\assets\HighStockAsset::register($this) ?>
<?php $this->regJs('candle') ?>
<?php $this->regCss('login') ?>
<?php $this->regCss('price') ?>
<style type="text/css">
    body{
        width:100vw;
        overflow-x:hidden;
     }
     *{
        overflow-x: hidden;
     }
</style>
<div class="detail-container">
    <p class="flex-nowrap index-title">
        <img class="flex-none" src="../images/weibo.png">
        <span class="name">小童</span>
        <span class="balance">余额 <span>4654.13</span></span>
        <a class="my-btn-noflex flex-none">充值</a>
        <a class="my-btn-noflex flex-none">签到</a>
    </p>
    <div class="section">
        <ul class="flex-nowrap product-list">
            <li class="active"><a href="">
                <p>小原油</p>
                <p class="price down">44.568</p>
            </a></li>
            <li><a href="">
                <p>小恒指</p>
                <p class="price up">44.568</p>
            </a></li>
            <li><a href="">
                <p>小德指</p>
                <p class="price down">44.568</p>
            </a></li>
            <li><a href="">
                <p>美元</p>
                <p class="price up">44.568</p>
            </a></li>
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
            <img class="noflex" src="../images/send.jpg">
            <div class="mar-rig">
                <p class="down now-price">44.568</p>
                <p class="pro-name">小原油</p>
            </div>
            <div class="info-item">
                <p>最高 <span>45.26</span></p>
                <p>最低 <span>45.26</span></p>
            </div>
            <div class="info-item">
                <p>昨收 <span>45.26</span></p>
                <p>今开 <span>45.26</span></p>
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
        <a href=""></a>
        <a href=""></a>
    </p>
</div>