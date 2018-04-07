<?php use common\helpers\Hui; ?>
<h2 style="text-align: center"><?= $model->admin->username ?>，返点余额<?= $model->admin->retail->total_fee ?>元</h2>
<?php $form = self::beginForm() ?>
<?= $form->field($model->user->userAccount, 'bank_address')->textInput(['disabled' => 'disabled', 'value' => $model->user->userAccount->address . ' ' . $model->user->userAccount->bank_address]) ?>
<?= $form->field($model->user->userAccount, 'bank_name')->dropDownlist() ?>
<?= $form->field($model->admin->retailAccount, 'bank_card')->textInput(['disabled' => 'disabled']) ?>
<?= $form->field($model->admin->retailAccount, 'bank_user')->textInput(['disabled' => 'disabled']) ?>
<?= $form->field($model->admin->retailAccount, 'bank_mobile')->textInput(['disabled' => 'disabled']) ?>
<?= $form->field($model, 'amount')->textInput(['disabled' => 'disabled']) ?>
<?php self::endForm() ?>
