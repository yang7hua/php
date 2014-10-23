<h5><?= $label ?>设置</h5>
<?php
use app\models\user\site\InfoForm;
use yii\widgets\ActiveForm;

$model = new InfoForm();

$form  = ActiveForm::begin([
		'id'	=>	'siteinfo',
		'options'	=>	['class'=>'form-horizontal'],
		'fieldConfig'	=>	[
			'labelOptions'	=>	['class'=>'col-lg-2 control-label'],
			'template'	=>	"{label}<div class='col-lg-8'>{input}\n{error}</div>"
		]
	]);

echo $form->field($model, 'title', ['template'=>"{label}<div class='col-lg-4'>{input}\n{error}</div>"]);
$form::end();
?>
