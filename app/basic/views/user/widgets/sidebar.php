<?php 
$categories = Yii::$app->blog->categories(\Yii::$app->user->getId());
?>
<div class="sidebar">
	<h5>分类目录</h5>
	<ul>
<?php if ($categories): 
		foreach ($categories as $category):
?>
			<li><a href="/user/blog/topic/<?= $category['cid'] ?>"><?= $category['name'] ?></a></li>
<?php	endforeach; 
	endif;
?>
	</ul>

<?php
//网站相关设置
/*
if (\Yii::$app->controller->isSuper()) :
	$menus = \Yii::$app->controller->siteMenus();
?>
	<h5>网站设置</h5>
	<ul>
<?php foreach ($menus as $menu): ?>
	<li><a href="<?= $menu['url'] ?>"><?= $menu['label'] ?></a></li>
<?php endforeach; ?>
	</ul>

<?php 
endif;
 */
?>
</div>


