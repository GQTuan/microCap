<style type="text/css">
    body{
        background: #fff;
    }
    .user-conf li {
        background: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .user-conf .title {
        color: #333;
    }
    .user-conf li p {
        color: #999;
    }
</style>
<!-- <?php common\components\View::regCss('geren.css') ?> -->

<!--头部导航-->
<!-- <div class="forget">
    <div class="center-list-wrap">
        <ul>
            <li class="table bottom-wrap" data-index="0">
                <a href="<?= url(['user/modifyPwd']) ?>" class="content-w">
                    <div class="content-wrap table-cell">
                        <div class="title">修改交易密码</div>
                        <div class="title-tip">为了您的资金安全，请妥善保管您的交易密码</div>
                    </div>
                </a>
                <div class="table-cell" style="padding-bottom: 0px;"><span class="earrow earrow-right"></span></div> 
            </li>
            <li class="table bottom-wrap" data-index="1">
                <a href="<?= url(['user/modifyPhone']) ?>" class="content-w">
                    <div class="content-wrap table-cell">
                        <div class="title"><span>验证手机</span><span id="mobile" style="padding-left: 0.5em; color: red; font-size: 13px;">
                        <?php if (strlen(u()->mobile) <= 10): ?>
                            您还未设置手机号码
                        <?php else : ?>
                            <?= substr(u()->mobile, 0, 3) . '*****' . substr(u()->mobile, -3) ?>
                        <?php endif ?>
                        </span></div>
                        <div class="title-tip">若您的验证手机丢失或停用，请立即更换</div>
                    </div>
                </a>
                <div class="table-cell" style="padding-bottom: 0px;"><span class="earrow earrow-right"></span></div>
            </li>
        </ul>
    </div>
</div> -->

<ul class="user-conf">
  <li>
    <a href="<?= url(['user/modifyPwd']) ?>">
      <p class="title">修改密码</p>
      <p>为了您的资金安全，请妥善保管您的密码</p>
    </a>
  </li>
  <li>
    <a href="<?= url(['user/modifyPhone']) ?>">
      <p class="title">验证手机 <span>
            <?php if (strlen(u()->mobile) <= 10): ?>
                您还未设置手机号码
            <?php else : ?>
                <?= substr(u()->mobile, 0, 3) . '*****' . substr(u()->mobile, -3) ?>
            <?php endif ?>  
      </span></p>
      <p>为了您的资金安全，请妥善保管您的密码</p>
    </a>
  </li>
</ul>
