<style type="text/css">
    body{
        background: #fff;
    }
</style>
<div class="order-container">

    <div class="content">
     <?= $this->render('_withDrawLists',compact('data')) ?>
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