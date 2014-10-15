<?php 
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\CategoryForm;

Modal::begin([
		'id'	=>	'addcategory',
		'header'	=>	'<h5>添加分类</h5>'	
	]);

$model = new CategoryForm();

$form = ActiveForm::begin([
		'id'	=> 'category_add',
		'options'	=>	['class'=>'form-horizontal'],
		'fieldConfig'	=>	[
			'template'	=> "<div class='col-lg-2'>{label}</div><div class='col-lg-5'>{input}</div><div class='col-lg-5'>{error}</div>"
		]
	]);
echo $form->field($model, 'name');
$form::end();

Modal::end();

$js = '$(".showmodal").on("click", function(){
	var modal = $(this).attr("href");
	if (modal)
		$(modal).modal("show");
	return false;
})';
$this->registerJs($js);
?>
