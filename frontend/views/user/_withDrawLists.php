     <?php foreach ($data as $order) :?>
     <ul class="trans-detail">
        <li>
        <a href="<?= url(['user/orderDetail', 'id' => $order->id]) ?>">
          <p>
            <span>用户：<?= u()->nickname ?></span>
            <span class="up">￥<?= $order->amount ?></span>
          </p>
          <p>
            <span ><?= $order->getOpStateValue($order->op_state); ?></span>
            <span><?= $order->created_at ?></span>
          </p>
        </a>
        </li>
    </ul>
     <?php endforeach ?>  