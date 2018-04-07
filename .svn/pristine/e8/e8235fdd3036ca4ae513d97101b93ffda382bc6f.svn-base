<?php use common\helpers\Hui; ?>

<?php $form = self::beginForm() ?>
<?= $form->field($model, 'realname')->textInput(['disabled' => 'disabled']) ?>
<?= $form->field($model, 'tel') ?>
<?= $form->field($model, 'point')->textInput(['disabled' => 'disabled']) ?>
<?= $form->field($model, 'total_fee')->textInput(['disabled' => 'disabled']) ?>
<?php if (u()->power == admin\models\AdminUser::POWER_SETTLE || u()->power == admin\models\AdminUser::POWER_OPERATE): ?>
<?= $form->field($model, 'deposit')->textInput(['disabled' => 'disabled']) ?>
<?php endif ?>
<?php if (u()->power == admin\models\AdminUser::POWER_RING): ?>
<?= $form->field($model, 'code')->textInput(['disabled' => 'disabled']) ?>
<?php endif ?>
<?= $form->submit($model) ?>
<?php self::endForm() ?>

<script>
$(function () {
    $("#submitBtn").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (msg.state) {
                    $.alert('操作成功', function () {
                        parent.location.reload();
                    });
                } else {
                    $.alert(msg.info);
                }
            }
        }));
        return false;
    });
<?php if (u()->power == admin\models\AdminUser::POWER_SETTLE || u()->power == admin\models\AdminUser::POWER_OPERATE): ?>
    //持仓数据跳动
    function updateDeposit(){
        $.post('<?= url(['site/ajaxDeposit']) ?>', function(msg) {
            if (msg.state) { 
                $('#retail-deposit').val(msg.info);
            }
        }, 'json');
    }
    setInterval(updateDeposit, 3000);  
<?php endif ?>
});
</script>