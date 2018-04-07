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
            <span><?php if($order->charge_type == 1) {echo '支付宝';} else{echo '微信';} ?></span>充值方式
       </li>
       <li>
            <span><?php if($order->charge_state == 2) {echo '成功';}; ?></span>充值状态
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