
<?php foreach ($data as $userPrize) :?>  
        <li class="flex-nowrap">
            <span><?= $userPrize->created_at ?></span>
            <span><?= $userPrize->prize->prize?></span>
            <span><span class="prizeid <?php if($userPrize->state == 1){echo 'active';} ?>" data-id="<?= $userPrize->id ?>" data-pid="<?= $userPrize->prize_id ?>"><?= $userPrize->getStateValue($userPrize->state) ?></span></span>
        </li>
<?php endforeach ?>
 <script type="text/javascript">
    $(".prizeid").click(function(){
        if($(this).hasClass("active")){
            return;
        }
        $this = $(this);
        var obj = {};
        obj.uid = $(this).data("id");
        obj.pid = $(this).data("pid");
        $.post("<?= url(['user/giveCoupon']) ?>", {data:obj}, function(msg){
            if(msg.state) {
                $.alert(msg.info,function(){
                    $this.addClass("active").html("已领取");
                });
            }
        });
    })

</script> 