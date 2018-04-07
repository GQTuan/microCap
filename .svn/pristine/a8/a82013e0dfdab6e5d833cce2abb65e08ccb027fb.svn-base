$(function() {
    //产品单位的切换
    $('.selectUnit').on('change', 'select', function() {
        var price = parseInt($('.orderBuy').val());
        $.post("/site/ajax-product-unit", {id: $(this).val()}, function(msg) {
            if (msg.state) {
                //赋值涨跌参数
                var data = msg.info,
                    rate = (parseFloat(data) + 100),
                    price = parseInt($('.orderBuy').val()),
                    html = '回报率：' + rate + '%';
                $('.riseRate').html(html);
                $('.fallRate').html(html);
                $('#fallRate').val(rate);
                $('.buyContent1 .orderProfit').html(rate * price / 100);

            } else {
                $.alert(msg.info);
            }
        }, 'json');
    });

    //空白删除transaction1
    $(".myContent").on("click", '.removeClass', function() {
        $('.myContent').html('');
    });

    //取消按钮
    $(".myContent").on("click", '.cancel', function() {
        $('.myContent').html('');
    });

    //设置交易密码
    $(".myContent").on("click", '.setPassWord', function() {
        $.post("/site/ajax-set-password", {data: $('#password').val()}, function(msg) {
            if (msg.state) {
                $('.myContent').html('');
            } else {
                $.alert(msg.info);
            }
        }, 'json');
    });

    //全局控制用户跳转链接是否设置了交易密码
    $(".overallPsd").on("click", function() {
        var url = $(this).data('url');
        $.post("/site/ajax-overall-psd", {url:url}, function(msg) {
            
            if (msg.state) {
                window.location.href = msg.info;
            } else {
                $('.myContent').append(msg.info);
            }
        }, 'json');
    });

    //全局控制用户跳转链接是否设置了交易密码_关闭窗口
    $(".myContent").on("click", '.box-close', function() {
        $('.myContent').html('');
    });

});
