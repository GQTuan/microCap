<div class="order-container">
  <div class="my-btn-group">
    <p class="flex-nowrap">
      <a data-url="put-detail" href="<?= url(['user/order']) ?>">收支明细</a>
      <a href="<?= url(['user/transDetail']) ?>" class="active">交易明细</a>
    </p>
  </div>
    <div class="content">
     <?= $this->render('_transDetail',compact('data')) ?>
    </div>
    <?php if ($pageCount < 2): ?>
        <div class="deta_more" id="deta_more_div">没有更多了</div>
    <?php else: ?>
        <div class="addMany" style="text-align: center;">
            <a style="" type="button" value="加载更多" id="loadMore" data-count="<?= $pageCount ?>" data-page="1">加载更多</a>
        </div>
    <?php endif ?>
</div>
<script type="text/javascript">
$(".addMany").on('click', '#loadMore', function() {
    var $this = $(this),
        page = parseInt($this.data('page')) + 1;
        
    $.get('', {p:page}, function(msg) {
        $(".content").append(msg.info);
        $this.data('page', page);
        if (page >= parseInt($this.data('count'))) {
            $('.addMany').hide();
        }
    });
});
    // $(function() {
    //     //确认平仓
    //     $('.sellOrder').click(function() {
    //         $.post("", {id: }, function(msg) {
    //             if (msg.state == 1) {
    //                 $.alert(msg.info);
    //                 window.location.href = '<?= url('order/position') ?>';
    //             } else {
    //                 $.alert(msg.info);
    //             }
    //         }, 'json');
    //     });

    //     //持仓数据跳动
    //     function updateOrder(){
    //         $.post("<?= url('order/ajaxUpdateOrderOne')?>", {id: }, function(msg) {
    //             if (msg.state) { 
    //                 var obj = msg.info;
    //                 $('.price').html(obj['price']);
    //                 if (obj['profit'] >= 0) {
    //                    $('.profit').css('color', 'red');
    //                    $('.profitRate').css('color', 'red');
    //                    $('.deposit').css('color', 'red');
    //                 } else {
    //                    $('.profit').css('color', 'green');
    //                    $('.profitRate').css('color', 'green');
    //                    $('.deposit').css('color', 'green');
    //                 }
    //                 $('.profit').html('￥' + obj['profit']);
    //                 $('.profitRate').html(obj['profitRate'] + '%');
    //                 $('.deposit').html('￥' + obj['deposit']);
    //             }
    //         }, 'json');
    //     }
    //     setInterval(updateOrder, 1000);
    // })

</script>