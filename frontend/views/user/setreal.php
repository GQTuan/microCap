<style type="text/css">
    body{
        background: #fff;
    }
    .modify-container .title {
        color: #333;
    }
    .input-con input {
        width: 100%;
        height: 1.1rem;
        line-height: 1.1rem;
        padding-left: .3rem;
        font-size: .38rem;
        color: #333;
        background: transparent;
        border: 1px solid #ddd;
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
</style>
<?php $form = self::beginForm(['showLabel' => false]) ?>
<div class="modify-container">
    <p class="title">设置交易密码</p>
    <div class="input-con">
        <!-- <input type="password" placeholder="请输入原始密码"/> -->
        <?= $form->field($model, 'newDealPassword')->passwordInput(['placeholder' => '请输入6-18位字母或数字', 'class' => 'textvalue']) ?>

    </div>
    <div class="input-con">
        <!-- <input type="password" placeholder="请输入6-18位数字"/> -->
        <?= $form->field($model, 'confirmDeal')->passwordInput(['placeholder' => '请再次输入交易密码', 'class' => 'textvalue']) ?>

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
                        window.location.href = '<?= url(['user/my']) ?>'
                    }
                }
            }));
            return false;
        });
    });
</script>