<?php use frontend\models\Order; ?>
<style type="text/css">
    body{
        background: #fff;
    }
    .position-container .title.up {
        background: #f5f5f5;
    }
    .position-container .title a {
        background: #e4393c;
        color: #fff;
    }
    .position-list li:nth-child(2n + 1) {
        background: #f5f5f5;
    }
    .position-list li {
        height: 1.6rem;
        line-height: 1.6rem;
        background: #eee;
    }
    .position-list .name {
        color: #666;
    }
    .position-list .odds {
        color: #666;
    }
    .handles {
        color: #666;
    }
    .posi-btn {
        background: #e4393c;
        color: #fff;
    }
</style>
<div class="position-container">
<?php $profit =  $user->profit_account + $user->loss_account?>
    <p class="title clear-fl <?= $profit>=0?'up':'down' ?>">
        <span style="color:#666;">总盈亏:<span><?=  $profit ?></span>元</span>
        <a href="<?= url(['user/order']) ?>">交易记录</a>
    </p>
    <?php if(empty($orders)): ?>
        <div class="deta_more">没有更多了</div>
    <?php else: ?>
    <ul class="position-list">
        <li class="flex-nowrap">
            <span>产品</span>
            <span>盈亏</span>
            <span>建仓价</span>
            <span>手数</span>
            <span></span>
        </li>
        <?php foreach ($orders as $order) : ?>
                <li class="flex-nowrap list1" data-id="<?= $order->id ?>">
                    <span class="name"><?= $order->product->name ?></span>
                    <span class="up profit">计算中</span>
                    <span class="odds">
                        <span value="<?= $order->price ?>"><?= floatval($order->price) ?></span><br/>
                        <span class="<?php if ($order->rise_fall == Order::RISE) {echo 'up';$str = '多';} else {echo 'down';$str = '空';} ?>">(<?= $str ?>)</span>
                    </span>
                    <span class="handles"><?= $order->hand ?></span>
                    <span>
                        <a class="posi-btn" href="<?= url(['order/sellPosition', 'id' => $order->id]) ?>">平仓</a>
                    </span>
                </li>
        <?php endforeach ?>
    </ul>
    <?php endif ?>
</div>
<script type="text/javascript">
        $(function() {
            //持仓数据跳动
            function updateOrder(){
                $.post("<?= url('order/ajaxUpdateOrder')?>", function(msg) {
                    if (msg.state) { 
                        var obj = msg.info;
                        //对页面所有数据进行修改
                        $('.list1').each(function(){
                            //被系统平仓的订单消失
                            var order_id = Number($(this).data('id'));
                            // tes(order_id,idArr,$.inArray(order_id, idArr));return;
                            //判断此持仓id是否被系统平仓
                            if (obj[order_id] == undefined) {
                                $(this).remove();
                            }
                            var $this = $(this).find('.profit');
                            $this.html(obj[order_id]);
                            if (obj[order_id] > 0) {
                               $this.addClass('up'); 
                               $this.removeClass('down'); 
                            } else {
                               $this.removeClass('up'); 
                               $this.addClass('down'); 
                            }
                        });
                    }
                }, 'json');
            }
            setInterval(updateOrder, 1000);
    })
</script>