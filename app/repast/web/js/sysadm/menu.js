$(function(){
	var group_ids = [],
		group_add = $("#group-add"),
		group_wrapper = group_add.find("#group-wrapper");

	function group_output()
	{
		if (group_ids.length < 1)
			return;
		var str = '套餐：';
		$.each(group_ids, function(k, id){
			str += getTitleByMid(id) + ',';
		});
		
		var str = str.slice(0, -1).replace(',', ' + ');
		group_wrapper.html(str);
		group_add.removeClass('hide');
	}

	function getTitleByMid(mid)
	{
		var tr = $("[mid="+mid+"]");
		return tr.find("td").eq(1).text();
	}

	$("[group=true]").on("click", function(){
		var $this = $(this),
			mid = $this.attr("mid");

		if (!mid) {
			alert('参数错误');
			return false;
		}
		if ($.inArray(mid, group_ids) == -1)
			group_ids.push(mid);

		util.setCookie('group_ids', group_ids.join(','));
		group_output();
	});

	if (group_ids = util.getCookie('group_ids'))
	{
		group_ids = group_ids.split(',');
		group_output();
	}
	else
		group_ids = [];

});
