<?php
//echo $this->render('widgets/siteinfo');

$list_today = [
	'name'	=>	'热门推荐',
	'url'	=>	'/topic/hot',
	'list'	=>	Yii::$app->blog->getListByAddtime(10)['list']
];

$home_list = Yii::$app->blog->homeList(5);
?>

<div class="container">
	<div class="row">
		<div class="col-lg-8"></div>
		<div class="col-lg-4"><?= $this->render('widgets/bloglist', $list_today) ?></div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="row">
			<?php foreach($home_list as $category): 
					if (!count($category['list']))
						continue;
			?>
				<div class="col-lg-6 category-bloglist">
<?php 
echo $this->render('widgets/bloglist', $category);
?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
		<div class="col-lg-4"></div>
	</div>
</div>
