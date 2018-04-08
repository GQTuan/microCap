<style type="text/css">
    body{
        background: #fff;
    }
    .user-header {
        color: #333;
        background: #f6f6f6;
        border-bottom: 1px solid #ddd;
    }
    .line-height {
        background: #f6f6f6;
        border-bottom: 1px solid #ddd;
    }
    .line-height a {
        width: 100%;
        font-size: .4rem;
        color: #666;
    }
    .line-height .charge {
        border-left: 1px solid #ddd;
    }
    .my-coupon {
        border-left: 1px solid #ddd;
    }
    .line-height.has-arrow:after {
        border-bottom: 2px solid #999;
        border-right: 2px solid #999;
    }
    .my-coupon:before {
        opacity: .5;
    }
    .my-balance:before {
        opacity: .5;
    }
    .user-container a:before{
        opacity: .5!important;
    }
</style>
<div class="user-container">
<a href="<?= url(['user/setting']) ?>">
    <p class="user-header has-arrow">
        <img src="<?= $user->face ?>">
        <span class="name"></span>
        <span><?= $user->username ?></span>
    </p>
</a>
    <p class="flex-nowrap line-height hasmargin">
        <a href="<?= url(['user/recharge']) ?>" class="recharge">充值</a>
        <a href="<?= url(['user/withDraw']) ?>" class="charge">提现</a>
    </p>
    <p class="flex-nowrap line-height hasmargin has-arrow">
        <a  class="my-balance">余额 <span><?= $user->account - $user->blocked_account ?></span></a>
        <a href="<?= url(['user/coupon']) ?>" class="my-coupon">我的代金券 <span class="my-coupon-count"><?= $count>0?$count:0; ?></span>张</a>
    </p>
    <p class="flex-nowrap line-height">
        <a href="<?= url(['user/order']) ?>" class="my-account">我的账单 <span class="rt"></span></a>
    </p>
    <p class="flex-nowrap line-height">
        <a href="<?= url(['user/withDrawLists']) ?>" class="my-with">我的提现 <span class="rt"></span></a>
    </p>
    <p class="flex-nowrap line-height  has-arrow">
        <a href="<?= $urls ?>" class="my-jingjiren">大微圈 <span class="rt"><?= $manager ?></span></a>
    </p>
    <p class="flex-nowrap line-height">
        <a href="<?= url(['user/bankCard']) ?>" class="my-with">绑定银行卡 <span class="rt"></span></a>
    </p>
    <p class="flex-nowrap line-height">
        <a href="<?= url(['site/logout']) ?>" class="quit">退出登录 </a>
    </p>
</div>