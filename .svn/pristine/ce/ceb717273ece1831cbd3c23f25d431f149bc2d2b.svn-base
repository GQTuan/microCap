    <div class="transaction transaction1 orderContent">
        <div class="removeClass">
        </div>
        <div id="createorderbox">
            <div class="createorder-content">
                <div class="createchoose-wrap" <?= $class ?>>建仓看<?= $string ?></div>
                <div class="key-value boxflex">
                    <div id="definecashnum" class="box_flex_1"></div>
                </div>
                <div class="key-value boxflex">
                    <label class="key">合约定金:</label>
                    <div class="box_flex_1" id="setting-point">
                        <ul class="table deposit">
                        <?php $i=1;foreach ($productPrice as $product): ?>
                            <li <?php if ($i==1): ?>class="active"<?php endif ?> data-id="<?= $product['id']?>"><?= floatval($product['deposit']) ?></li>
                        <?php $i++;endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="key-value boxflex">
                    <label class="key">数量:</label>
                    <div class="box_flex_1 num-wrap">
                        <span class="btn-coin btn-minute" data-value="-1">-</span>
                        <input type="tel" value="1" onpaste="return false" data-max="<?= $product['max_hand'] ?>" oncontextmenu="return false" oncopy="return false" oncut="return false" class="hand">
                        <span class="btn-coin btn-add" data-value="1">+</span>
                    </div>
                </div>
                <div class="key-value boxflex">
                    <label class="key">止盈/止损点:</label>
                    <div class="box_flex_1" id="setting-point">
                        <ul class="table point">
                        <?php $i=1;foreach ($productPrice as $product): ?>
                            <li <?php if ($i==1): ?>class="active"<?php endif ?> data-id="<?= $product['id']?>"><?= floatval($product['one_profit']) ?></li>
                        <?php $i++;endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="sure-btn-wrap">
                    <div class="table">
                        <div class="table-cell cancel" id="close">
                            <label>取消</label>
                        </div>
                        <div class="table-cell determine payOrder" data-type="<?= $data['type'] ?>">
                            <label <?= $class ?>>确定</label>
                        </div>
                    </div>
                    <p class="ptipstorage">收盘时对于未成交订单将自动平仓，合约定金全额返还</p>
                    <p>交易时间：周一~周五9:00~1:00 每日4:30~7:00休市结算</p>
                </div>
            </div>
        </div>
    </div>