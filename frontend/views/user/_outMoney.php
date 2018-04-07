<?php use frontend\models\UserWithdraw; ?>
<?php foreach ($data as $order): ?>
<div class="row salemain2 orderList">
    <div class="salename">
      
    </div>
    <ul class="sale_ul">
       <li>
            <span><?= $order->amount ?></span>出金金额
       </li>
       <li>
            <span><?= $order->getOpStateValue($order->op_state)?></span>状态
       </li>
       <li>
            <span><?= $order->created_at ?></span>操作时间
       </li>
    </ul> 
    <p class="sale_time">
    </p>             
</div>
<?php endforeach ?> 