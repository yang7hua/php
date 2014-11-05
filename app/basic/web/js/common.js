var util;
$(function(){
util = {
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

	loadTheme : function(theme) {
		if ($("#themecss").size() < 1)
			$("body").append("<link rel='stylesheet' id='themecss' type='text/css'>");
		var themecss = $("#themecss"),
			href = "/css/themes/"+theme+".css";
		themecss.attr("href", href);
	},
	shake : function(o) {
			o.focus();
			o.addClass('input-empty');
			setTimeout(function(){
				o.removeClass('input-empty');
			}, 500);
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
	}
};
});


$(function(){

	$("img").lazyload({
		effect : "fadeIn" 
	});

	$(".flyout").flyout({
		outSpeed : 300,
		inSpeed : 200,
		closeTip : "点击关闭" 
	});	

	var searchInput = $("[type=search]");
	util.bindEnter(searchInput, function(){
		var keyword = searchInput.val();	
		if (keyword)
			location.href = '/search/' + keyword;
		else {
			util.shake(searchInput.parent());
		}
	});

	if ($("body").hasClass("show_welcome")) {
		$(window).scroll(function(){
			if ($("body").scrollTop() >= $(".welcome").height())
				$(".topbar").addClass("topbar_show");
			else
				$(".topbar").removeClass("topbar_show");
		})
	}

	if ($(".quickmenu").size() > 0) {
		var quick = $(".quickmenu"),
		colors = $(".quickmenu .colors");
		colors.on("click", function(){
			var color = $(this).attr("color");
			util.setCookie('themeColor', color, 24*30*12);
			util.loadTheme(util.getCookie('themeColor'));
		});
		
		var mini = quick.find(".mini"),
			open = false;
		mini.on("click", function(){
			var left = open ? -121 : 0;
			quick.animate({
				left : left
			}, 300);
			open = !open;
		})
	}
	/*
	var defaultTheme = util.getCookie('themeColor');
	if (defaultTheme)
		util.loadTheme(defaultTheme);
	*/
});
