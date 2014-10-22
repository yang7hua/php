<?php

$this->title = '修改头像';

use yii\widgets\ActiveForm;
?>
<div class="profile-avatar">
<?php

$form = ActiveForm::begin([
	'id'	=>	'avatar-edit-form',
	'options'	=>	[
		'class'	=>	'form-horizontal',
		'enctype'	=>	'multipart/form-data'
	],
	'fieldConfig'	=>	[
		'template'	=>	"<div class='col-lg-2'>{label}</div><div class='col-lg-5'>{input}</div><div class='col-lg-5'>{error}</div>"
	]
]);

echo $form->field($model, 'avatar')->fileInput(['title'=>'选择图片']);
$form->end();

$info = \Yii::$app->user->identity;
?>
<div class="form-group">
	<div class="col-lg-2"></div>
	<div class="col-lg-10">
		<input type="hidden" name="coords">
		<input type="hidden" name="avatar">
		<div class="col-lg-8">
			<div id="jcrop" class="row"><img src="<?=$info->avatar?>" id="jcrop-image"></div>
		</div>
		<div class="col-lg-4">
			<div class="thumb thumb180"><img src="<?=$info->avatar?>"></div>
			<br/>
			<div class="thumb thumb80"><img src="<?=$info->avatar?>"></div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-lg-2"></div>
	<div class="col-lg-10">
		<button class="btn btn-primary" id="saveAvatar">保存</button>
	</div>
</div>
<?php


//$this->registerJsFile('/js/lib/bootstrap.file-input.js', ['depends'=>['app\assets\AppAsset']]);
$this->registerCssFile('/css/lib/jquery.Jcrop.css');
$this->registerJsFile('/js/lib/ajaxFileUpload.js', ['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('/js/lib/jquery.Jcrop.min.js', ['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('/js/user/avatar.js', ['depends'=>['app\assets\AppAsset']]);
?>

</div>
