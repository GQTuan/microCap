
<p class="custom-title">
    <span>返佣金额 : <span><?= $extend->rebate_account ?></span> 元 </span>
    <span class="tip">注：以实际到账为准</span>
</p>
<?php $form = self::beginForm(['method' => 'get']) ?>
<div class="query-option">
    <span>日期：</span>
    <!-- <span>2017-11-05</span> -->
    <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'placeholder' => '请输入起始日期']) ?>

</div>
<div class="query-option">
    <span>至：</span>
    <!-- <span>2017-11-06</span> -->
    <?= $form->field($model, 'end_date')->textInput(['type' => 'date',  'placeholder' => '请输入结束日期']) ?>

</div>
<button  class="submit-btn btn-query" id="searchBtn" type="submit" >查询</button>
<?php self::endForm() ?>
<ul class="query-result">
    <li class="flex-nowrap">
        <span>客户昵称</span>
        <span>商品</span>
        <span>返佣金额</span>
        <span>时间</span>
    </li>
    <?= $this->render('_income', compact('data')) ?>

</ul>