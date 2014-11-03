<?php
//echo $this->render('widgets/siteinfo');

$list_today = [
	'name'	=>	'热门推荐',
	'url'	=>	'/topic/hot',
	'list'	=>	Yii::$app->blog->getListByAddtime(10)['list']
];

$home_list = Yii::$app->blog->homeList(5);

$focus = app\models\Focus::getFocus();
?>
<div class="index">
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="slider_box" style="height:290px;" id="index_slider">
				<div u="slides" class="sliders">
<?php foreach ($focus as $row): ?>
					<div>
						<img u="image" src="<?= $row['image'] ?>">
						<div u="caption" class="caption">
						<a href="/blog/<?=$row['blog_id']?>"><?=$row['title']?></a>
						</div>
					</div>
<?php endforeach; ?>
				</div>	
			<div u="navigator" class="navigator jssorb16">
            <!-- bullet navigator item prototype -->
				<div u="prototype"></div>
			</div>
			</div>
		</div>
		<div class="col-lg-4 sidebar">
			<?= $this->render('widgets/bloglist', $list_today) ?>
		</div>
	</div>
</div>
<div class="container categories">
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
<?php
$this->registerJsFile('/js/lib/jssor.slider.mini.js', ['depends'=>['app\assets\AppAsset']]);
$this->registerJsFile('/js/index.js', ['depends'=>['app\assets\AppAsset']]);
?>
</div>
