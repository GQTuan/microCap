<style type="text/css">
    body{
        background: #fff;
    }
    .user-conf li {
        background: #f5f5f5;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .user-conf .title {
        color: #333;
    }
    .user-conf li p {
        color: #999;
    }
</style>
<style type="text/css">
    body{
        background: #f5f5f5;
    }
    .modify_n_title span{
        font-size: 12px;
    }
    .modify_name_con textarea{
        width: 100%;
        height: 70px;
        background: #fff;
        font-size: 14px;
        color: #333;
        padding: 14px;
    }
    .setting_list li{
        background:#fff;
        height:50px;
        line-height:50px;
        padding:0 10px;
    }
    .setting_key{
        width: 50%;
        font-size:14px;
        color:#333;
    }
    .lf{
        float:left;
    }
    .rf{
        float:right;
    }

    .setting_value img{
        width:34px;
        height:34px;
        border-radius:50%;
    }
    .header {
        padding: 0px 5px;
        text-align: center;
        position: relative;
        height: 45px;
        line-height: 45px;
        color: #fff;
        font-size: 18px;
        color: #666;
        border-bottom: 1px solid #ddd;
        background-color: #fff;;
    }
    .header a {
        display: inline-block;
        position: absolute;
        top: 1px;
        left: 5px;
        color: #666;
    }
    .back_arrow{
        position: relative;
    }
    .back_arrow:after,.back_arrow:before{
        content: "";
        position: absolute;
        width: 12px;
        border-top: 2px solid #666;
        transform-origin: left;
        -webkit-transform-origin: left;
        top: 20px;
        left: 10px;
    }
    .back_arrow:after{
        transform:rotate(45deg);
        -webkit-transform:rotate(45deg);
    }
    .back_arrow:before{
        transform:rotate(-45deg);
        -webkit-transform:rotate(-45deg);
    }
</style>
<!-- <?php common\components\View::regCss('geren.css') ?> -->

<!--头部导航-->
<!-- <div class="forget">
    <div class="center-list-wrap">
        <ul>
            <li class="table bottom-wrap" data-index="0">
                <a href="<?= url(['user/modifyPwd']) ?>" class="content-w">
                    <div class="content-wrap table-cell">
                        <div class="title">修改交易密码</div>
                        <div class="title-tip">为了您的资金安全，请妥善保管您的交易密码</div>
                    </div>
                </a>
                <div class="table-cell" style="padding-bottom: 0px;"><span class="earrow earrow-right"></span></div> 
            </li>
            <li class="table bottom-wrap" data-index="1">
                <a href="<?= url(['user/modifyPhone']) ?>" class="content-w">
                    <div class="content-wrap table-cell">
                        <div class="title"><span>验证手机</span><span id="mobile" style="padding-left: 0.5em; color: red; font-size: 13px;">
                        <?php if (strlen(u()->mobile) <= 10): ?>
                            您还未设置手机号码
                        <?php else : ?>
                            <?= substr(u()->mobile, 0, 3) . '*****' . substr(u()->mobile, -3) ?>
                        <?php endif ?>
                        </span></div>
                        <div class="title-tip">若您的验证手机丢失或停用，请立即更换</div>
                    </div>
                </a>
                <div class="table-cell" style="padding-bottom: 0px;"><span class="earrow earrow-right"></span></div>
            </li>
        </ul>
    </div>
</div> -->

<ul class="user-conf">

      <li>
        <a href="<?= url(['user/modifyPwd']) ?>">
          <p class="title">修改密码</p>
          <p>为了您的资金安全，请妥善保管您的密码</p>
        </a>
      </li>

      <li>
        <a href="<?= url(['user/modifyPhone']) ?>">
          <p class="title">验证手机 <span>
                <?php if (strlen(u()->mobile) <= 10): ?>
                    您还未设置手机号码
                <?php else : ?>
                    <?= substr(u()->mobile, 0, 3) . '*****' . substr(u()->mobile, -3) ?>
                <?php endif ?>
          </span></p>
          <p>手机号码用于接收各类验证消息，请妥善保管</p>
        </a>
      </li>

        <li>
            <a href="<?= url(['user/setreal']) ?>">
                <p class="title">修改交易密码 <span>
                <?php if (!u()->deal_pwd): ?>
                    您还未设置交易密码
                <?php endif ?>
          </span></p>
                <p>为了您的资金安全，请妥善保管您的密码</p>
            </a>
        </li>

    <li>
        <div class="title">修改头像
            <span class="rt setting_value" id="mobile" style="padding-left: 0.1em; color: #1d84d4; font-size: 13px;position: relative;overflow: hidden;margin-top: 5px;">
                <img src="<?=u()->face?>">
                <input id="avatar" type="file" name="" style="position: absolute;width: 100%;height: 100%;z-index: 999;opacity: 0;right: 0;top: 0;">
            </span>
        </div>

    </li>

</ul>
<script>
    $("input[type='file']").change(function () {
        var _formData = new FormData();
        _formData.append("avatar", document.getElementById("avatar").files[0]);
        $.ajax({
            url: "<?= url(['user/modifyAvatar']) ?>",
            type: "POST",
            data: _formData,
            contentType: false,
            processData: false,
            success: function (resp) {
                if (resp.state) {
                    layer.alert("头像修改成功！");
                    window.location.reload();
                } else {
                    layer.alert(resp.msg);
                }
            },
            error: function (_err) {
                layer.alert("头像修改失败！");
            }
        }, 'json');
    });
</script>
