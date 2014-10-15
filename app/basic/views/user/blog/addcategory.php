<?php 
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\CategoryForm;
use yii\helpers\Html;

Modal::begin([
		'id'	=>	'addcategory',
		'header'	=>	'<h5>添加分类</h5>'	
	]);

$model = new CategoryForm();

$form = ActiveForm::begin([
		'id'	=> 'category_add',
		'action'	=>	'/user/blog/addcategory',
		'options'	=>	['class'=>'form-horizontal'],
		'fieldConfig'	=>	[
			'template'	=> "<div class='col-lg-2'>{label}</div><div class='col-lg-5'>{input}</div><div class='col-lg-5'>{error}</div>"
		]
	]);
echo $form->field($model, 'name');
?>
	<div class="form-group">
		<div class="col-lg-2"></div>
		<div class="col-lg-5">
		<?= Html::submitButton('添加', ['class'=>'btn btn-primary']); ?>
		</div>
	</div>
<?php
$form::end();

Modal::end();

$js = '
$(".showmodal").on("click", function(){
	var modal = $(this).attr("href");
	if (modal)
		$(modal).modal("show");
	return false;
});

var $addcategory = $("#category_add");
$addcategory.find("[type=submit]").on("click", function(){
	var category_name = $addcategory.find("#categoryform-name");
	$.ajax({
		url : $addcategory.attr("action"),
			type : "post",
			dataType : "json",
			data : {
				"CategoryForm[name]" : category_name.val()
			},
			success : function(res){
				console.log(res);
			}
	});
	return false;
});
';
$this->registerJs($js);
?>
