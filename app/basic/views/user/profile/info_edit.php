<?php

use yii\widgets\ActiveForm;

$this->title = '资料修改';
?>
	<div class="profile panel panel-default">
		<div class="panel-heading">资料修改</div>
		<div class="panel-body">
<?php $form = ActiveForm::begin([
	'id'	=>	'profile-form',
	'options'	=>	['class'	=>	'form-horizontal'],
	'fieldConfig'	=>	[
		'template'	=>	"<div class='col-lg-2 text-right'>{label}</div><div class='col-lg-5'>{input}</div><div class='col-lg-5'>{error}</div>"
	]
]); ?>
<div class="form-group">
	<div class="col-lg-2 text-right">头像</div>
	<div class="col-lg-5 field-avatar">
		<div><img src="<?= $info['avatar']; ?>"></div>
		<a href="/user/profile/avatar/edit">修改头像</a>
	</div>
</div>
<?= $form->field($model, 'nickname', ['template'=>'<div class="col-lg-2 text-right">{label}</div><div class="col-lg-3">{input}</div><div class="col-lg-5">{error}</div>']) ?>
<?php $form::end(); ?>
		</div>
	</div>

