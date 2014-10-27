<?php

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\user\site\BannerForm;

Modal::begin([
	'id'	=>	'addbanner',
	'header'	=>	'<h5>添加导航</h5>'
]);

$model = new BannerForm();
$pids = $model::pids();

$form  = ActiveForm::begin([
		'id'	=>	'addfocus',
		'options'	=>	['class'=>'form-horizontal'],
		'action'	=>'/user/site/banner/add',
		'fieldConfig'	=>	[
			'labelOptions'	=>	['class'=>'col-lg-2 control-label'],
			'template'	=>	"{label}<div class='col-lg-8'>{input}\n{error}</div>"
		]
	]);

//echo $form->field($model, 'title', ['template'=>"{label}<div class='col-lg-4'>{input}\n{error}</div>"]);
?>
<input type="hidden" name="from" value="blogs">
<?php
echo $form->field($model, 'pid')->dropDownList($pids, ['name'=>'pid']); 
echo $form->field($model, 'name')->input('text', ['name'=>'name']);
echo $form->field($model, 'url')->input('text', ['name'=>'url']);
echo $form->field($model, 'sortno')->input('number', ['name'=>'sortno']);
?>
			<div class="form-group">
				<div class="col-lg-2 control-label"></div>
				<div class="col-lg-8">
<?= Html::submitButton('提交', ['class'=>'btn btn-primary col-lg-4', 'id'=>'submit'])?>
				</div>
			</div>
<?php
$form::end();

Modal::end();
