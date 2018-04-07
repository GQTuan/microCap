
  <div class="container">
     <div class="row">
       <div class="header">
         <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
         出金记录
       </div>
     </div>
     <div class="content">
     <?= $this->render('_outMoney',compact('data')) ?>
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
</script>