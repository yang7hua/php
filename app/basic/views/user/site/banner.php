<?php
use app\models\Banner;

use app\assets\DatatableAsset;

$banner = Banner::getBanner();

?>

<div class="panel panel-default">
	<div class="panel-heading"><?= $menu['label'] ?>设置</div>
	<div class="panel-body">
	<p><a class="modals" modal="#addbanner">添加导航</a></p>
	<table class="table table-striped" id="bannerlist">
		<tr>
			<th width=20%>名称</th>
			<th width=50%>URL</th>
			<th width=15%>排序</th>
			<th width=15%>操作</th>
		</tr>
<?php if ($banner):
		foreach ($banner as $row):
?>
		<tr>
		<td><?= $row['name'] ?></td>
		<td><a href="<?=$row['url']?>"><?= $row['url'] ?></a></td>
		<td><?= $row['sortno'] ?></td>
		<td><a class="edit" id="<?= $row['id']?>">编辑</a></td>
		</tr>			
<?php
		endforeach;
	endif;
?>
	</table>
	</div>
</div>
<?php
echo $this->render('/user/modals/addbanner');
?>
