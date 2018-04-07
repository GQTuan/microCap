<?php $this->regCss('price') ?>
<?php $this->regCss('login') ?>

<style type="text/css">
    #wizard-toolbar{
        display: none;
    }
    .box-s {
        box-shadow: none;
    }
    .btn {
        padding: 0;
        border-radius: 0;
    }
    .report-header p {
    width: 100%;
    text-align: center;
    float: right;
    color: #404040;
    font-size: .5rem;
}
.sorder {
    width: 100%;
}

.sorder .warning {
    width: 100%;
    padding: 3% 5%;
    font-size: .45rem;
    color: #bcbcbc;
    background-color: #fff;
    border-bottom: 1px solid #dcdad3;
    text-align: left;
    /*overflow: hidden; text-overflow: ellipsis; -webkit-text-overflow: ellipsis; white-space: nowrap;*/
}

.sorder .odernum {
    width: 100%;
    margin-top: 5%;
    background-color: #fff;
    border-top: 1px solid #dcdad3;
    border-bottom: 1px solid #dcdad3;
}

.sorder .odernum ul li {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    color: #333333;
    font-size: .5rem;
    padding: 3% 5%;
    border-bottom: 1px solid #dcdad3;
}

.sorder .odernum ul li:last-child {
    border-bottom: none;
}

.sorder .odernum ul li span {
    color: #d24239;
    font-size: .57rem;
}

.pay-method {
    width: 100%;
    background-color: #fff;
    margin-top: 5%;
    border-top: 1px solid #dcdad3;
}

.pay-method ul li {
    width: 100%;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    padding: 3% 5%;
    border-bottom: 1px solid #dcdad3;
}

.pay-method ul li:last-child {
    border-bottom: none;
}

.pay-method ul li {
    color: #333333;
    margin-top: .3rem
}

.pay-method label {
    font-size: .5rem;
    line-height: 1rem
}
.pay-method input[type="password"] {
    height: .7rem;
    padding: 0;
    width: 5rem;
}
.address-add {
    display: block;
    width: 96%;
    line-height: 1rem;
    margin: 5% 2%;
    font-size: .5rem;
    color: #fff;
    text-align: center;
    background-color: #25cb83;
}

</style>

<script type="text/javascript">
    $(window).load(function(){
        $(".loading").addClass("loader-chanage")
        $(".loading").fadeOut(300)
    })
    $(function(){
    //计算内容上下padding
        reContPadding({main:"#main",header:"#header",footer:"#footer"});
        function reContPadding(o){
            var main = o.main || "#main",
                header = o.header || null,
                footer = o.footer || null;
            var cont_pt = $(header).outerHeight(true),
                cont_pb = $(footer).outerHeight(true);
            $(main).css({paddingTop:cont_pt,paddingBottom:cont_pb});
        }
    });
</script>
<!--loading页开始-->
<div class="loading">
    <div class="loader">
        <div class="loader-inner pacman">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>
</div>
<!--loading页结束-->

<body>
    <header class="mui-bar mui-bar-nav report-header box-s" id="header">
        <a href="javascript:history.go(-1)"><i class="iconfont icon-fanhui fl"></i></a>
        <p>确认支付</p>
    </header>
    <div id="main" class="mui-clearfix contaniner sorder">          
        <div class="warning clearfloat box-s">
            提示：请在24小时内完成在线支付，逾期将视为订单无效
        </div>
        <div class="odernum clearfloat">
            <ul>
                <li>您的订单号：1298451221</li>
                <li>应付积分：<span>10000</span></li>
            </ul>
        </div>
        <div class="pay-method clearfloat">
            <ul>
                <li>
                    <div style="height: 1rem">
                        
                        <label>请输入支付密码：</label>
                        <input type="password" name="password">
                    </div>
                </li>
            </ul>
        </div>

        <a href="#" class="address-add fl">
            确认支付
        </a>
    </div>
    
</body>