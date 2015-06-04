{Layout#index}
<div class="data-bar">
	<span class="btn btn-default" data-action="edit">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>编辑
	</span>
	<span class="btn btn-default" data-action="add">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加
	</span>
</div>
<div class="data-grid" src="<?=$this->CI->url('/node/list')?>" dbclick=true modal-edit="#modal-edit">
		<div field="id">ID</div>
		<div field="name">导航名称</div>
		<div field="controller_name">模块名称</div>
		<div field="controller_code">模块标识</div>
		<div field="action_name">操作名称</div>
		<div field="action_code">操作标识</div>
		<div field="pid">父ID</div>
		<div field="status" format="format_status">是否显示</div>
		<div field="sortno">排序</div>
</div>
<div class="modal fade" id="modal-edit">
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<form class="form-horizontal" action="<?=$this->CI->url('/node/create')?>" method="post">
<div class="modal-header">
	<h5>导航</h5>
</div>
<div class="modal-body">
		<input type="hidden" name="id">
	<table class="table">
		<thead>
		<tr>
			<th>导航名称</th>
			<th>模块名称</th>
			<th>模块标识</th>
			<th>操作名称</th>
			<th>操作标识</th>
			<th>父ID</th>
			<th width=100>是否显示</th>
			<th>排序</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td class="form-group">
			<input name="name" class="form-control" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<input name="controller_name" class="form-control" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<input name="controller_code" class="form-control" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<input name="action_name" class="form-control" >
			<div class="help-block"></div>
		</td>
		<td>
			<input name="action_code" class="form-control" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<input name="pid" type="number" class="form-control {number:1,required:1}" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<select class="form-control {required:1}" name="status">
				<option value=1>显示</option>
				<option value=0>不显示</option>
			</select>
			<div class="help-block"></div>
		</td>
		<td>
			<input name="sortno" type="number" value=0 class="form-control {number:1}">
			<div class="help-block"></div>
		</td>
		</tr>
		</tbody>
	</table>
</div>
<div class="modal-footer text-center">
	<button class="btn btn-primary" type="submit">提交</button>
</div>
	</form>
</div>
</div>
</div>
</div>
<script>
function format_status(v)
{
	return v == 1 ? "显示" : "不显示";
}
</script>
