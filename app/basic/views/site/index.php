<?php
//echo $this->render('widgets/siteinfo');
use app\assets\WaterfallAsset;
WaterfallAsset::register($this);

$list_today = [
	'name'	=>	'热门推荐',
	'url'	=>	'/topic/hot',
	'list'	=>	Yii::$app->blog->getListByAddtime(10)['list']
];

$newList = Yii::$app->blog->newList(20);
?>
<div class="index">
	<div class="container">
			<div class="row">
				<ul id="waterfall">
					<?php foreach ($newList as $k=>$row): ?>
					<li>
						<?php if($row['thumb'] and isset($row['thumb']['img'])): ?>
						<a href="<?= $row['url']?>"><img class="lazy" alt="" title="" width=<?=$row['thumb']['width']?> height=<?=$row['thumb']['height']?> <?php if($k<6):?>src<?php else: ?>data-original<?php endif;?>="<?= $row['thumb']['img'] ?>"></a>
						<?php endif; ?>
						<h5><a href="<?= $row['url']?>"><?= $row['title'] ?></a></h5>
						<div class="description <?php if($row['image']): echo 'des-has-image';endif; ?>">
							<?= $row['description'] ?>...
							<p class="info">
								分类: <a class="primary" href="<?=$row['c_url']?>"><?= $row['name']?></a>
								&nbsp;&nbsp;<?=date('Y-m-d', $row['uptime'])?>
								&nbsp;&nbsp;<?=$row['read']?>
								&nbsp;&nbsp;<?=$row['comment']?>
							</p>
						</div>
					</li>
					<?php endforeach; ?>	
			</div>
	</div>
</div>
<?php
$this->registerJsFile('/js/index.js', ['depends'=>['app\assets\AppAsset']]);
?>
