<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
?>
<div class="login text-center">
<div class="login-form col-lg-5">
<div class="panel panel-default text-left">
	<div class="panel-heading"><strong>登录</strong></div>
	<div class="panel-body">
	<?php $form = ActiveForm::begin([
		'id'=>'login',
		'options'	=>	['class'=>'form-horizontal'],
		'fieldConfig'	=>	[
			'labelOptions'	=>	['class'=>'col-lg-2 control-label'],
			'template'  =>  "{label}<div class='col-lg-8'>{input}\n{error}</div>"
		]
	]); ?>
	<?= $form->field($model, 'username') ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'captcha')->widget(Captcha::className(), [
		'imageOptions'	=>	[
			'class'	=>	'captcha'
		],
		'template'	=>	"<div class='row'><div class='col-lg-4'>{image}</div><div class='col-lg-8'>{input}</div></div>"
	])?>
    <div class="form-group">
		<div class="col-lg-2"></div>
        <div class="col-lg-7">
		<?= Html::submitButton('登&nbsp;&nbsp;录', ['class'=>'btn btn-primary', 'name'=>'login-button'])?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	</div>
</div>
</div>
</div>
<?php
