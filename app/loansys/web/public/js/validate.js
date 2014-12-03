$(function(){
	
	function analyseFieldValidator(obj)
	{
		var _class = obj.attr("class");
		if (!_class)
			return;
		var sepStart = _class.indexOf('{'),
			sepEnd = _class.lastIndexOf('}');
		if (sepStart == -1 || sepEnd == -1)
			return;
		var validator_str = _class.substr(sepStart, sepEnd);
		//console.log(validator_str);
		return validator_str;
	}

	function getFieldName(obj)
	{
		return obj.attr("name") || null;
	}

	function ajaxSubmitCallback(res)
	{
		res = eval('(' + res + ')');
		if (res['ret'] < 1) {
			alert(res['msg']);
			util.reloadCaptcha();
			return;
		}
		var data = res['data'];
		if (data && data['redirect']) {
			if (data['redirect']['seconds']) {
				setTimeout(function(){
					location.href = data.redirect.url;
				}, data.redirect.seconds * 1000);
				return;
			}
			location.href = data.redirect.url;
		}
		location.reload();
	}

	$.validator.setDefaults({
			debug : true,
			ignore : ".ignore",
			submitHandler : function(form){
				$(form).ajaxSubmit(ajaxSubmitCallback);
				return false;
			},
			errorPlacement : function(error, element) {
				error.appendTo(element.parents('.form-group').find(".help-block"));
			}
	});

	$.validator.addMethod('regex', function(value, element, param){
		//var regex = new RegExp(param); 
		var regex = new RegExp(param);
		
		return regex.test(value);
	}, "格式不正确");

	$.validator.addMethod('ch', function(value, element, param){
		return util.isCh(value); 
	}, "必须为中文");

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
