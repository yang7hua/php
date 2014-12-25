<?php
if ($msg = \Yii::$app->session->get('msg') and \Yii::$app->session->get('msg_expire') > time()):
	$type = 'success';
	if (is_array($msg)):
		if (isset($msg['success'])):
			$type = $msg['success'] ? 'success' : 'error';
		endif;
		if (isset($msg['msg'])):
			$msg = $msg['msg'];
		else:
			$msg = '';
		endif;
	endif;
	if ($msg):
		\Yii::$app->session->set('msg_expire', time());
?>
<div class="message message-success"><?=$msg?></div>
<?php
$js = '
setTimeout("util.msgtips.show()", 100);
setTimeout("util.msgtips.hide()", 3000);
';
$this->registerJs($js);
	endif;
endif;
