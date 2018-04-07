<style type="text/css">
    body{
        padding-bottom: 4rem;
    }
</style>

<div class="recharge-container">
    <div class="rec-header">
        <p class="account-balance">账户余额</p>
        <p class="balance-num"><?= u()->account - u()->blocked_account ?></p>
        <p class="choice-title">选择充值金额</p>
        <?php $form = self::beginForm(['showLabel' => false, 'action' => url(['user/pay']), 'id' => 'payform']) ?>
        <div class="clear-fl options-container">
            <div>
                <a class="active">50</a>
            </div>
            <div>
                <a>100</a>
            </div>
            <div>
                <a>300</a>
            </div>
            <div>
                <a>500</a>
            </div>
            <div>
                <a>1000</a>
            </div>
            <div>
                <a>2000</a>
            </div>
            <div>
                <a>3000</a>
            </div>
            <div>
                <a>4000</a>
            </div>
            <div>
                <a>5000</a>
            </div>
            
        </div>
        <p class="choice-title">其他金额</p>
        <input class="custom-count" placeholder="请输入其他金额" />
        <input type="hidden" id="amount" name="amount" value="50">
        <input type="hidden" id="type" name="type" value="2">
        <p class="choice-title">选择支付方式</p>
        <p class="pay-methold-btn flex-nowrap payType">
            <a class="active" href="" data-type='2'>微信支付</a>
            <a href="" data-type='3'>支付宝支付</a>
            <a href="" data-type='4'>银联支付</a>
        </p>
        <a class="submit">立即充值</a>
        <?php self::endForm() ?>
    </div>
</div>

<script type="text/javascript">
    $('#type').val(2);
    $('#amount').val('50');
    $(".options-container").on("click","a",function(e){
        e.preventDefault();
        //$(this).addClass("active").siblings(".active").removeClass("active");
        $("a.active" , $(".options-container")).removeClass('active');
        $(this).addClass("active");
        $(".custom-count").val($('.options-container .active').html());
        $('#amount').val($('.options-container .active').html());
    });
    $(".custom-count").blur(function(){
        $('#amount').val($(this).val());
    });
    $(".payType").on("click","a",function(e){
        e.preventDefault();
        $(this).addClass("active").siblings(".active").removeClass("active");
        $('#type').val($('.payType .active').data('type'));
    });

    $('.submit').on('click', function(){
        var amount = $('#amount').val();
        if(amount < 50 && $('#type').val() == 4) {
            $.alert('银联充值最低50元起');
            return;
        }
        if(!amount || isNaN(amount) || amount <= 0){
            $.alert('金额输入不合法!');
            return false;
        }
        $("#payform").submit();
    });
</script>