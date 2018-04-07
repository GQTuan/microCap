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