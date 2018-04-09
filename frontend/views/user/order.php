<style type="text/css">
  body{
    background: #fff;
  }
  .my-btn-group {
    background: #f5f5f5;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}
.my-btn-group p {
    border: 1px solid #e4393c;
}
.my-btn-group a.active {
    background: #e4393c;
    color: #fff;
}
.my-btn-group a {
    color: #e4393c;
}
.put-detail li p, .trans-detail li p {
    border: 1px solid #ddd;
    background: #f5f5f5;
}
.trans-detail li p:nth-child(1) {
    height: 1.3rem;
    line-height: 1.3rem;
    padding: 0 .7rem;
    font-size: .46rem;
    color: #666;
}
.trans-detail li p:nth-child(2) {
    height: 1.2rem;
    line-height: 1.2rem;
    padding: 0 .7rem;
    font-size: .38rem;
    color: #333;
}
</style>
<div class="order-container">
  <div class="my-btn-group">
    <p class="flex-nowrap">
      <a class="active" data-url="put-detail" href="">收支明细</a>
      <a data-url="" href="<?= url(['user/transDetail']) ?>">交易明细</a>
    </p>
  </div>
    <div class="content">
     <?= $this->render('_order',compact('data')) ?>
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
  $(".my-btn-group").on("click","a",function(e){
    //e.preventDefault();
    $(this).addClass('active').siblings('.active').removeClass("active");

    var $url = $(this).data("url");
    $(".show").removeClass("show").addClass('hide')
    $("." + $url).removeClass("hide").addClass("show");
  });
</script>