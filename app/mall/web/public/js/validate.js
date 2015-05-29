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
			if (data['msg'])
				util.setCookie('msg', data['msg']);
			location.href = location.origin + data.redirect.url;
			return;
		}
		if (res.msg)
			util.setCookie('msg', res.msg);
		var paths = location.pathname.split('/');

		//贷款相关编辑后直接跳转到详情页面
		if (paths[1] == 'loan' && paths[2] == 'apply' && /^\d{6}$/.test(paths[3])) {
			var uid = paths[3];
			location.href = location.origin+ '/loan/detail/' + uid;
		} else if (/^\d{6}$/.test(paths[3]) && paths[4] == 'edit' && paths[1] == 'loan') {
			var uid = paths[3];
			location.href = location.origin+ '/loan/' + paths[2] + '/' + uid;
		} /*else if (/^\d{6}$/.test(paths[3]) && paths[2] == 'case' && paths[1] == 'rc') {
			location.href = location.origin+ '/rc/list/';
		}*/ else {
			location.reload();
		}
	}

	//表单提交
	$.validator.setDefaults({
			debug : true,
			ignore : ".ignore",
			submitHandler : function(form){
				var Form = $(form),
					btn = Form.find("[type=submit]");
				$(form).ajaxSubmit({
					beforeSubmit : function(){
						btn.addClass("disabled");		
					},
					success : function(res){
						btn.removeClass("disabled");	
						ajaxSubmitCallback(res);
					},
					timeout : 3000
				});
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

	$.validator.addMethod('date', function(value, element, param){
		var regex = new RegExp('^(20[\\d]{2}-[\\d]{1,2}-[\\d]{1,2})?$'); 
		return regex.test(value);
	}, "格式不正确");

	//表单验证
	$("body").delegate("form", "click", function(){
		var form = $(this),
			fields = form.find("[name]");
		if (fields.size() < 1)
			return;
		if (form.hasClass("search"))
			return;
		if (form.attr("init"))
			return;
		form.attr("init", 1);

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
