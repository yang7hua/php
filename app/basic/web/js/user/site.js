$(function(){
	$(".modals").on("click", function(){
		var modal = $(this).attr("modal");
		if (!modal)
			return false;
		modal = $(modal);
		modal.modal("show");
	});
});
