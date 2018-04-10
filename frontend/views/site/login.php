<style type="text/css">
  body{
    background: #fff;
  }
  .login-mask {
    background: #ddd;
  }
  .login-container {
    background: #fff;
  }
  .login-container .title{
    color: #333;
  }
  .pwd-input {
    font-size: .42rem;
    color: #333;
    border-bottom: 1px solid #999;
  }
  .title1 a {
    font-size: .44rem;
    color: #e4393c;
    margin-bottom: 0.7rem;
}
.login-btn {
    color: #fff;
    background: #e4393c;
}
</style>
<?php $form = self::beginForm(['showLabel' => false, 'class' => 'my-form']) ?>
<div class="login-mask">
    <div class="login-container">
        <p class="title">请输入账户信息</p>
        <!-- <input class="pwd-input" placeholder="请输入登录密码"/> -->
        <?= $form->field($model, 'username')->textInput(['placeholder' => '请输入手机号', 'class' => 'pwd-input']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码', 'class' => 'pwd-input']) ?>
        <p class="title1"><a href="<?= url(['site/forget']) ?>">忘记密码</a>
        <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=<?= wechatInfo()->appid ?>&redirect_uri=http%3a%2f%2f<?= $_SERVER['HTTP_HOST'] ?>/site/register&response_type=code&scope=snsapi_userinfo&state=index#wechat_redirect">用户注册</a>
            <!--a href="<?=url(['site/register'])?>">用户注册</a-->
        </p>
        <button class="login-btn" type="submit">立即登录</button>
    </div>
</div>
<?php self::endForm() ?>
<script>
  $(function () {
      $(".login-btn").click(function () {
          $("form").ajaxSubmit($.config('ajaxSubmit', {
              success: function (msg) {
                  if (!msg.state) {
                      return $.alert(msg.info);
                  } else {
                      window.location.href = msg.info;
                  }
              }
          }));
          return false;
      });
  });
</script>