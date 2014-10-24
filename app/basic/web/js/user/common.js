$(function(){
	$(".modals").on("click", function(){
		var modal = $(this).attr("modal"),
			blog_id = $(this).attr("blog_id");
		if (!modal || !blog_id)
			return false;
		modal = $(modal);
		modal.attr('blog_id', blog_id);
		modal.modal("show");
	});
});
