<div class="sitesetting">

<div class="col-lg-2 sidebar">	
	<h5>网站设置</h5>
	<ul>
<?php 
$menus = \Yii::$app->controller->siteMenus();

	foreach ($menus as $menu):
?>
		<li><a href="<?= $menu['url'] ?>"><?= $menu['label'] ?></a></li>
<?php
	endforeach;
?>
	</ul>
</div>

<div class="col-lg-10 info">
	<?= $this->render('/user/site/'.$info['code'], $info) ?>	
</div>

</div>


<?php
/*
if (\Yii::$app->controller->isSuper()) :

	foreach ($menus as $menu):
		echo $this->render('/user/modals/'.$menu['modal']);
	endforeach;

$this->registerJs($js);

$this->registerJsFile('/js/user/site.js', ['depends'=>['app\assets\AppAsset']]);

endif;
*/
?>
