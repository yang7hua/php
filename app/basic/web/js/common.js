$(function(){
	$(".flyout").flyout({
		outSpeed : 300,
		inSpeed : 200,
		closeTip : "点击关闭" 
	});	
	$("[type=search]").keydown(function(e){
		var input = $(this);
		if (e.keyCode == 13) {
			var keyword = input.val();	
			if (keyword)
				location.href = '/search/' + keyword;
		}
	});
});
