<?php use common\helpers\Html; ?>

<?= $html ?>
<script>
    $(".list-container").on('click', '.sellOrderBtn', function () {
        var $this = $(this);
        $.post($this.attr('href'), function (msg) {
            $.alert(msg.info, function () {
                $this.parents('td').html($("<span>").html(msg.info).css('color', 'red'));
            });
        });
        return false;
    });
    $(".list-container").on('click', '.sellOrder', function () {
        var $this = $(this);
        $.prompt('请输入平仓价格', function (value) {
            $.post($this.attr('href'), {price: value}, function (msg) {
                if (msg.state) {
                    location.replace(location.href);
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });
        return false;
    });
</script>

