<?php

use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\user\site\FocusForm;

Modal::begin([
	'id'	=>	'addfocus',
	'header'	=>	'<h5>添加焦点图</h5>'
]);

$model = new FocusForm();
$types = FocusForm::types();

$form  = ActiveForm::begin([
		'id'	=>	'addfocus',
		'options'	=>	['class'=>'form-horizontal'],
		'action'	=>'/user/blog/tofocus',
		'fieldConfig'	=>	[
			'labelOptions'	=>	['class'=>'col-lg-2 control-label'],
			'template'	=>	"{label}<div class='col-lg-8'>{input}\n{error}</div>"
		]
	]);

//echo $form->field($model, 'title', ['template'=>"{label}<div class='col-lg-4'>{input}\n{error}</div>"]);
?>
<input type="hidden" name="blog_id">
<input type="hidden" name="from" value="blogs">
<?php
echo $form->field($model, 'title')->input('text', ['name'=>'title']);
echo $form->field($model, 'image')->input('text', ['name'=>'image']);
echo $form->field($model, 'type')->dropDownList($types, ['name'=>'type']); 
?>
			<div class="form-group">
				<div class="col-lg-2 control-label"></div>
				<div class="col-lg-8">
<?= Html::submitButton('提交', ['class'=>'btn btn-primary col-lg-4', 'id'=>'submit'])?>
				</div>
			</div>
<?php
$form::end();

$js = '
	$("#addfocus").on("show.bs.modal", function(e){
		var blogid = $(this).attr("blog_id"),
			$modal = $(this);
		var $form = $modal.find("form"), 
			$blog_id = $modal.find("[name=blog_id]"),
			$title = $modal.find("[name=title]"),
			$image = $modal.find("[name=image]"),
			$from = $modal.find("[name=from]"),
			$type = $modal.find("[name=type]");
		$blog_id.val(blogid);

		$.ajax({
			url : "/user/blog/baseinfo",
			type : "post",
			dataType : "json",
			data : {
				id : blogid
			},
			success : function(res){
				if (res.ret > 0) {
					var info = res.data;
					$title.val(info.title);
					$image.val(info.image);
				}
			}
		});

		$("#submit").unbind("click");
		$("#submit").on("click", function(){
			$.ajax({
				url : $form.attr("action"),
				type : "post",
				dataType : "json",
				data : {
					title : $title.val(),
					image : $image.val(),
					type : $type.val(),
					blog_id: blogid,
					from : $from.val(),
				},
				success : function(res){
					if (res.ret > 0)
						$modal.modal("hide");
					else
						alert(res.msg);
				}
			});
			return false;
		})
	});
';
$this->registerJs($js);

Modal::end();
