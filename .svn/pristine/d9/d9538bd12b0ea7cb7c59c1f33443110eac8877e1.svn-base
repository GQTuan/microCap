     <?php use frontend\models\Order; ?>     
     <?php foreach ($data as $order) :?>
     <ul class="trans-detail">
        <li>
        <a href="<?= url(['user/orderDetail', 'id' => $order->id]) ?>">
          <p>
            <span>建仓看<?= $order->rise_fall == 1?'涨':'跌'; ?>(<?= $order->product->name ?>&nbsp;&nbsp;&nbsp;<?= $order->hand ?>手)</span>
            <span class="<?= $order->profit>=0?'up':'down' ?>"><?= $order->profit ?></span>
          </p>
          <p>
            <span >建仓价：<?= $order->price ?></span>
            <span><?= $order->updated_at ?></span>
          </p>
        </a>
        </li>
    </ul>
     <?php endforeach ?>  