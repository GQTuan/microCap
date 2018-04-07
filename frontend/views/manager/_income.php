<?php foreach ($data as $userRebate): ?>
<!-- <div class="boxflex header list">
    <div class="name box_flex_1"><?= $userRebate->user->nickname ?>
    </div>
    <div class="phone box_flex_1"><?= $userRebate->order->product->name ?>
    </div>
    <div class="balance box_flex_1"><?= $userRebate->amount ?>
    </div>
    <div class="time box_flex_1"><?= $userRebate->created_at ?>
    </div>
</div> -->
    <li class="flex-nowrap">
        <span><?= $userRebate->user->nickname ?></span>
        <span><?= $userRebate->order->product->name ?></span>
        <span><?= $userRebate->amount ?></span>
        <span><?= substr($userRebate->created_at, 0, 10) ?></span>
    </li>
<?php endforeach ?>