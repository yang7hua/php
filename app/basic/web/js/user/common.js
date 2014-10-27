$(function(){
	$(".modals").on("click", function(){
		var modal = $(this).attr("modal");
		var blog_id = $(this).attr("blog_id");
		var modal = $(modal);
		if (blog_id)
			modal.attr('blog_id', blog_id);
		modal.modal("show");
	});
});
