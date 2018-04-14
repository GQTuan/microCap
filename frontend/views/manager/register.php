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
    .header i {
        color: #666;
    }
    .notice_con{
        padding: 0 14px;
        text-align: justify;
    }
    .notice_con h1{
        font-size: 16px;
        color: #666;
    }
    .notice_con p{
        font-size: 14px;
        color: #666;
        line-height: 24px;
    }
</style>
<?php $form = self::beginForm(['showLabel' => false]) ?>
<div class="container" style="padding-bottom: 60px;">
     <div class="row">
       <div class="header">
         <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
         风险须知
       </div>


       <div class="notice_con">
            <h1>风险提示</h1>
            <p>
                致广大投资者：
                收益与风险共存，没有只涨不跌的市场！没有稳赚不赔的投资！大宗商品现货交易业务是一种潜在收益和潜在风险较高的投资业务,对投资者的风险承受能力、理解风险的程度、风险控制能力以及投资经验有较高的要求。在您成为上恒指数的交易商之时，我们郑重地提醒您，请综合考虑自身情况，理性管理您的个人财富，注意以下风险：
                一、温馨提示
                1、大宗商品现货交易业务具有高投机性和高风险性，不适合用个人全部资产、养老基金、医疗资金、子女教育资金、债务资金（如银行贷款）等进行投资的投资者。
                2、大宗商品现货交易业务只适合于满足以下全部条件的投资者：
                （1）年满18周岁并具有完全民事行为能力的中国公民或依法在中华人民共和国境内注册成立的企业法人或其他经济组织。
                （2）能够充分理解有关此交易的一切风险，并且具有风险承受能力。
                （3） 因投资失误而造成账户资金部分或全部损失、仍不会改变其正常的生活方式或影响其正常生产经营状况的。
                （4） 具有独立认知能力，精神异常或语言障碍者切忽盲从。
                3、请全面详细的了解为您提供服务的公司。
                4、以下行为均为高风险行为：
                （1）委托其他单位和个人“代理操盘、合作分成”等。
                （2）未妥善保管好交易中使用的密码，设置密码时使用如连续数字、重复数字、出生日期以及其他容易破解的“傻瓜密码”。
                二、 投资者风险提示
                1. 投资者有义务保管好交易账号、密码，避免泄露，因保管不善导致交易账号、密码泄露而引起的风险由投资者自行承担。
                2. 投资者应亲自进行交易活动，切勿委托任何机构或个人进行代理交易活动，因信任他人而产生的风险由投资者自行承担。
                3. 任何保证获利、零风险等宣传均属虚假承诺，因轻信此类信息产生的风险由投资者自行承担。
                4. 投资者根据相关市场信息理性判断、自主决策，并自行承担交易后果；切勿仅凭市场传言而盲目投资。
                5. 投资者参与交易前，应当掌握市场基本知识、相关业务规则，充分了解交易风险，掌握必要的风险防范和化解技巧。
                6. 投资者参与交易前，应当结合自身的家庭情况、收入状况、投资目的及知识结构等因素，合理评估自身的产品认知能力与风险承受能力，理性选择合适的投资方式、投资品种、投资时机、投资金额，请勿盲目投资。
                “投资有风险，入市须谨慎”。我们诚挚地希望并建议投资者，从风险承受能力等自身实际情况出发，审慎地决定是否参与酒世纪商城的大宗商品投资，合理的配置自己的金融资产。请您切记风险！
                </p>
            <p><?=config('web_name')?> 2018.01.07</p>

<!--            <h1>二.投资风险</h1>-->
<!--            <p>1.如果您在我们平台亏钱了， 那就是正常的啦。</p>-->
<!--            <p>1.如果您在平台赚钱了，首先恭喜您， 但我敢打赌您多半会遇到风险一中提到的问题，啊哈哈哈哈。</p>-->

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