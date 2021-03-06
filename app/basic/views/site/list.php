<?php 
use yii\widgets\LinkPager;
?>
<div class="container list">
	<div class="row">
		<div class="col-lg-9">
			<div class="listbox content">
					<?php foreach ($data['list'] as $k=>$row): ?>
			<div class="blog-row <?php if($k+1==count($data['list'])){?>noborder<?php }?>">
				<div class="col-lg-2 text-right">
					<h1><?=date('d', $row['uptime'])?></h1>
					<p><?=date('m / Y', $row['uptime'])?></p>
				</div>
				<div class="col-lg-10">
					<div>
						<h5><a href="<?= $row['url']?>"><?= $row['title'] ?></a></h5>
						<p class="info">
						<span>阅读: <?= $row['read'] ?></span>
						&nbsp;&nbsp;<span>回复: <?= $row['comment'] ?></span>
						</p>
						<div class="description <?php if($row['image']): echo 'des-has-image';endif; ?>">
							<?php if($row['thumb'] and isset($row['thumb']['img'])): ?>
							<div class="image"><a href="<?= $row['image']?>" title="" class="flyout"><img alt="" title="" data-original="<?= $row['thumb']['img'] ?>"></a></div>
							<?php endif; ?>
							<?= $row['description'] ?>...&nbsp;&nbsp;<a class="primary" href="<?=$row['url']?>" class="more">阅读更多</a>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
					<?php endforeach; ?>
			<div class="text-center"><?= LinkPager::widget(['pagination'=>$data['page']])?></div>
			</div>
		</div>
		<div class="col-lg-3">
			<?=$this->render('/site/widgets/sidebar')?>
		</div>
	</div>
</div>
<?php
$js = '
	$(function(){
		var minH = $(".sidebar").height(),
			conH = $(".content").height();
		if (minH < conH)
			$(".sidebar").height($(".content").height() - 30);
	});
';
$this->registerJs($js);
?>
