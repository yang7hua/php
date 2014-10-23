<?php
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Html;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Button;
use yii\ueditor\Ueditor;

$this->title = '博客发布';

$status = Yii::$app->blog->status();
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
]); 

$model->allow_review = 1;
$model->is_private = 0;
$model->status = 'publish';
if (isset($do) && $do == 'edit'):
	$model->id = $info['id'];
	$model->title = $info['title'];
	$model->tags = $info['tags'];
	$model->content = $info['content'];
	$model->cid = $info['cid'];
	$model->allow_review = $info['allow_review'];
	$model->is_private = $info['is_private'];
	$model->status = $info['status'];
?>
<input type="hidden" name="do" value="edit">
<input type="hidden" name="id" value="<?= $info['id'] ?>">
<?php
endif;
?>
<div class="col-lg-9">
	<div class="panel panel-default">
		<div class="panel-heading">博客</div>
		<div class="panel-body">
<?= $form->field($model, 'title')->input('text') ?>
<?= $form->field($model, 'tags')->input('text') ?>
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
<?= $form->field($model, 'allow_review', ['template'=>"{input}"])->label(false)->radioList([1=>'允许评论', 0=>'不允许评论']) ?>
<?= $form->field($model, 'is_private', ['template'=>"{input}<label>&nbsp;仅自己可见</lable>"])->checkbox([], false) ?>
			<h5 class="form-group">状态</h5>
<?= $form->field($model, 'status', ['template'=>"{input}"])->label(false)->radioList($status) ?>
			<div class="form-group">
<?= Html::submitButton('提交', ['class'=>'btn btn-primary btn-block', 'name'=>'login-button'])?>
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
