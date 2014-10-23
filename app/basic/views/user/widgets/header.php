<div class="header">
	<div class="container">
<?php 
	$userinfo = Yii::$app->user->identity;
?>	
		<div class="row">
			<div class="col-lg-2 avatar">
				<img src="<?= $userinfo->avatar?>">
			</div>
			<div class="col-lg-4 info">
				<div class="row">
				<h3><a href="/user"><?= $userinfo->username ?></a></h3>	
				<ul class="menu">
					<li><a href="/user/blog/list">博文目录</a></li>
					<li><a href="/user/blog/images">图片</a></li>
					<li><a href="/user/profile/info">关于我</a></li>
<?php 
	if (Yii::$app->controller->isSuper()):
		$menus = Yii::$app->controller->siteMenus();
?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">网站设置<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
<?php foreach ($menus as $menu): ?>
							<li><a href="<?= $menu['url'] ?>"><?= $menu['label'] ?></a></li>
<?php endforeach; ?>
						</ul>
					</li>
<?php
	endif;
?>
				</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="row btns">
					<a href="/user/blog/publish" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-edit"></span>&nbsp;发博文</a>
				</div>
			</div>
		</div>
	</div>
</div>
