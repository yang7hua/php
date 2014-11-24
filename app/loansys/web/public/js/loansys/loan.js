$(function(){
	var marriageInfo = $("#marriageInfo"),
		validateMarriageinfo = false;

	$("[name=marriage]").on("click", function(){
		if ($(this).val() == 1) {
			marriageInfo.removeClass("hide");
			validateMarriageinfo = true;
		} else {
			marriageInfo.addClass("hide");
			validateMarriageinfo = false;
		}
	});
});
