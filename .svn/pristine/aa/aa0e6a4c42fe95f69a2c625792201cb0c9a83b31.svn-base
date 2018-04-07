<style type="text/css">
   .form-control{
        line-height: .8rem!important;
        height: .8rem!important;
        border-radius: 0!important;
    }
</style>
<div class="register-container">
    <p class="img-container"><img src="../images/register-logo.png"></p>
    <p class="img-container user-reigister">用户注册</p>

    <!-- <form id="registerFrom"> -->
    <?php $form = self::beginForm(['showLabel' => false, 'id' => 'registerFrom']) ?>

        <div class="my-form-group flex-nowrap">
            <label>手机号码：</label>
            <!-- <input/> -->
            <?= $form->field($model, 'mobile')->textInput(['placeholder' => '请填写手机号', 'class' => 'user-mobile'])  ?>

        </div>

        <div class="my-form-group flex-nowrap">
            <label>验证码：</label>
            <!-- <input/> -->
            <?= $form->field($model, 'verifyCode')->textInput(['placeholder' => '请填写手机验证码' ,'class' => 'pwd-verifyCode'])  ?>

            <a data-action="<?= url(['site/verifyCode']) ?>" class="my-get-code">获取验证码</a>
        </div>
        <div class="my-form-group flex-nowrap">
            <label>邀请码：</label>
            <!-- <input/> -->
            <?= $form->field($model, 'code')->textInput(['placeholder' => '请填写邀请码', 'class' => 'user-code'])  ?>
        </div>
        <div class="my-form-group flex-nowrap">
            <label>交易密码：</label>
            <!-- <input type="password"/> -->
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入您的密码', 'class' => 'pwd-password'])  ?>

        </div>
        <div class="my-form-group flex-nowrap">
            <label>确认密码：</label>
            <!-- <input type="password"/> -->
            <?= $form->field($model, 'cfmPassword')->passwordInput(['placeholder' => '请确认您的密码', 'class' => 'pwd-password'])  ?>

        </div>
        <div>
            <p class="checkboxFour">
                <!-- <input type="checkbox" value="1" id="checkboxFourInput" name=""> -->
                <label for="checkboxFourInput"></label>
                <!-- <span>我已查看并同意<a href="#">《夕秀翻译资金托管条款》</a></span> -->
            </p>
        </div>
        <div class="my-form-group flex-nowrap">
            <input class="sumit" type="submit" value="立即注册"/>
        </div>
<?php self::endForm() ?>

</div>
<script>
$(function () {
    $(".sumit").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    window.location.href = msg.info;
                }
            }
        }));
        return false;
    });
    // 验证码
    $(".my-get-code").click(function () {
        var mobile = $('.user-mobile').val();
        var url = $(this).data('action');
        if (mobile.length != 11) {
            $.alert('您输入的不是一个手机号！');
            return false;
        }
        $.post(url, {mobile: mobile}, function(msg) {
              $.alert(msg.info);
        }, 'json');
    });
});
</script>