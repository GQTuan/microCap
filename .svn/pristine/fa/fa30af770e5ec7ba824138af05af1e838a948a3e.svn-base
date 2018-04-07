<?php use common\helpers\Html; ?>

<?= $html ?>

<p class="cl pd-5 mt-20">
    <span>当前持仓盈亏统计：<span class="curProfit"><?= $profit >= 0 ? Html::redSpan($profit, ['class' => 'countProfit']) : Html::greenSpan($profit, ['class' => 'countProfit']) ?></span>，</span>
    <span>当前持仓交易手数：<span class="curHand"><?= $hand >= 0 ? Html::redSpan($hand, ['class' => 'countHand']) : Html::greenSpan($hand, ['class' => 'countHand']) ?></span>，</span>
    <span>当前持仓交易额统计：<span class="curAmount"><?= $amount >= 0 ? Html::redSpan($amount, ['class' => 'countAmount']) : Html::greenSpan($amount, ['class' => 'countAmount']) ?></span>，</span>
    <span>当前持仓手续费统计：<span class="curFee"><?= $fee >= 0 ? Html::redSpan($fee, ['class' => 'countFee']) : Html::greenSpan($fee, ['class' => 'countFee']) ?></span></span>
</p>
