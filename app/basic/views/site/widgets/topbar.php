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
?>
		<div class="topbar">
			<div class="container">
				<div class="">
					<div class="topbar-left"><a href="/">首页</a></div>
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
