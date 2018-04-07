    <div class="container">
       <div class="row">
         <div class="header">
           <a href="<?= url(['user/index']) ?>"> <i class="iconfont">&#xf0292;</i></a>
           分享
         </div>
       </div>
   </div>
<div>
    <div class="row">
        <div class="col-xs-12 text-center" >
            <img style="margin: 0px auto; display: block;padding:50px 0 15px;" src="<?= $img ?>"> 
        </div>
        <div class="col-xs-12 font_20 text-center" style="color:#fff;">长按发送给好友</div>
        <div class="col-xs-12  text-center copylink" style="padding: 50px 0;">
            <input type="text" class="input" id="mytxt" value="<?= $url ?>"> &nbsp;
            <button class="tjrz" id="cop" onclick="copy();">复制推广链接</button>
        </div>
    </div>
</div>
    
<script>
function copy() {
    var content = $('#mytxt'); //对象是多行文本框contents 
    content.select(); //选择对象 
    document.execCommand("Copy"); //执行浏览器复制命令
    $('#cop').html('已复制');
}
$(function () {
    $("#submitBtn").click(function () {
        $("form").ajaxSubmit($.config('ajaxSubmit', {
            success: function (msg) {
                if (!msg.state) {
                    $.alert(msg.info);
                }
            }
        }));
        return false;
    });
});
</script>