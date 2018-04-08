<style type="text/css">
    .input-con.has-getbtn .get-btn{
        width: 2.8rem!important;
    }
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
.input-con input {
    border: 1px solid #999;
    border-radius: 4px;
}
.input-con.has-getbtn .get-btn {
    color: #fff;
    background: #e4393c;
    border: 0;
    border-radius: 4px;
}
.input-con input.submit {
    height: 1.22rem;
    line-height: 1.22rem;
    font-size: .45rem;
    color: #fff;
    background: #e4393c;
    border: 0;
    margin-top: 0;
}
.modify-container .title{
    color: #666;
}
</style>
<?php $form = self::beginForm(['showLabel' => false]) ?>
<div class="modify-container">
    <p class="title">修改商品密码</p>
    <div class="input-con">
        <!-- <input type="password" placeholder="请输入原始密码"/> -->
          <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder' => '请输入原交易密码'])?>

    </div>
    <div class="input-con">
        <!-- <input type="password" placeholder="请输入6-18位数字"/> -->
          <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => '请输入6位新密码'])?>

    </div>
    <div class="input-con">
        <!-- <input type="password" placeholder="请再次输入密码"/> -->
          <?= $form->field($model, 'cfmPassword')->passwordInput(['placeholder' => '请再次输入交易密码'])?>

    </div>
    <div class="input-con">
        <input class="submit" type="button" value="确认"/>
    </div>
</div>
<?php self::endForm() ?>
<script>
$(function () {
    $(".submit").click(function () {  
     
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    $.alert(msg.info);
                    window.location.href = '<?= url(['user/index']) ?>'
                }
            }
        }));
        return false;
    });
});
</script>