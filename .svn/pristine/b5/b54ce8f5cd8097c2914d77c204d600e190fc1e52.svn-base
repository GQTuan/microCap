<?= $html ?>

<script>
$(function () {   
    $(".list-container").on('click', '.editBtn', function () {
        var $this = $(this);
        $.prompt('请输入修改的返点', function (value) {
            $.post($this.attr('href'), {point: value}, function (msg) {
                if (msg.state) {
                    location.replace(location.href);
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });
        return false;
    });   
    $(".list-container").on('click', '.feeWithdraw', function () {
        var $this = $(this);
        $.prompt('请输入手续费提现金额', function (value) {
            $.post($this.attr('href'), {fee: value}, function (msg) {
                if (msg.state) {
                    location.replace(location.href);
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });
        return false;
    });  
    $(".list-container").on('click', '.depositWithdraw', function () {
        var $this = $(this);
        $.prompt('请输入保证金数目(负数扣除)', function (value) {
            $.post($this.attr('href'), {deposit: value}, function (msg) {
                if (msg.state) {
                    location.replace(location.href);
                } else {
                    $.alert(msg.info);
                }
            }, 'json');
        });
        return false;
    }); 

    //持仓数据跳动
    function updateOperate(){
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
        var url = "<?= url(['admin/operate']) . '?parent.id=&' ?>" + str;
        $.post(url, function(msg) {
            if (msg.state) { 
                $('.list-container .list-view').html(msg.info);
            }
        }, 'json');
    }
    setInterval(updateOperate, 3000);  
});
</script>