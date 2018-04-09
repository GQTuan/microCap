<?php use frontend\models\User; ?>
<?php $this->regCss('manager.css') ?>
<style type="text/css">
    footer .flex-nowrap li{
        padding: 0;
    }
    body{
        background: #fff;
    }
    .header {
        color: #666;
    }
    #chartBox li {
        border: 1px solid #ddd;
        font-size: 12px;
    }
    .charge ul li {
        background: #fff;
    }
    .charge ul li input {
        color: #333;
    }
    .disabled {
        background-color: #999;
    }
    .charge .yzm {
        background: #e4393c;
    }
</style>
<?php $form = self::beginForm(['showLabel' => false]) ?>
<div class="container">
     <div class="row">
       <div class="header">
         <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
         经纪人注册
       </div>
       
       <div id="chartBox" class="chargemain">
         <div class="col-xs-12 charge">
            <ul>
                <li> <?= $form->field($userExtend, 'mobile')->textInput(['placeholder' => '输入手机号', 'class' => 'regTel']) ?></li>
                <!-- <li> <?= $form->field($userExtend, 'realname')->textInput(['placeholder' => '输入真实姓名']) ?></li> -->
                <li><?= $form->field($user, 'oldPassword')->passwordInput(['placeholder' => '输入交易密码']) ?></li>
                <li> <?= $form->field($user, 'cfmPassword')->passwordInput(['placeholder' => '再次输入密码']) ?></li>
                <li><?= $form->field($userExtend, 'coding')->textInput(['placeholder' => '输入所属代理商编码']) ?></li> 
            </ul>
        </div>           
         <div class="col-xs-12 charge">
           <ul>
             <li>
              <?= $form->field($user, 'verifyCode')->textInput(['placeholder' => '请输入手机验证码', 'class' => 'box_flex_1 register-code regCode'])  ?>
              <span class="yzm" id="verifyCodeBtn" data-action="<?= url(['site/verifyCode']) ?>">获取验证码</span>
             </li>
           </ul>
        </div>
         <div class="col-xs-12 "><a class="chargebtn disabled" id="submitBtn">提交</a></div>

       </div>  
     </div>
</div>
<?php self::endForm() ?>

<!-- 遮罩层开始 -->
<?php if (u()->apply_state == User::APPLY_STATE_WAIT): ?>
<div class="transmask">
    <div class="infotips">你的信息已提交,正在审核<br/>请耐心等待审核</div>
</div>
<?php endif ?>
<!-- 遮罩层结束 -->
<script>
$(function () {
    var $inputs = $('.regCode');
    $inputs.keyup(function() {
        if ($inputs.val().length > 3) {
            $('#submitBtn').removeClass('disabled');
        } else {
            $('#submitBtn').addClass('disabled');
        }
    });
    //倒计时
    var wait = 60;
    function time(obj) {
        if (wait == 0) {
            obj.removeClass('disabled');           
            obj.html('重新获取验证码');
            wait = 60;
        } else {
            obj.addClass('disabled');
            obj.html('重新发送(' + wait + ')');
            wait--;
            setTimeout(function() {
                time(obj);
            },
            1000)
        }
    }
    //提交
    $("#submitBtn").click(function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                } else {
                    window.location.href = msg.info;
                }
            }
        }));
        return false;
    });
    // 验证码
    $("#verifyCodeBtn").click(function () {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        var mobile = $('.regTel').val();
        var url = $(this).data('action');
        if (mobile.length != 11) {
            $.alert('您输入的不是一个手机号！');
            return false;
        }
        $.post(url, {mobile: mobile}, function(msg) {
                if (msg.state) {
                    time($('#verifyCodeBtn'));
                } else {
                    $.alert(msg.info);
                }
        }, 'json');
    });
});
</script>