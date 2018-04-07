<?php use common\helpers\Hui; ?>

<h2 style="text-align: center"><?= $model->name ?></h2>
<h5 style="text-align: center; color: red;">填写时间后，清除这个时间点之前的数据</h5>
<div class="row cl field-product-clear_time">
    <label class="form-label col-sm-2" for="product-clear_time">总条数</label>
    <div class="formControls col-sm-9"><?= $count[0]['count'] ?>条</div>
    <div class="help-block"></div>
</div>
<?php $form = self::beginForm() ?>
<div class="trade-time-row">
<?= $form->field($model, 'clear_time')->datepicker(['placeholder' => '清除时间点'])->label('清除时间点') ?>
</div>

<?= $form->submit() ?>
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