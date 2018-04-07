    <?php $form = self::beginForm(['showLabel' => false]) ?>
    <div class="container">
         <div class="row">
           <div class="header">
             <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
             经纪人注册
           </div>
           
           <div class="chargemain">
             <div class="col-xs-12 charge">
                <ul>
                    <li> <?= $form->field($userExtend, 'mobile')->textInput(['placeholder' => '输入手机号']) ?></li>
                    <li> <?= $form->field($userExtend, 'realname')->textInput(['placeholder' => '输入真实姓名']) ?></li>
                    <li><?= $form->field($model, 'password')->passwordInput(['placeholder' => '输入交易密码']) ?></li>
                    <li> <?= $form->field($model, 'cfmPassword')->passwordInput(['placeholder' => '再次输入密码']) ?></li>
                    <li><?= $form->field($userExtend, 'coding')->textInput(['placeholder' => '输入所属代理商编码']) ?></li> 
                </ul>
            </div>           
             <div class="col-xs-12 charge">
               <ul>
                 <li>
                  <input type="text" placeholder="请输入验证码" name="User[verifyCode]">
                  <span class="yzm">获取验证码</span>
                 </li>
               </ul>
            </div>
             <div class="col-xs-12 pad_none"><a class="chargebtn">提交</a></div>
 
           </div>  
         </div>
        <?php self::endForm() ?>
    </div>
<script>
$(function () {
    $(".chargebtn").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    $.alert(msg.info);
                    window.location.href = '<?= url('user/index') ?>'
                }
            }
        }));
        return false;
    });
});
</script>