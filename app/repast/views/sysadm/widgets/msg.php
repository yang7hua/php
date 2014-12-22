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
?>
	<div class="row msg msg-<?=$type?>"><?=$msg?></div>
<?php
	endif;
endif;
