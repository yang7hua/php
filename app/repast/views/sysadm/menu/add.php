<h5 class="heading">添加新菜单</h5>
<hr/>
<?php

use \app\models\sysadm\Menu;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
	'options'	=>	['class'	=>	'form-horizontal'],
	'fieldConfig'	=>	[
		'labelOptions'	=>	['class'	=>	'col-lg-2 control-label'],
		'template'  =>  '{label}<div class="col-lg-3">{input}</div><div class="col-lg-2">{error}</div>'
	]
]);
echo $form->field($model, 'title');
echo $form->field($model, 'cid')->dropDownList(Menu::categories());
echo $form->field($model, 'aid')->dropDownList(Menu::activities());
echo $form->field($model, 'price');
echo $form->field($model, 'favorable_price');
echo $form->field($model, 'new', ['template'	=>	'{label}<div class="col-lg-3 radio">{input}</div><div class="col-lg-2">{error}</div>'])->radioList(Menu::newOptions());
echo $form->field($model, 'provide_time', ['template'	=>	'{label}<div class="col-lg-3 radio">{input}</div><div class="col-lg-2">{error}</div>'])->radioList(Menu::provideOptions());
echo $form->field($model, 'peppery', ['template'	=>	'{label}<div class="col-lg-3 radio">{input}</div><div class="col-lg-2">{error}</div>'])->radioList(Menu::peppery());
echo $form->field($model, 'status', ['template'	=>	'{label}<div class="col-lg-3 radio">{input}</div><div class="col-lg-2">{error}</div>'])->radioList(Menu::status());
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
