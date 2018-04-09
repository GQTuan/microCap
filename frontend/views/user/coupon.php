<style type="text/css">
  body{
    background: #fff;
  }
</style>
<div class="deta_more">没有更多了</div>
<div class="coupon-container">
   <ul>
   <?php foreach ($userCoupons as $userCoupon) :?>
       <li class="flex-nowrap"> 
           <div>
               <p class="coupon-level">￥<span><?= $userCoupon->coupon->amount ?></span>元代金券(<?= $userCoupon->number ?>)</p>
               <p class="coupon-deadline">有效期:<span><?= round((strtotime($userCoupon->valid_time) - time())/86400, 0) ?></span></p>
           </div>
           <a href="<?= url(['order/transDetail']) ?>" class="flex-none">立即<br/>使用</a>
       </li>
       <?php endforeach ?>
   </ul>
</div>