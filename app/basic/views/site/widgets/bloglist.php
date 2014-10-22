<h5 class="bloglist-title"><a href="<?= $url ?>"><?= $name ?></a></h5>
<ul class="bloglist">
<?php foreach ($list as $blog): ?>
	<li><a href="<?= $blog['url'] ?>" title="<?= $blog['title'] ?>"><?= $blog['title'] ?></a></li>
<?php endforeach;?>
</ul>
