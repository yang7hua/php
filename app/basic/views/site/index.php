<?php
//echo $this->render('widgets/siteinfo');
use app\assets\WaterfallAsset;
WaterfallAsset::register($this);

$list_today = [
	'name'	=>	'热门推荐',
	'url'	=>	'/topic/hot',
	'list'	=>	Yii::$app->blog->getListByAddtime(10)['list']
];

$newList = Yii::$app->blog->newList(10);
?>
<div class="index">
	<div class="container">
			<div class="row">
				<ul id="waterfall">
					<?php foreach ($newList as $k=>$row): ?>
					<li>
						<?php if($row['image']): ?>
							<a href="<?= $row['url']?>"><img alt="" title="" src="<?= $row['thumb'] ?>"></a>
						<?php endif; ?>
						<h5><a href="<?= $row['url']?>"><?= $row['title'] ?></a></h5>
						<div class="description <?php if($row['image']): echo 'des-has-image';endif; ?>">
							<?= $row['description'] ?>...
							<p>
								<?=date('Y-m-d', $row['uptime'])?>
								&nbsp;&nbsp;<?=$row['read']?>
								&nbsp;&nbsp;<?=$row['comment']?>
							</p>
							<p>分类: <a class="primary" href="<?=$row['c_url']?>"><?= $row['name']?></a><p>
						</div>
					</li>
					<?php endforeach; ?>	
			</div>
	</div>
</div>
<?php
$this->registerJsFile('/js/index.js', ['depends'=>['app\assets\AppAsset']]);
?>
