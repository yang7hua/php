<?php

$this->title = '修改头像';

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	'id'	=>	'avatar-edit-form',
	'options'	=>	['class'	=>	'form-horizontal'],
	'fieldConfig'	=>	[
		'template'	=>	"<div class='col-lg-2 text-right'>{label}</div><div class='col-lg-5'>{input}</div><div class='col-lg-5'>{error}</div>"
	]
]);

echo $form->field($model, 'avatar')->fileInput(['title'=>'选择图片']);

$form->end();

$this->registerJsFile('/js/lib/bootstrap.file-input.js', ['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('/js/user/avatar.js', ['depends'=>['app\assets\AppAsset']]);
?>
