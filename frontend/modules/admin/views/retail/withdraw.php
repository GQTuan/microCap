<?php $form = self::beginForm() ?>
<h2 style="text-align: center;">代理商体现申请</h2>
<div class="row cl field-retailwithdraw-amount required">
    <label class="form-label col-sm-2" for="retailwithdraw-amount">可体现金额</label>
    <div class="formControls col-sm-9"><?= $amount ?>元</div>

    <div class="help-block"></div>
</div>
<?= $form->field($model, 'amount')->textInput(['placeholder' => '输入提现金额']) ?>
<?= $form->field($retailAccount, 'bank_user')->textInput(['placeholder' => '请输入持卡人姓名']) ?>
<?= $form->field($retailAccount, 'bank_mobile')->textInput(['placeholder' => '请输入银行预留手机号']) ?>
<?= $form->field($retailAccount, 'bank_card')->textInput(['placeholder' => '请输入卡号']) ?>
<?= $form->field($retailAccount, 'bank_name')->textInput(['placeholder' => '请输入开卡银行'])  ?>
<?= $form->field($retailAccount, 'bank_address')->textInput(['placeholder' => '请输入开卡行地址']) ?>

<?= $form->submit($model) ?>
<?php self::endForm() ?>

<script>
$(function () {
    $("#submitBtn").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (msg.state) {
                    $.alert(msg.info || '操作成功', function () {
                        parent.location.reload();
                    });
                } else {
                    $.alert(msg.info);
                }
            }
        }));
        return false;
    });
});
</script>