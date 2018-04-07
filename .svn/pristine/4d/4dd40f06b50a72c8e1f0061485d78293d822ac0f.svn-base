<?php use common\helpers\Hui; ?>

<div id="riskArea">
    <table class="table table-border table-hover">
        <tr>
            <th>产品</th>
            <th>总条数</th>
            <th>操作</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <th>
                <h5><?= $product['name'] ?></h5>
            </th>

            <td>
                <?= $product['count'] ?>
            </td>

            <td>
                <a class="edit-fancybox fancybox.iframe btn-warning-outline btn radius  size-S" href="/admin/product/update-goods-data?id=<?= $product['id'] ?>">时间清除</a> 
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>