
<?php $form = self::beginForm() ?>
<?= $model->title('排行榜') ?>
<?= $form->field($model, 'nickname') ?>
<?= $form->field($model, 'profit') ?>
<?= $form->field($model, 'file1')->upload() ?>
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