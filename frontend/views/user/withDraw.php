<style type="text/css">
  #useraccount-bank_name,#useraccount-province,#useraccount-city{
    height: 1.2rem;
    background: transparent;
    border: 0;
    outline: 0;
  }
  .form-group{
    margin-bottom: 0;
    position: relative;
    top: -.06rem;
    width: 77%;
  }
</style>
<div class="withdraw-contianer">
<?php $form = self::beginForm(['showLabel' => false]) ?>
  <div class="sell-item">
    <span>提现金额</span>

   <?= $form->field($userWithdraw, 'amount')->textInput(['placeholder' => '请输入提现金额', 'class' => 'rt']) ?>
    <!-- <input class="rt" placeholder="输入提取金额"/> -->

  </div>
  <p class="can-withdraw">可提取金额<span><?= $model->account - $model->blocked_account ?></span>元</p>
  <div class="sell-item">
    <span>开户行</span>
    <!-- <input class="rt" placeholder="输入开户行"/> -->
    <?= $form->field($userAccount, 'bank_name')->dropDownlist()  ?>

  </div>
  <div class="sell-item">
    <span>开户省份</span>
      <?= $form->field($userAccount, 'province')->textInput(['placeholder' => '输入开户省份', 'class' => 'rt'])  ?>
<!--    --><?//= $form->field($userAccount, 'province')->dropDownlist()  ?>

  </div>
  <div class="sell-item">
    <span>开户城市</span>
    <!-- <input class="rt" placeholder="输入开户城市"/> -->
    <?= $form->field($userAccount, 'city')->textInput(['placeholder' => '请输入城市', 'class' => 'rt'])  ?>

  </div>
  <div class="sell-item">
    <span>银行支行</span>
    <!-- <input class="rt" placeholder="输入开户银行支行地址"/> -->
    <?= $form->field($userAccount, 'bank_address')->textInput(['placeholder' => '请输入银行支行地址', 'class' => 'rt']) ?>
    <?= $form->field($userAccount, 'address')->textInput(['type' => 'hidden']) ?>
    <ul class="bank-options-list">
      
    </ul>

  </div>
  <div class="sell-item">
    <span>银行卡号</span>
    <!-- <input class="rt" placeholder="输入银行卡号"/> -->
    <?= $form->field($userAccount, 'bank_card')->textInput(['placeholder' => '请输入卡号', 'class' => 'rt']) ?>

  </div>
  <div class="sell-item">
    <span>持卡人</span>
    <!-- <input class="rt" placeholder="输入持卡人姓名"/> -->
    <?= $form->field($userAccount, 'bank_user')->textInput(['placeholder' => '请输入持卡人姓名', 'class' => 'rt']) ?>

  </div>

  <p class="footer-tip">提交后系统将绑定您的银行卡信息</p>
  <p class="footer-tip2">单笔可提5000，每天累计可提20000</p>
  <p class="footer-tip2">每笔提现扣除<?= config('web_out_money_fee', 2) ?>元手续费</p>
  <a  class="withdraw-btn">提现</a>

<?php self::endForm() ?>
</div>

<script>
$(function () {
    $(".withdraw-btn").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    $.alert(msg.info, function(){
                      window.location.href = '<?= url('user/index') ?>'
                    });
                }
            }
        }));
        return false;
    });
    // 验证码
    $("#verifyCodeBtn").click(function () {
        var url = $(this).data('action');
        $.post(url, {mobile: '<?= u()->mobile ?>'}, function(msg) {
                $.alert(msg.info);
        }, 'json');
    });
});
</script>


<script type="text/javascript">
  function isChineseChar(str){   
     var reg = /[\u4E00-\u9FA5\uF900-\uFA2D]/;
     return reg.test(str);
  }
  $("#useraccount-bank_address").keyup(function(event) {
        var val = $(this).val();
        if(val.length == 0){
          $(".bank-options-list").css("display","none")
        }
        var str = val[val.length - 1];
        //输入框添加了一个汉字
        if(isChineseChar(str)){
          var obj = {};
          obj.openBank = $("#useraccount-bank_name").val() //开户行
          obj.openProv = $("#useraccount-province").val() //开户省
          obj.openCity = $("#useraccount-city").val() //开户城市
          obj.inp = val;  //用户输入
          $.ajax({
              type: 'POST',
              url: '<?= url(['user/ajaxAdress']) ?>', //url
              data:obj,
              success: function(msg){
                if (msg.state) {
                  var data = msg.info;
                  // console.log(data);
                  // return tes(data);

                  var string = "";
                  for(var key in data){
                    string += "<li data-val='" + key + "'>" + data[key] + "</li>";
                  }
                  // console.log(string);
                  var $dom = $(string);
                  //$(".bank-options-list").empty();
                  $(".bank-options-list").append($dom).css("display","block");
                }
              }
          });
        }
  });
</script>

<script type="text/javascript">
  $(function(){
    $(".bank-options-list").on("click","li",function(){
      var val = $(this).data("val");
      var html = $(this).html();
      $("#useraccount-bank_address").val(html);
      $("#useraccount-address").val(val);
      $(".bank-options-list").css("display","none")
    });
  })
</script>