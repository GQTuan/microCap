<footer class="page-footer fixed-footer" id="footer">
    <ul class="flex-nowrap">
        <li class="<?php if ($this->context->id == 'site') {echo 'active';} ?>">
            <a href="<?= url(['site/shop']) ?>">
                <p>首页</p>
            </a>
        </li>
        <li class="<?php if ($this->context->module->requestedRoute == 'order/trans-detail') {echo 'active';} ?>">
            <a href="<?= url(['order/position']) ?>">
                <p>订单</p>
            </a>
        </li>
        <li class="<?php if ($this->context->id == 'user') {echo 'active';} ?>">
            <a href="<?= url(['user/index']) ?>">
                <p>我的</p>
            </a>
        </li>
    </ul>
</footer>


