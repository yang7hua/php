var util = {
	moreheigh : function(box, low) {
		if (low)
			box.attr("more-heigh", false);
		else
			box.attr("more-heigh", true);
	},
	shake : function(o) {
			o.focus();
			o.addClass('input-empty');
			setTimeout(function(){
				o.removeClass('input-empty');
			}, 500);
	},
	reloadCaptcha : function(obj) {
		var src = obj && obj.attr("src") || '/site/captcha';
		src = src.split('?')[0];
		src += "?v=" + Math.random();	
		if (typeof obj == 'object')
			obj.attr("src", src);
		else
			$(".captcha").attr("src", src);
	},
	bindEnter : function(o, callback) {
		o.keydown(function(e){
			if (e.keyCode == 13) {
				if (typeof callback == 'function')
					callback();
			}
		});
	},
	isCh : function(string) {
		return string.match(/^[\u4e00-\u9fa5]+$/);
	},
	hasCh : function(string) {
		return string.match(/[\u4e00-\u9fa5]+/);
	},

	setCookie: function (name,value,exp,path,domain) {
        var exp = exp || 0;
        var et = new Date();
        if ( exp != 0 ) {
            et.setTime(et.getTime() + exp*3600000);
        } else {
            et.setHours(23); et.setMinutes(59); et.setSeconds(59); et.setMilliseconds(999);
        }
        var more = "";
        var path = path || "/";
        var domain = domain || "";
        if (domain != "")
            more += "; domain="+domain;
        more += "; path="+path;
        document.cookie = name + "=" + escape(value) + more + "; expires=" + et.toGMTString();
    },

    getCookie: function (name) {
        var res = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
        return null != res ? unescape(res[2]) : null;
    },

    delCookie: function(name) {
        var value = this.getCookie(name);
        if (null != value) { this.setCookie(name,value,-9); }
    },

	tips : {
		success : function(msg) {
			$("#tips-msg").addClass("tips-msg").html(msg);	
		},
		error : function(msg) {
			$("#tips-msg").addClass("tips-msg tips-msg-error").html(msg);
		}
	},

	template : function(template_id, data, o) {
		var html = $("#"+template_id).html(),
			fields = html.match(/{[a-zA-Z_]+}/g);
		if (fields && fields.length > 1) {
			for (var i in fields) {
				field = fields[i].slice(1,-1);
				html = html.replace(fields[i], data[field]);
			}
			o.html(html);
		}
	}
};

$(function(){

	$("[type=checkbox]").on("click", function(){
		if ($(this).attr("checked"))
			util.form.checkbox.check($(this), false);
		else
			util.form.checkbox.check($(this));
	});

	var form = {
		checkbox : {
			check : function(obj, checked)
			{
				if (checked == undefined)
					checked = true;
				if (checked)
					obj.attr("checked", true);
				else
					obj.removeAttr("checked");
			},
			isChecked : function(obj) {
				return obj.attr("checked") ? true : false;
			}
		},
	};


	$.extend(util, {form : form});

	$("textarea").on("focus", function(){
		util.moreheigh($(this));
	})
	$("textarea").on("blur", function(){
		util.moreheigh($(this), true);
	})

	$('.collapse').collapse();

	$(".search").each(function(){
		var form = $(this),
			_btn = form.find(".btn-search");
		_btn.on("click", function(){
			form.submit();
		})
	});

	//disabled
	$(".disabled").find("input").each(function(){
		$(this).attr("disabled", true);
	});

	$(".captcha").on("click", function(){
		util.reloadCaptcha($(this));
	});

	//msg tips
	if (util.getCookie('msg'))
	{
		if ($("#tips-msg").size() > 0)
		{
			util.tips.success(util.getCookie('msg'));
		}
		util.delCookie('msg');
	}

	$("[ajax=true]").each(function(){
		var $this = $(this);
		$this.on("click", function(){
			var action = $this.attr("ajax-action"),
				data = {};
			if (!action)
				return false;
			var ajax_data = $this.attr("ajax-data");
			if (ajax_data) {
				$.extend(data, {data:ajax_data});
			}
			$.ajax({
				url : action,
				dataType : "json",
				type : "post",
				data : data,
				success : function(res) {
					if (res.ret < 1) {
						alert(res.msg);
						return false;
					}
					var modal = $this.attr("ajax-modal");
					if (modal) {
						$("#modal-content").html(res.data.html);
						$(modal).modal();
					} else {
						location.reload();
					}
				}
			});
			return false;
		})
	});

	//uid查询客户资料
	var modal_user_info = $("#modal_user_info");
	if (modal_user_info.size() == 1) {
		$("[uid]").on("click", function(){
			var uid = $(this).attr("uid");
			if (!uid)
				return false;
			$.ajax({
				url : "/json/uinfo/"+uid,
				dataType : "json",
				type : "post",
				success : function(res) {
					if (res.ret < 1) {
						alert(res.msg);
						return;
					}
					util.template("template_user_info", res.data, modal_user_info.find(".modal-body"));
					modal_user_info.modal();
				}
			});
		});
	}

	function selectHtml(data)
	{
		var html = "";
		$.each(data, function(k, v){
			html += "<option value="+k+">"+v+"</option>";
		});
		return html;
	}

	//级联
	$("[select-cascade=true]").each(function(){
		var $this = $(this),
			url = $this.attr("select-cascade-url"),
			target = $this.attr("select-cascade-target");
		if (!url)
			return;
		if (!target)
			return;

		$this.on("change", function(){
			$.ajax({
				url : url,
				type : "post",
				dataType : "json",
				data : {
					value : $this.val()
				},
				success : function(res) {
					if (res.ret > 0) {
						$(target).html(selectHtml(res.data));
					}
				}

			});
		})
	});

	if (typeof(datetimepicker) != 'undefined') {
		$(".datepicker").datetimepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			minView:2
		});
	}

	var frame_box_header = $("#frame-box-header"),
		frame_box_body = $("#frame-box-body");
	function create_iframe(id, src, name)
	{
		if ($(".iframe[iframe-id="+id+"]").size() < 1)
		{
			frame_box_body.append("<iframe class='iframe' iframe-id='"+id+"' src='"+src+"'></iframe>");
			frame_box_header.append("<span class='iframe-title' iframe-id='"+id+"'>"+name+"</span>");
		}
		activie_iframe(id);
	}
	function activie_iframe(id)
	{
		$(".iframe").hide();
		frame_box_body.find(".iframe[iframe-id="+id+"]").show();
		$(".iframe-title").removeClass("iframe-title-active");
		frame_box_header.find(".iframe-title[iframe-id="+id+"]").addClass("iframe-title-active");
	}

	var sysadm_menu = $("#sysadm-menu");
	if (sysadm_menu.size() > 0) {
		frame_box_header.delegate("span.iframe-title", "click", function(){
			activie_iframe($(this).attr("iframe-id"));
		})
		$(".node").on("click", function(){
			var $this = $(this),
				href = $this.attr("href"),
				controller = $this.attr("controller"),
				action = $this.attr("action"),
				name = $this.attr("name");
			var iframe = "iframe-"+controller+"-"+action;
			create_iframe(iframe, href, name);
			return false;
		});
	}

});
