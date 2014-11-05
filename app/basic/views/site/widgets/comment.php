<?php
use app\models\Review;
$commentList = Review::getListByBlogId($id);
?>
<div class="comment">
<div class="row">
<p class="col-lg-12">评论 ( <?=count($commentList['list'])?> ) </p>
<form name="comment" action="/blog/review/" onsubmit="return false">
	<input type="hidden" name="id" value="<?=$id?>">
	<div class="col-lg-3"><input placeholder="昵称" name="nickname" class="form-control" type="text"/></div>
	<div class="col-lg-12"><textarea placeholder="内容" name="content" class="form-control"></textarea></div>
	<div class="col-lg-10 tip">*注: 昵称只能填写中文，内容必须包含中文，HTML标签将自动过滤</div>
	<div class="col-lg-2 text-right">
		<span name="submit" class="btn btn-primary">发布</span>
	</div>
</form>
</div><!--/. form -->
	<div class="">
		<div class="comment-list">
<?php 
if ($commentList['list']):
	foreach ($commentList['list'] as $key=>$row):
		if (\Yii::$app->controller->isSuper($row['uid'])):
?>
		<div class="list list-super">
			<div class="content"><span class="arrow arrow-right"></span><?=$row['content']?></div>
			<div class="nickname">博主 <span class="time"><?=date('y/m/d',$row['time'])?></span></div>
		</div>	
<?php
		else:
?>
		<div class="list">
			<div class="nickname"><span class="time"><?=date('y/m/d',$row['time'])?>,</span> <?=$row['nickname']?>:</div>
			<div class="content"><span class="arrow arrow-left"></span><?=$row['content']?></div>
		</div>	
<?php
		endif;
	endforeach;
endif;
?>
		</div>
	</div>
</div>
<?php 
echo $this->registerJsFile('/js/detail.js', ['depends'=>['app\assets\AppAsset']]);
?>
