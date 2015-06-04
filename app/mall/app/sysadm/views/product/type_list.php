{Layout#index}
<div class="data-bar">
	<span class="btn btn-default" data-action="edit">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>编辑
	</span>
	<span class="btn btn-default" data-action="add">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加
	</span>
</div>
<div class="data-grid" src="<?=$this->CI->url('/product_type/list')?>" dbclick="true" modal-edit="#modal-edit">
		<div field="pt_id">ID</div>
		<div field="pt_name">类型名称</div>
		<div field="pname" >父类型</div>
		<div field="pta_id">属性参数</div>
</div>
<div class="modal fade" id="modal-edit">
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<form class="form-horizontal" action="<?=$this->CI->url('/product_type/create')?>" method="post">
<div class="modal-header">
	<h5>产品类型</h5>
</div>
<div class="modal-body">
		<input type="hidden" name="pt_id">
	<table class="table">
		<thead>
		<tr>
			<th width=200>类型名称</th>
			<th>父类型</th>
			<th>属性参数</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td class="form-group">
			<input name="pt_name" class="form-control {required:1}" >
			<div class="help-block"></div>
		</td>
		<td class="form-group">
			<div class="col-md-5">
<?=$this->html->select('pid', $this->html->to_options($types, 'pt_id', 'pt_name'), [], 0);?>
			</div>
			<div class="help-block"></div>
		</td>
		<td><div class="control-label text-left">选择</div></td>
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
