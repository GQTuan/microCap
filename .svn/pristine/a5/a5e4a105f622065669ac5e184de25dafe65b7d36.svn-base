<?php use frontend\models\Order; ?>
<?php use common\helpers\Date; ?>
<?php foreach ($data as $order): ?>
<div class="row salemain2 orderList" data-price="<?= $order->price ?>" data-name="<?= $order->product->table_name ?>" data-time="<?= Date::timeDiff($order->sell_time) ?>" data-state="<?= $order->order_state ?>">
    <div class="salename">
        <span <?php if ($order->rise_fall == Order::RISE): ?>class="bg_z"<?php endif ?>>
        <?php $profitClass = $order->profit >= 0 ? 'red' : 'green'; ?>
        <?= $order->riseFallValue ?></span><?= $order->product->name ?><em class="fr font_18 profitPrice" data-rise="<?= $order->rise_fall ?>"></em>
        <p class="font_12">
            <?php $stateClass = ' bg_dq'; $stateHtml = ''; $spanHtml = '已到期';
            if ($order->order_state == Order::ORDER_POSITION) { 
              $stateClass = ''; $stateHtml = '后结算';
              $spanHtml = Date::countDown($order->sell_time);
            } ?>
            <span class="salename-time spanHtml<?= $stateClass ?>"><?= $spanHtml ?></span><em class="stateHtml"><?= $stateHtml ?></em>
            <?php if ($order->order_state == Order::ORDER_POSITION) : ?>
            <span class="font_20 co_cd curArrow" style="padding-left:30px">
                <span class="curPrice" data-value="1"><?= $order->price ?></span>
                <img src="/images/arrow-top.png" style="width: 13px;vertical-align: top;">
            </span>
            <?php endif;?>
            <span class="fr"><?php if ($order->order_state == Order::ORDER_POSITION): ?>实时盈亏<?php else: ?>盈亏<?php endif ?></span>
        </p>
    </div>
    <ul class="sale_ul">
       <li>
            <span><?= $order->price ?></span>购买价格
       </li>
       <li>
            <span><?= $order->sell_price ?></span>到期价格
       </li>
       <li>
            <span><?= $order->deposit ?></span>购买金额
       </li>
       <li>
            <span class="<?= $profitClass ?> profitLoss" data-oprofit="<?= $order->one_profit ?>" data-fee="<?= $order->fee ?>" data-deposit="<?= $order->deposit ?>">
            <?php  
            if($order->profit > 0) {
              $profit = $order->profit;
              echo "<i class='font_20'>赚<i class='font_16' style='margin-left:4px'>$profit</i></i>";
            } else if ($order->profit < 0) {
              $profit = abs($order->profit);
              echo "<i class='font_20' style='color:green'>亏<i class='font_16' style='margin-left:4px'>$profit</i></i>";
            } else {
              $profit = 0;
              echo "<i class='font_20'>平<i class='font_16' style='margin-left:4px'>$profit</i></i>";
            }
             ?></span>
       </li>
    </ul> 
    <p class="sale_time">
    <span class="fl">下单时间：<?= $order->created_at ?></span><span class="fr">平仓时间：<?= $order->sell_time ?></span>
    </p>             
</div>
<?php endforeach ?> 