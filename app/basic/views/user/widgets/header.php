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
				<h3><?= $userinfo->username ?></h3>	
				<ul class="menu">
					<li><a href="/user/blog/list">博文目录</a></li>
					<li><a href="/user/blog/images">图片</a></li>
					<li><a href="/user/profile/info">关于我</a></li>
				</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="row">
					<a class="glyphicon glyphicon-search"></a>
				</div>
			</div>
		</div>
	</div>
</div>
