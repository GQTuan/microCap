<select class="city"> 
<?php foreach ($productPrice as $key => $arr): ?>
    <option value="<?= $arr['id'] ?>"><?= $arr['unit'] ?></option> 
<?php endforeach ?>
</select>
