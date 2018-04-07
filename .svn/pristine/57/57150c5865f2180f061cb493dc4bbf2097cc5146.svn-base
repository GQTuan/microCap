<div class="modify-container">
    <?php $form = self::beginForm(['showLabel' => false]) ?>

    <p class="title">修改手机号</p>
    <div class="input-con has-getbtn clear-fl">
        <!-- <input type="" placeholder="请输入您的手机号"/> -->
        <?= $form->field($model, 'mobile')->textInput(['placeholder' => '请输入您的手机号码', 'class' => 'textvalue regTel'])  ?>

        <input type="button" class="get-btn" id="verifyCodeBtn" data-action="<?= url(['site/verifyCode']) ?>" value="获取验证码"/>
    </div>
    <div class="input-con">
        <!-- <input type="" placeholder="请输入手机验证码"/> -->
        <?= $form->field($model, 'verifyCode')->textInput(['placeholder' => '请输入手机验证码', 'class' => 'textvalue'])  ?>

    </div>
    <div class="input-con">
        <input class="submit" type="button" id="submitBtn" value="确认"/>
    </div>
    <?php self::endForm() ?>

</div>
<script>
$(function () {
    var $inputs = $('.regCode');
    $inputs.keyup(function() {
        if ($inputs.val().length >= 4) {
            $('#submitBtn').removeClass('disabled');
        } else {
            $('#submitBtn').addClass('disabled');
        }
    });
    //倒计时
    var wait = 60;
    function time(obj) {
        if (wait == 0) {
            obj.removeClass('disabled');           
            obj.html('重新获取验证码');
            wait = 60;
        } else {
            obj.addClass('disabled');
            obj.html('重新发送(' + wait + ')');
            wait--;
            setTimeout(function() {
                time(obj);
            },
            1000)
        }
    }
    //提交
    $("#submitBtn").click(function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
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
    $("#verifyCodeBtn").click(function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        var mobile = $('.regTel').val();
        var url = $(this).data('action');
        if (mobile.length != 11) {
            $.alert('您输入的不是一个手机号！');
            return false;
        }
        $.post(url, {mobile: mobile}, function(msg) {
                if (msg.state) {
                    time($('#verifyCodeBtn'));
                } else {
                    $.alert(msg.info);
                }
        }, 'json');
    });
});
</script>