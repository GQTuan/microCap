$(function() {
    //滑动条改写价格
    (function(){
        var swiperWrapperLayer = $('.swiper-wrapper');
        for (var i = 0; i < 100; i++) {
            var money = 0 + i * 100;
            swiperWrapperLayer.append('<div class="swiper-slide"><div class="money">' + money + '</div></div><div class="swiper-slide"></div><div class="swiper-slide"></div><div class="swiper-slide"></div><div class="swiper-slide"></div>');
        }
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 32, //设置slider容器能够同时显示的slides数量(carousel模式)。
            centeredSlides: true, //设定为true时，活动块会居中，而不是默认状态下的居左。
            spaceBetween: 0, //slide之间的距离（单位px）。
            grabCursor: true, //设置为true时，鼠标覆盖Swiper时指针会变成手掌形状，拖动时指针会变成抓手形状
            observer: true,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next',
            initialSlide:5,
            onSlideChangeStart: function(swiper) {
                var i = swiper.activeIndex;
                var sum = 20 * i;
                var rate = $('#fallRate').val();
                var account = $('.orderAccount').data('account');
                $('.buyContent1 .orderProfit').html(rate * sum / 100);
                $('.orderDeposit').html('￥' + sum);
                $(".orderBuy").val(sum);
                //用户点击增加购买金额
                if (account >= sum) {
                    $('.buyContent1 .orderBalance').html('<a data-type="1"> <span>下单</span> </a>');
                } else {
                    $('.buyContent1 .orderBalance').html('<a data-type="0"> <span>余额不足<br>去充值</span> </a>');
                }
            }
        });
        $(document).ready(function() {
            swiper.onResize();
        });
    })()
});
