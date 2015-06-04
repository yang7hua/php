{Layout#index}
<div class="data-bar">
	<span class="btn btn-default" data-action="edit">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>编辑
	</span>
	<span class="btn btn-default" data-action="add">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加
	</span>
</div>
<div class="data-grid" src="<?=$this->CI->url('/product_attr/list')?>" dbclick="true" modal-edit="#modal-edit">
		<div field="pa_id">ID</div>
		<div field="pa_name">值</div>
		<div field="pid" format="format_pid">类型</div>
</div>
<div class="modal fade" id="modal-edit">
<div class="modal-dialog modal-xs">
<div class="modal-content">
	<form class="form-horizontal" action="<?=$this->CI->url('/product_attr/create')?>" method="post">
<div class="modal-header">
	<h5>属性</h5>
</div>
<div class="modal-body">
		<input type="hidden" name="pa_id">
	<table class="table">
		<thead>
		<tr>
			<th>值</th>
			<th>pid</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td class="form-group">
			<input name="pa_name" class="form-control {required:1}" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
<?php
echo $this->html->select('pid', $this->html->to_options($attrs, 'pa_id', 'pa_name'), [], 0);
?>
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
var attrs = <?=json_encode($attrs)?>;
function format_pid(v)
{
	return util.find_value_inarray_bykey(attrs, v, 'pa_id', 'pa_name');
}
</script>
