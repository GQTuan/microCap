<?= $this->regJs('awardRotate') ?>
<?= $this->regCss('lottery-record') ?>
<?php common\components\View::regCss('layer.css') ?>
</head>
<body>

<!-- lottery -start -->
<div class="lottery-container">
    <p class="my-jilu"><a>我的抽奖记录</a></p>
    <ul class="lottery-list">
        <li class="flex-nowrap">
            <span>中奖时间</span>
            <span>奖品名称</span>
            <span>状态</span>
        </li>
        <?= $this->render('_lotteryRecord', compact('data')) ?>
    </ul>
    <?php if ($pageCount < 2): ?>
        <div class="deta_more" id="deta_more_div">没有更多了</div>
    <?php else: ?>
        <div class="addMany" style="text-align: center;position: absolute;width:100%;bottom:.2rem;">
            <a style="" type="button" value="加载更多" id="loadMore" data-count="<?= $pageCount ?>" data-page="1">加载更多</a>
        </div>
    <?php endif ?>
</div>
<!-- lottery-end -->


<script type="text/javascript">
$(".addMany").on('click', '#loadMore', function() {
    var $this = $(this),
        page = parseInt($this.data('page')) + 1;

    $.get('', {p:page}, function(msg) {
        $(".lottery-list").append(msg.info);
        $this.data('page', page);
        if (page >= parseInt($this.data('count'))) {
            $('.addMany').hide();
        }
    });
});
</script>

<script type="text/javascript">
    $(".detail-btn").click(function(){
        $(".my-modal").css("display","block");
    });
    $(".close-btn").click(function(){
        $(".my-modal").css("display","none");
    });
</script>
