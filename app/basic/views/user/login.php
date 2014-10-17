<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = '用户登录';
?>
<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
<?php else: ?>
<div class="row" id="user-login-box">
	<?php $form = ActiveForm::begin([
		'id'=>'user-login',
		'options'	=>	['class'=>'col-lg-10'],
		'fieldConfig'	=>	[
			'options'	=>	['class'=>'col-lg-8']	
		]
	]); ?>
		<?= $form->field($model, 'username') ?>
		<?= $form->field($model, 'password')->passwordInput() ?>
		<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
			'template'	=>	"<div class='row'><div class='col-lg-4'>{image}</div><div class='col-lg-8'>{input}</div></div>"
		])?>
    <div class="form-group">
        <div class="col-lg-12">
		<?= Html::submitButton('登录', ['class'=>'btn btn-primary', 'name'=>'login-button'])?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<?php endif; ?>
