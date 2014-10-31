$(function(){
	$("img").lazyload({
		effect : "fadeIn" 
	});
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
	if ($("body").hasClass("show_welcome")) {
		$(window).scroll(function(){
			if ($("body").scrollTop() >= $(".welcome").height())
				$(".topbar").addClass("topbar_show");
			else
				$(".topbar").removeClass("topbar_show");
		})
	}
});
