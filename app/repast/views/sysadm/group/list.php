<h5 class="heading">套餐列表</h5>
<hr>
<?php
if ($list):
?>
<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>名称</th>
		<th>分类</th>
		<th>价格 (元)</th>
		<th>优惠价格 (元)</th>
		<th>辣度</th>
		<th>供应时间</th>
		<th>状态</th>
		<th>操作</th>
	</tr>
<?php 
foreach ($list as $row):
?>
	<tr>
	<td><?=$row['mid']?></td>
	<td><?=$row['title']?></td>
	<td><?=$row['name']?></td>
	<td><?=$row['price']?></td>
	<td><?=$row['favorable_price']?></td>
	<td><?=$row['peppery']?></td>
	<td><?=$row['provide_time_text']?></td>
	<td><?=$row['status_text']?></td>
	<td>
		<a href="<?=\Yii::$app->func->admUrl('/menu/edit/'.$row['mid'])?>">编辑</a>&nbsp;
		<a href="<?=\Yii::$app->func->admUrl('/menu/img/'.$row['mid'])?>">图片</a>
	</td>
	</tr>
<?php
endforeach;
?>
</table>
<?php
else:

endif;
