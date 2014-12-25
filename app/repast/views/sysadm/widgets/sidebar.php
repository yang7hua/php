<?= \app\models\sysadm\Menubar::output();?>
<?php
$js = '
	var controller = "'.$this->params['controller'].'",
		action = "'.$this->params['action'].'";
	$("[controller="+controller+"]").addClass("active");
';
$this->registerJs($js);
?>
