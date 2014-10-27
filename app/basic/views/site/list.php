<?php 
use yii\widgets\LinkPager;
?>
<div class="container list">
	<div class="row">
		<div class="col-lg-8">
			<div class="row">
					<?php foreach ($data['list'] as $row): ?>
					<div class="blog-row">
						<h5><a href="<?= $row['url']?>"><?= $row['title'] ?></a></h5>
						<p class="info">
						<span>时间: <?= date('y/m/d H:i', $row['addtime']) ?></span>
						&nbsp;&nbsp;<span>阅读: <?= $row['read'] ?></span>
						&nbsp;&nbsp;<span>回复: <?= $row['comment'] ?></span>
						</p>
						<div class="description <?php if($row['image']): echo 'des-has-image';endif; ?>">
							<?php if($row['image']): ?>
							<div class="image"><a href="<?= $row['image']?>" class="flyout"><img src="<?= $row['image'] ?>"></a></div>
							<?php endif; ?>
							<?= $row['description'] ?>...
						</div>
					</div>
					<?php endforeach; ?>
					<?= LinkPager::widget(['pagination'=>$data['page']])?>
			</div>
		</div>
	</div>
</div>
