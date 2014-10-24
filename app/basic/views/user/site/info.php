<div class="panel panel-default">
	<div class="panel-heading"><?= $menu['label'] ?>设置</div>
	<div class="panel-body">
<?php
use app\models\user\site\InfoForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$model = new InfoForm();

if ($info) {
	$model->title = $info['title'];
	$model->keywords = $info['keywords'];
	$model->description = $info['description'];
}

$form  = ActiveForm::begin([
		'id'	=>	'siteinfo',
		'options'	=>	['class'=>'form-horizontal'],
		'fieldConfig'	=>	[
			'labelOptions'	=>	['class'=>'col-lg-2 control-label'],
			'template'	=>	"{label}<div class='col-lg-8'>{input}\n{error}</div>"
		]
	]);

echo $form->field($model, 'title', ['template'=>"{label}<div class='col-lg-4'>{input}\n{error}</div>"]);
echo $form->field($model, 'keywords');
echo $form->field($model, 'description')->textarea();
?>
    <div class="form-group">
		<div class="col-lg-2"></div>
        <div class="col-lg-8">
		<?= Html::submitButton('保存', ['class'=>'btn btn-primary', 'name'=>'login-button'])?>
		</div>
	</div>
<?php
$form::end();
?>
	</div>
</div>
