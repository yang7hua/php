<?php
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Button;
use yii\ueditor\Ueditor;

$this->title = '博客发布';
?>

<div class="container">
<div class="row">
<?php $form = ActiveForm::begin([
	'id'	=>	'blog_publish',
	'options'	=>	['class'=>'form-horizontal'],
	'fieldConfig'	=>	[
		'labelOptions'	=>	['class'=>'col-lg-1 control-label'],
		'template'	=>	"{label}<div class='col-lg-8'>{input}\n{error}</div>"
	]
]); ?>
<div class="col-lg-9">
	<div class="panel panel-default">
		<div class="panel-heading">博客</div>
		<div class="panel-body">
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'tags') ?>
<?= Ueditor::widget([
	'model'	=>	$model,
	'attribute'	=> 'content',
	'style'	=>	'width:100%; height:300px;',
	'jsOptions'	=>	[
		'autoHeightEnable'	=>	true,
		'autoFloatEnable'	=>	true
	]
]) ?>
		</div>
	</div>
</div>
<div class="col-lg-3">
<div class="panel panel-default">
	<div class="panel-heading">
		发布
	</div>
	<div class="panel-body">
		<div class="col-lg-12">
			<h5 class="form-group">分类</h5>
<?php if ($category):?>
			<?= $form->field($model, 'cid', ['template'=>"{input}"])->dropDownList($category) ?>
<?php endif; ?>
			<a href="#addcategory" class="btn btn-link showmodal">添加分类</a>
			<h5 class="form-group">设置</h5>
<?= $form->field($model, 'allow_review', ['template'=>"{input}"])->label(false)->radioList(['允许评论', '不允许评论'], ['']) ?>
<?= $form->field($model, 'is_private', ['template'=>"{input}<label>&nbsp;仅自己可见</lable>"])->checkbox(['允许', '不允许'], false) ?>
			<div class="form-group">
<?= Html::submitButton('发布', ['class'=>'btn btn-primary btn-block', 'name'=>'login-button'])?>
			</div>
		</div>
	</div>
</div>
</div>
<?php $form->end(); ?>
</div>
</div>

<?php 
echo $this->render('/user/blog/addcategory');
?>
