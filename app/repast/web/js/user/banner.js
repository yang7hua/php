var editor;
$(function(){
	editor = new $.fn.dataTable.Editor({
		ajax : '/user/site/banner/list',
		table : '#bannerlist',
		fields : [
			{lable:'名称', name:'name'},
			{lable:'URL', name:'url'},
			{lable:'排序', name:'sortno'}
		]
	});

	var table = $('#bannerlist').DataTable({
		lengthChange:false,
		ajax : '/user/site/banner/list',
		columns : [
			{data:'name'},
			{data:'url'},
			{data:'sortno'}
		]
	});

	var tableTools = new $.fn.dataTable.TableTools(table, {
		sRowSelect : 'os',
		aButtons : [
			{sExtends:'editor_create', editor:editor},
			{sExtends:'editor_edit', editor:editor},
			{sExtends:'editor_remove', editor:editor}
		]
	});

	console.log(tableTools.fnContainer());
});
