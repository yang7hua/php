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
						<div class="info row">
							<div class="col-lg-8">
						<span>时间: <?= date('y/m/d H:i', $row['addtime']) ?></span>
						&nbsp;&nbsp;<span>阅读: <?= $row['read'] ?></span>
						&nbsp;&nbsp;<span>回复: <?= $row['comment'] ?></span>
						<span><?php if ($row['is_private']): ?>&nbsp;&nbsp;&nbsp;<span title="仅自己可见" class="glyphicon glyphicon-eye-open"></span>&nbsp;自己可见<?php endif; ?></span>
						<span><?php if ($row['status'] == 'sketch'): ?>&nbsp;&nbsp;&nbsp;<span title="草稿" class="glyphicon glyphicon-edit"></span>&nbsp;草稿<?php endif; ?></span>
						<span><?php if ($row['status'] == 'trash'): ?>&nbsp;&nbsp;&nbsp;<span title="回收站" class="glyphicon glyphicon-trash"></span>&nbsp;回收站<?php endif; ?></span>
						<span><?php if ($row['is_focus'] == 1): ?>&nbsp;&nbsp;&nbsp;<span title="焦点图" class="glyphicon glyphicon-picture"></span>&nbsp;焦点图<?php endif; ?></span>
							</div>
							<div class="col-lg-4 text-right">
							<a href="/user/blog/edit/<?= $row['id'] ?>"><span class="glyphicon glyphicon-pencil"></span>修改</a>
							<?php if ($row['image'] && $row['status'] == 'publish' && $row['is_private'] != 1 && $row['is_focus'] != 1): ?>
							&nbsp;&nbsp;<a class="modals" modal="#addfocus" blog_id="<?= $row['id'] ?>"><span class="glyphicon glyphicon-send"></span> 焦点图</a>
							<?php endif; ?>
							</div>
						</div>
						<div class="description <?php if($row['image']): echo 'des-has-image';endif; ?>">
							<?php if($row['image']): ?>
							<div class="image"><a href="<?=$row['image']?>" class="flyout"><img src="<?= $row['image'] ?>"></a></div>
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

<?php
echo $this->render('/user/modals/addfocus');
?>
