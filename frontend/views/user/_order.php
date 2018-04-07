     <?php foreach ($data as $order) :?>
        <ul class="put-detail show">
          <li>
            <p>
              <span>订单编号：<?= $order->trade_no ?></span>
              <span>￥<?= floatval($order->amount) ?></span>
            </p>

            <p>
              <span><?= $order->getChargeTypeValue($order->charge_state) ?>充值成功</span>
              <span><?= $order->created_at ?></span>
            </p>
          </li>
        </ul>
     <?php endforeach ?>  
  