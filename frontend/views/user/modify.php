<?php $this->regCss('base') ?>
<?php $this->regCss('index') ?>
<?php $this->regCss('mui.min') ?>
<?php $this->regCss('loaders.min') ?>
<?php $this->regCss('loading') ?>
<?php $this->regCss('swiper.min') ?>

<?php $this->regJs('rem') ?>
<?php $this->regJs('others') ?>
<?php $this->regJs('swiper.jquery.min') ?>

<style type="text/css">
    #wizard-toolbar{
        display: none;
    }
    body{
        background: #fff;
    }
    .db {
        display: inline;
    }
    .my_form_group{
        height: 34px;
        line-height: 34px;
        margin: 10px 0;
    }
    .my_form_group label{
        font-size: 14px;
        color:#404040;
        display: inline-block;
        width: 28%;
        text-align: right;
        padding-right: 10px;
        box-sizing: border-box;
    }
    .my_form_group input{
        height: 34px;
        line-height: 34px;
        border: 1px solid #eae8e8;
        font-size: 13px;
        width: 64%;
        padding: 0 12px;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .has_get_btn input{
        width: calc(( 64% - 14px ) / 2 );
        margin-right: 14px;
    }
    .get_btn{
        width: calc(( 64% - 14px ) / 2 );
        display: inline-block;
        text-align: center;
        height: 34px;
        line-height: 34px;
        border: 1px solid #eae8e8;
        font-size: 13px;
        background-color: rgb(245, 73, 61);
        border-color: rgb(245, 73, 61);
        border-radius: 4px;
        color: #fff;
    }
    .submit_btn {
        width: 100%;
        box-sizing: border-box;
        background-color: rgb(245, 73, 61);
        border-color: rgb(245, 73, 61);
        color:#fff;
        margin-top: 20px;
    }
</style>

<script type="text/javascript">
    $(window).load(function(){
        $(".loading").addClass("loader-chanage")
        $(".loading").fadeOut(300)
    })
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
    <form class="modify_form">
        <div class="my_form_group">
            <label>手机号码:</label>
            <input placeholder="请输入手机号码" />
        </div>
        <div class="my_form_group">
            <label>新密码:</label>
            <input type="passowrd" placeholder="" />
        </div>
        <div class="my_form_group has_get_btn">
            <label>验证码:</label>
            <input placeholder="验证码" />
            <span class="get_btn">获取</span>
        </div>
        <div>
            <button class="submit_btn" type="button">重置密码</button>
        </div>
    </form>
</body>