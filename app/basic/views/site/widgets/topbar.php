<?php
if (Yii::$app->user->isGuest)
	$items = [['label' => '登录', 'url' => '/user/login']];
else
	$items = [
		['label' => '<img src="'.Yii::$app->user->identity->avatar.'" width=25 height=25>', 'url'=>'/user', 'style'=>'border-radius:2px;'],
		['label' => '个人中心', 'url' => '/user'],
		['label' => '登出 (' . Yii::$app->user->identity->username . ')',
		'url' => '/user/logout',
		],
	];

$banners = \app\models\Banner::getBanner();
?>
		<div class="topbar">
			<div class="container">
				<div class="">
					<ul class="topbar-left">
						<li><a href="/">首页</a></li>
<?php 
	foreach ($banners as $banner): 
		if (is_array($banner['child'])):
?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $banner['name']?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
<?php foreach ($banner['child'] as $child): ?>
					<li><a href="<?=$child['url']?>"><?=$child['name']?></a></li>
<?php endforeach; ?>
				</ul>
			</li>
<?php
		else:
?>
			<li><a href="<?= $banner['url'] ?>"><?= $banner['name'] ?></a></li>
<?php 
		endif;
	endforeach; 
?>
					</ul>
					<div class="topbar-right">
					<?php if(Yii::$app->user->isGuest): ?>
						<a href="/user/login">登录</a>
					<?php else:?>
					<a class="avatar" href="/user"><img src="<?= Yii::$app->user->identity->avatar ?>"/></a>
					<a href="/user">个人中心</a>
					<a href="/user/logout">登出 ( <?= Yii::$app->user->identity->username ?> )</a>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
