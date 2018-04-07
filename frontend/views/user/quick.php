<form name="form1" id="form1" method="post" action="http://ip:port/hmpay/online/createWxOrder.do" target="_self">
<?php foreach ($data as $key => $value): ?>
    <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
<?php endforeach ?>
<input type="submit" value="提交">
</form>
<script language="javascript">document.form1.submit();</script>