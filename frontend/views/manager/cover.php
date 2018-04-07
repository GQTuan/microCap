
<p class="custom-title">
    <span>总单数 : <span><?= $count ?></span> 手 </span>
    <span>总手续费 : <span><?= $order ?></span> 元 </span>
</p>
<?php $form = self::beginForm(['method' => 'get']) ?>

<div class="query-option">
    <span>日期：</span>
    <!-- <span>2017-11-05</span> -->
    <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'class' => 'laydate-icon', 'placeholder' => '请输入起始日期']) ?>

</div>
<div class="query-option">
    <span>至：</span>
    <!-- <span>2017-11-06</span> -->
    <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'class' => 'laydate-icon', 'placeholder' => '请输入结束日期']) ?>

</div>
<div class="query-option">
    <span>商品：</span>
    <!-- <span>全部</span> -->
    <?= $form->field($model, 'product_id')->dropDownList($productArr, ['class' => 'coverSelect', 'placeholder' => '请选择商品', 'prompt' => '全部']) ?>

</div>
<button  class="submit-btn btn-query" id="searchBtn" type="submit">查询</button>
 <?php self::endForm() ?>
<ul class="query-result">
    <li class="flex-nowrap">
        <span>客户昵称</span>
        <span>商品</span>
        <span>手续费</span>
        <span>平仓时间</span>
    </li>
<?php foreach ($data as $order): ?>
    <li class="flex-nowrap">
        <span><?= $order->user->nickname ?></span>
        <span><?= $order->product->name ?></span>
        <span><?= $order->fee ?></span>
        <span><?= substr($order->updated_at, 0, 10) ?></span>
    </li>
    <?php endforeach ?>
</ul>
  