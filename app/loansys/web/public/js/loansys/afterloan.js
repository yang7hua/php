$(function(){
	$("a.repay").on("click", function(){
		var $this = $(this),
			modal = $(".modal#repay"),
			repayNo = $this.attr("repay-no"),
			repayAmount = $this.attr("repay-amount"),
			repayId = $this.attr("repay-id");
		modal.find("[name=id]").val(repayId);
		modal.find("[name=amount]").val(repayAmount);
		modal.find("[name=no]").val(repayNo);
		modal.find("#repay-no").text(repayNo);
		modal.modal();
	});
});
