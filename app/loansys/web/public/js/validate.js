$(function(){
	
	function analyseFieldValidator(obj)
	{
		var _class = obj.attr("class");
		if (!_class)
			return;
		var sepStart = _class.indexOf('{'),
			sepEnd = _class.indexOf('}');
		if (sepStart == -1 || sepEnd == -1)
			return;
		var validator_str = _class.substr(sepStart, sepEnd);
		return validator_str;
	}

	function getFieldName(obj)
	{
		return obj.attr("name") || null;
	}

	function ajaxSubmitCallback(res)
	{
		console.log(res);
	}

	$.validator.setDefaults({
			debug : true,
			ignore : ".ignore",
			submitHandler : function(form){
				$(form).ajaxSubmit(ajaxSubmitCallback);
				return false;
			},
			errorPlacement : function(error, element) {
				error.appendTo(element.parent().find(".help-block"));
			}
	});

	//表单验证
	$("form").each(function(){
		var form = $(this),
			fields = form.find("[name]");
		if (fields.size() < 1)
			return;

		var rules = {};
		fields.each(function(){
			var $this = $(this);
			var name = getFieldName($this),
				validator_str = analyseFieldValidator($this);
			if (name && validator_str) {
				rules[name] = eval('('+validator_str+')');
			}
		});	
		form.validate({
			rules : rules,
		});
	});
});
