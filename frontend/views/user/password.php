<style type="text/css">
  .chargemain.tx:after{
    content:"";
    display: block;
    clear:both;
  }
  .chargemain.tx{
    background: #292D36;
    width:100%;
    margin:0;
  }
  .col-xs-12.charge.psd{
    padding:30px;
    padding-top:10px;
  }
  .col-xs-12.charge.psd li{
    background: #292D36;
    height: 40px;
    line-height: 40px;
    border:1px solid #53585E;
    border-radius:6px;
    margin-top:20px;
    box-sizing:border-box;
    padding-left:10px;
  }
  .col-xs-12.charge.psd li font{
    line-height: 20px;
    font-size:15px;
    color:#fff;
    position: relative;
    top: -3px;
    border-right:1px solid #1E2327;
  }
  .col-xs-12.charge.psd li input{
    position: relative;
    top: -3px;
  }
  .col-xs-12.pad_none{
    margin-top:50px;
    padding:0 30px;
  }
</style>
    <?php $form = self::beginForm(['showLabel' => false]) ?>
      <div class="container">
          <div class="row">
               <div class="header">
                  <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
                  修改交易密码
               </div>
             
              <div class="chargemain tx"> 
                    <div class="col-xs-12 charge psd">
                       <ul>
                       <li><font>当前密码</font> <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder' => '请输入原交易密码'])?></li>
                          <li><font>新密码</font> <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => '请输入6位新密码'])?></li>
                          <li><font>确认密码</font> <?= $form->field($model, 'cfmPassword')->passwordInput(['placeholder' => '请再次输入交易密码'])?></li>
                       </ul>
                    </div>
                  
              </div> 
             <div class="col-xs-12 pad_none"><a class="chargebtn">确认</a></div>
          </div>
      </div>
    <?php self::endForm() ?>
<script>
$(function () {
    $(".chargebtn").click(function () {  
     
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    $.alert(msg.info);
                    window.location.href = '<?= url(['user/index']) ?>'
                }
            }
        }));
        return false;
    });
});
</script>