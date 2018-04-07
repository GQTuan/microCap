<div class="order-detail-container">
  <p class="title">
    <span class="<?= $class ?>"><?= $str ?></span>
    <span><?= $order->product->name ?></span>
  </p>

  <p class="sell-item flex-nowrap hasmargin">
    <span>持仓价：<?= $order->price ?></span>
  </p>

  <p class="sell-item flex-nowrap">
        <span>订单号：</span>
        <span>JY1000<?= $order->id ?></span>
    </p>
    <p class="sell-item flex-nowrap hasmargin">
        <span>创建时间：</span>
        <span><?= $order->updated_at ?></span>
    </p>

    <p class="sell-item flex-nowrap hasmargin">
        <span>建仓金额：</span>
        <span><?= $order->deposit ?></span>
    </p>

    <p class="sell-item flex-nowrap">
        <span>手续费：</span>
        <span><?= $order->fee ?></span>
    </p>
    <p class="sell-item flex-nowrap">
      <span>盈亏金额：</span>
      <span class="<?= $order->profit>=0?'up':'down' ?>"><?= $order->profit ?></span>
    </p>
</div>