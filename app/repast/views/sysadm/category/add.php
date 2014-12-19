<h5 class="heading">添加菜单分类</h5>
<hr/>
<?php

use app\models\sysadm\Category;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
	'options'	=>	['class'	=>	'form-horizontal'],
	'fieldConfig'	=>	[
		'labelOptions'	=>	['class'	=>	'col-lg-2 control-label'],
		'template'  =>  '{label}<div class="col-lg-3">{input}</div><div class="col-lg-2">{error}</div>'
	]
]);
echo $form->field($model, 'name');
echo $form->field($model, 'status', ['template'	=>	'{label}<div class="col-lg-3 radio">{input}</div><div class="col-lg-2">{error}</div>'])->radioList(Category::status());
?>
		<div class="form-group">
			<div class="col-lg-2"></div>
			<div class="col-lg-1">
<?= Html::submitButton('提交', ['class'=>'btn btn-primary btn-block', 'name'=>'login-button'])?>
			</div>
		</div>
<?php
ActiveForm::end();
?>
