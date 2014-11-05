<?php
$this->params['title'] = $title;
$this->params['keywords'] = array_merge($this->params['keywords'], explode(',', $tags));
$this->params['description'] = $description;

$relate_list = Yii::$app->blog->getListByCid($cid)['list'];
?>
<div class="container blog-detail">
	<div class="row">
		<div class="col-lg-9">
			<div class="detail">
				<div class="detail-title">
					<h3><?= $title ?></h3>
					<div class="info">
						<div class="col-lg-6">	
						<span><?= date('Y-m-d H:i', $addtime) ?></span>
						&nbsp;&nbsp;<span>阅读: <?= $read ?></span>
						&nbsp;&nbsp;<span>评论: <?= $comment ?></span>
						&nbsp;&nbsp;<span>分类: <a class="primary" href="/topic/<?= $cid ?>"><?= $name ?></a></span>
						</div>
						<div class="col-lg-6 text-right">
							<?= Yii::$app->blog->showTags($tags) ?>
						</div>
					</div>
				</div>	
				<div class="detail-content">
					<?= $content ?>
				</div>
				<div class="row detail-pn">
<?php 
$prev = Yii::$app->blog->prev($id, $cid);
$next = Yii::$app->blog->next($id, $cid);
?>
					<p class="col-lg-6">
					<?php if ($prev):?>
						上一篇: <a class="primary" href="<?= $prev['url'] ?>"><?= $prev['title'] ?></a>
					<?php endif; ?>
					</p>
					<p class="col-lg-6 text-right">
					<?php if ($next):?>
						下一篇: <a class="primary" href="<?= $next['url'] ?>"><?= $next['title'] ?></a>
					<?php endif; ?>
					</p>
				</div>
			</div><!--./detail-->
<?php 
if ($allow_review): 
	echo $this->render('/site/widgets/comment', ['id'=>$id]);
endif; 
?>
		</div>

		<div class="col-lg-3">
			<div class="">
				<div class="sidebar">
					<?=$this->render('/site/widgets/search')?>
					<br/>
					<br/>
					<h5>相关博文</h5>
					<ul>
						<?php foreach ($relate_list as $row): 
								if ($row['id'] == $id)
									continue;
						?>
							<li><a href="<?= $row['url'] ?>"><?= $row['title'] ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?=$this->render('/site/widgets/category')?>
				</div>
			</div>
		</div>
	</div>
</div>
