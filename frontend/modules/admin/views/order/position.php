<?php use common\helpers\Html; ?>
<div class="orderContent">
<?= $html ?>

<p class="cl pd-5 mt-20">
    <span>当前持仓盈亏统计：<span class="curProfit"><?= $profit >= 0 ? Html::redSpan($profit, ['class' => 'countProfit']) : Html::greenSpan($profit, ['class' => 'countProfit']) ?></span>，</span>
    <span>当前持仓交易手数：<span class="curHand"><?= $hand >= 0 ? Html::redSpan($hand, ['class' => 'countHand']) : Html::greenSpan($hand, ['class' => 'countHand']) ?></span>，</span>
    <span>当前持仓交易额统计：<span class="curAmount"><?= $amount >= 0 ? Html::redSpan($amount, ['class' => 'countAmount']) : Html::greenSpan($amount, ['class' => 'countAmount']) ?></span>，</span>
    <span>当前持仓手续费统计：<span class="curFee"><?= $fee >= 0 ? Html::redSpan($fee, ['class' => 'countFee']) : Html::greenSpan($fee, ['class' => 'countFee']) ?></span></span>
</p>
</div>
<script>
$(function () {
    $(".list-container").on('click', '.sellOrderBtn', function () {
        var $this = $(this);
        $.post($this.attr('href'), function (msg) {
            $.alert(msg.info, function () {
                $this.parents('td').html($("<span>").html(msg.info).css('color', 'red'));
            });
        });
        return false;
    });
    $(".list-container").on('click', '.signBtn', function () {
        var $this = $(this);
        $.prompt('请输入修改的标记内容(盈、亏、取消)', function (value) {
            $.post($this.attr('href'), {sign: value}, function (msg) {
                if (msg.state) {
                    $.alert(msg.info || '修改成功', function () {
                        location.replace(location.href);
                    });
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });
        return false;
    });

    $(".orderExcel").on('click', function () {
        var str = '';
        $('.search-form ul>li').each(function(){
            var $this = $(this).find('.input-text');
            if ($this.attr('name') != undefined) {
                var value = $this.val();
                if (value.length > 0) {
                    // var arr = $this.attr('name').split('['),               
                    //     arr = arr[1].split(']');               
                    // str += arr[0] + '=' + value + '&';             
                    str += $this.attr('name') + '=' + value + '&';
                }
            }
        });
        var url = "<?= url(['order/orderExcel']) . '?admin.id=&' ?>" + str;
        window.location.href = url;
    });

    //持仓数据跳动
    function updateOrder(){
        var str = '';
        $('.search-form ul>li').each(function(){
            var $this = $(this).find('.input-text');
            if ($this.attr('name') != undefined) {
                var value = $this.val();
                if (value.length > 0) {           
                    str += $this.attr('name') + '=' + value + '&';
                }
            }
        });
        var url = "<?= url(['order/ajaxPosition']) . '?admin.id=&' ?>" + str;
        $.post(url, function(msg) {
            if (msg.state) { 
                // $('.orderContent').html(msg.info);
                $('.list-container .list-view').html(msg.info);
                var data = msg.data;
                $('.curProfit').html(data['countProfit']);
                $('.curHand').html(data['countHand']);
                $('.curAmount').html(data['countAmount']);
                $('.curFee').html(data['countFee']);
            }
        }, 'json');
    }
    setInterval(updateOrder, 3000);  
});
</script>
