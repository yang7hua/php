<?php
$categories = Yii::$app->blog->categories();
?>
					<h5>博文分类</h5>
					<ul>
						<?php foreach ($categories as $row): ?>
						<li><a href="<?= $row['url'] ?>"><?= $row['name'] ?></a> <span>(<?= $row['count'] ?>)</span></li>
						<?php endforeach; ?>
					</ul>
