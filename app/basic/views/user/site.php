<?php
$this->title = $menu['label'];
?>
<div class="sitesetting">

<div class="col-lg-2 sidebar">	
	<div class="row">
	<h5>网站设置</h5>
	<ul>
<?php 
$menus = \Yii::$app->controller->siteMenus();

	foreach ($menus as $row):
?>
		<li><a href="<?= $row['url'] ?>"><?= $row['label'] ?></a></li>
<?php
	endforeach;
?>
	</ul>
	</div>
</div>

<div class="col-lg-10 info">
	<?= $this->render('/user/site/'.$menu['code'], ['menu'=>$menu, 'info'=>$info]) ?>	
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
