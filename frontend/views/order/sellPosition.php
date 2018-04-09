<style type="text/css">
    body{
        background: #fff;
    }
    .sell-title {
        background: #f5f5f5;
        border-bottom: 1px solid #ddd;
    }
    .sell-title span:last-child {
        color: #666;
    }
    .price-info {
        background: #f5f5f5;
    }
    .price-info>span {
        color: #666;
    }
    .price-info>span+span {
        border-left: 1px solid #ddd;
    }
    .sell-item {
        border-bottom: 1px solid #ddd;
        background: #f5f5f5;
    }
    .sell-item>span {
        color: #666;
    }
    .sell-btn {
        background: #e4393c;
    }
</style>
<div class="sell-container">
    <p class="sell-title">
        <span class="<?= $order->rise_fall==1?'up-icon':'down-icon'; ?>"><?= $order->rise_fall==1?'涨':'跌'; ?></span>
        <span><?= $order->product->name ?>(<?= $order->deposit / $order->hand ?>)</span>
    </p>
    <p class="flex-nowrap price-info">
        <span>持仓价 ： <span><?= $order->price ?></span></span>
        <span>行情价 ： <span class="price">计算中</span></span>
    </p>
    <p class="sell-item flex-nowrap">
        <span>订单号：</span>
        <span>JY1000<?= $order->id ?></span>
    </p>
    <p class="sell-item flex-nowrap hasmargin">
        <span>创建时间：</span>
        <span><?= $order->created_at ?></span>
    </p>
    <p class="sell-item flex-nowrap">
        <span>建仓金额：</span>
        <span><?= $order->deposit ?></span>
    </p>
    <p class="sell-item flex-nowrap hasmargin">
        <span>波动：</span>
        <span><?= $order->product->id == 7 ?$order->one_profit / 100 : $order->one_profit ?>元/点</span>
    </p>

    <p class="sell-item flex-nowrap">
        <span>手续费：</span>
        <span><?= $order->fee ?></span>
    </p>
    <p class="sell-item flex-nowrap">
        <span>盈亏金额：</span>
        <span class="profit">计算中</span>
    </p>
    <p class="sell-item flex-nowrap">
        <span>本单盈亏：</span>
        <span class="profitRate">计算中</span>
    </p>
    <a class="sell-btn">我要平仓</a>
    <p class="footer-tip">如该订单在结算时间(凌晨4:00)前未平仓，将会被强行被平仓。</p>
</div>
<script type="text/javascript">
    $(function() {
        //确认平仓
        $('.sell-btn').click(function() {
            $.post("<?= url(['order/ajaxSellOrder'])?>", {id: '<?= $order->id ?>'}, function(msg) {
                if (msg.state == 1) {
                    window.location.href = '<?= url(['order/position']) ?>';
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });

        //持仓数据跳动
        function updateOrder(){
            $.post("<?= url(['order/ajaxUpdateOrderOne'])?>", {id: '<?= $order->id ?>'}, function(msg) {
                if (msg.state) { 
                    var obj = msg.info;
                    $('.price').html(obj['price']);
                    if (obj['profit'] >= 0) {
                       $('.profit').css('color', 'red');
                       $('.profitRate').css('color', 'red');
                       $('.deposit').css('color', 'red');
                       $('.price').css('color', 'red');
                    } else {
                       $('.profit').css('color', 'green');
                       $('.profitRate').css('color', 'green');
                       $('.deposit').css('color', 'green');
                       $('.price').css('color', 'green');
                    }
                    $('.profit').html('￥' + obj['profit']);
                    $('.profitRate').html(parseFloat(obj['profit'] )+parseFloat(<?= $order->deposit ?>));
                    $('.deposit').html('￥' + obj['deposit']);
                }
            }, 'json');
        }
        setInterval(updateOrder, 1000);
    })
</script>