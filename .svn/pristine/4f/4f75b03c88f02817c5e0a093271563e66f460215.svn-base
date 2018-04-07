<?php use frontend\models\UserCharge; ?>
<?php foreach ($data as $order): ?>
<div class="row salemain2 orderList">
    <div class="salename">
      
    </div>
    <ul class="sale_ul">
       <li>
            <span><?= $order->amount ?></span>充值金额
       </li>
       <li>
            <span><?= $order->getChargeTypeValue($order->charge_type)?></span>充值方式
       </li>
       <li>
            <span><?= $order->getChargeStateValue($order->charge_state)?></span>充值状态
       </li>
       <li>
            <span><?= $order->created_at ?></span>充值时间
       </li>
    </ul> 
    <p class="sale_time">
    <span class="fl">订单号：<?= $order->trade_no ?></span>
    </p>             
</div>
<?php endforeach ?> 