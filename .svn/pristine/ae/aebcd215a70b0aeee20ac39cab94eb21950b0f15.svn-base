
<!-- <style>body{background:#f2f2f2 !important;}</style>
<div id="main">
    <div class="querylist-box" style="visibility: visible;">
        <div class="queryheader-wrap">
            <div class="queryheader"><i class="icon1 icon-costom"></i>
                <span class="headervalue">总人数:<span class="redsymbol"><?= $userNum ?>人</span></span>
            </div>
            <?php $form = self::beginForm(['method' => 'get']) ?>
            <div class="condition">
                <div class="boxflex">
                    <div class="key">手机号:
                    </div>
                    <div class="value box_flex_1">
                        <?= $form->field($model, 'mobile')->textInput(['class' => 'input-mobile', 'placeholder' => '请输入手机号码']) ?>
                    </div>
                </div>
            </div>
            <div class="btn-queryheader">
                <div class="btn-query"><button class="btn btn-45-24-blue" id="searchBtn" type="submit">查询</button>
                </div>
            </div>
            <?php self::endForm() ?>
        </div>

        <div class="listwrap">
            <div class="boxflex header">
                <div class="name box_flex_1">客户昵称
                </div>
                <div class="phone box_flex_1">手机号
                </div>
                <div class="balance box_flex_1">余额
                </div>
                <div class="time box_flex_1">注册时间
                </div>
            </div>
            <?php foreach ($data as $user): ?>
            <div class="boxflex header list">
                <div class="name box_flex_1"><?= $user->nickname ?>
                </div>
                <div class="phone box_flex_1"><?= $user->mobile ?>
                </div>
                <div class="balance box_flex_1"><?= $user->account ?>
                </div>
                <div class="time box_flex_1"><?= $user->created_at ?>
                </div>
            </div>
            <?php endforeach ?>

            <?= self::linkPager() ?>
            <div class="iscroll-wrap" style="height: 382px;">
                <div class="iscroll-content" style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px); min-height: 383px;">
                    <ul style="min-height: 383px;">
                        <li class="data-empty">当前查询记录为<?= $count ?>条</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
 -->
<p class="custom-title">
    <span>总人数 : <span><?= $userNum ?></span> 人 </span>
</p>
<?php $form = self::beginForm(['method' => 'get']) ?>
    <div class="query-option">
        <span>手机号</span>
        <!-- <input placeholder="请输入手机号码"/> -->
        <?= $form->field($model, 'mobile')->textInput(['placeholder' => '请输入手机号码']) ?>
    </div>
    <button  class="submit-btn btn-query" id="searchBtn" type="submit">查询</button>
<?php self::endForm() ?>

<ul class="query-result">
    <li class="flex-nowrap">
        <span>客户昵称</span>
        <span>手机号</span>
        <span>余额</span>
        <span>注册时间</span>
    </li>
    <?php foreach ($data as $user): ?>
    <li class="flex-nowrap">
        <span><?= $user->nickname ?></span>
        <span><?= $user->mobile ?></span>
        <span><?= $user->account ?></span>
        <span><?= substr($user->created_at, 0, 10) ?></span>
    </li>
    <?php endforeach ?>
</ul>