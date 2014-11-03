<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

$this->title = '用户登录';
echo $this->render('/site/widgets/topbar');
?>
<div class="login">
<div class="bg"></div>
<div class="container">
<div class="col-lg-1"></div>
<div class="col-lg-8" id="user-login-box">
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
        <div class="col-lg-8">
		<?= Html::submitButton('登&nbsp;&nbsp;录', ['class'=>'btn btn-lg btn-block btn-primary', 'name'=>'login-button'])?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
</div>
</div>
<?php echo $this->render('/site/widgets/footer');?>
