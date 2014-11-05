$(function(){
	var form = $("[name=comment]");
	var nickname = form.find("[name=nickname]"),
		content = form.find("[name=content]");

	var submit  = function(){
		if (!util.isCh(nickname.val())) {
			util.shake(nickname);
			return false;
		}
		if (!util.hasCh(content.val())) {
			util.shake(content);
			return false;
		}
		$.ajax({
			url : form.attr("action"),
			type : "post",
			dataType : "json",
			data : {
				id : form.find("[name=id]").val(),
				nickname : nickname.val(),
				content : content.val()
			},
			success : function(res){
				if (res.ret > 0) {
					append(res.info);
					nickname.val("");
					content.val("");
				} else {
					alert(res.msg);
				}
			}
		});
		return false;
	};

	//追加评论
	var tmpl = "<div class='list'><div class='nickname'><span class='time'>{time},</span> {nickname}:</div>"
			+ " <div class='content'><span class='arrow-left'></span>{content}</div>"
			+ "</div>",
		commentBox = $(".comment-list");
	var append = function(data) {
		var html = tmpl;
		html = html.replace('{time}', data.date);
		html = html.replace('{nickname}', data.nickname);
		html = html.replace('{content}', data.content);
		commentBox.append(html);
	};

	util.bindEnter(form, submit);

	$("[name=submit]").on("click", submit);
	content.on("focus", function(){
		$(this).addClass("more-heigh");
	})
});
