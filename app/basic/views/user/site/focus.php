<?php 
use app\models\Focus;

$focus = Focus::getFocus();
?>
<div class="panel panel-default">
	<div class="panel-heading"><?= $menu['label'] ?>设置</div>
	<div class="panel-body">
		<p><span class="glyphicon glyphicon-bookmark"></span> 添加焦点图: 进入<a href="/user/blog/list">博客列表</a> 添加</p>
	<table class="table">
		<tr>
			<th width=35%>图片</th>
			<th width=50%>标题</th>
			<th width=15%>排序</th>
		</tr>
<?php if ($focus):
		foreach ($focus as $row):
?>
		<tr>
		<td><img width=100 src="<?= $row['image'] ?>"></td>
		<td><?= $row['title'] ?></td>
		<td><?= $row['sortno'] ?></td>
		</tr>			
<?php
		endforeach;
	endif;
?>
	</table>
	</div>
</div>
