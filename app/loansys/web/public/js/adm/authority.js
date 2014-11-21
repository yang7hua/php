$(function(){
	var form = $("form"),
		action = form.attr("action");
		type = form.find("[name=type]").val(),
		id = form.find("[name=id]").val();
	form.on("submit", function(){
		var auth = getAuthorities();
		$.ajax({
			url : action,
			type : "post",
			dataType : "json",
			data : {
				type : type,
				id : id,
				auth : auth
			},
			success : function(res) {
				console.log(res);
			}
		});
		return false;
	})

	/*
	$("[type=submit]").on("click", function(){
		var auth = getAuthorities();
		console.log(auth);
	})
	*/

	$("[name=app]").on("click", function(){
		var _app = $(this).val();
		var checked = util.form.checkbox.isChecked($(this));
		checkControllers(_app, checked);
	})

	function checkControllers(_app, checked)
	{
		if (checked == undefined)
			checked = true;
		var _objs = $("[name=controller][app="+_app+"]");
		if (_objs.size() < 1)
			return;
		_objs.each(function(){
			var _checked = util.form.checkbox.isChecked($(this));
			if ( (checked && !_checked)
					|| (!checked && _checked) 
			) {
				$(this).click();
			}
		});
	}

	$("[name=controller]").on("click", function(){
		var _app = $(this).attr("app"),
			_controller = $(this).val(),
			_checked = util.form.checkbox.isChecked($(this)),
			_objs = $("[app="+_app+"][controller="+_controller+"][name=action]");
		if (_objs.size() < 1)
			return;
		_objs.each(function(){
			var c = util.form.checkbox.isChecked($(this));
			if ( (_checked && !c) 
				|| (!_checked && c)
			) {
				$(this).click();
			}
		});
	});

	//获取最终权限字符串
	function getAuthorities()
	{
		//var _apps = getApps();
		var _actions = getCheckedActions();
		if (_actions.size() < 1)
			return null;
		return analyseActions(_actions);
	}

	function analyseActions(actions)
	{
		var _actions = {};
		actions.each(function(){
			var $this = $(this),
				_app = $this.attr("app"),
				_controller = $this.attr("controller"),
				_action = $this.val();
			if (!_actions[_app])
				_actions[_app] = {};
			if (!_actions[_app][_controller])
				_actions[_app][_controller] = [];
			_actions[_app][_controller].push(_action);
		});
		return JSON.stringify(_actions);
	}

	function getCheckedActions()
	{
		return form.find("[name=action]:checked");
	}
	
	function getApps()
	{
		var apps = form.find("[name=app]"),
			_apps = [];
		apps.each(function(){
			_apps.push($(this).val());
		});
		return _apps;
	}
});
