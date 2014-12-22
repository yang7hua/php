<h5 class="heading">菜单列表</h5>
<hr>
<a class="btn btn-link" href="<?=\Yii::$app->func->admUrl('/menu/add')?>">添加新菜单</a>
<?php
if ($list):
?>
<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>名称</th>
		<th>分类</th>
		<th>状态</th>
		<th>操作</th>
	</tr>
<?php 
foreach ($list as $row):
?>
	<tr>
	<td><?=$row['cid']?></td>
	<td><?=$row['title']?></td>
	<td><?=$row['name']?></td>
	<td><?=$row['status_text']?></td>
	<td>
		<a href="<?=\Yii::$app->func->admUrl('/category/edit/'.$row['cid'])?>">编辑</a>
	</td>
	</tr>
<?php
endforeach;
?>
</table>
<?php
else:

endif;
