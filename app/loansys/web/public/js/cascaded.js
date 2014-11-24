$(function(){

	var province = [];

	$.each(tdist, function(k, v){
		if (v[1] == 1) {
			province[k]	= {name:v[0], city:[]};
		} else {
			if (province[v[1]])
				province[v[1]].city[k] = {name:v[0]};
		}
	})

	function loadCity(pid)
	{
		return province[pid].city;
	}

	function selectHtml(fieldname, options, selected)
	{
		var str = "<select name='"+fieldname+"' class='form-control'>";
		str += optionsHtml(options, selected);
		str += "</select>";

		return str;
	}

	function provinceHtml(fieldname)
	{
		return selectHtml(fieldname, province);
	}

	function cityHtml(fieldname, pid)
	{
		var city = [];
		city[0]	=	{name:"请选择"};
		if (pid)
			city = loadCity(pid);
		return selectHtml(fieldname, city);
	}

	function optionsHtml(options, selected)
	{
		var str = '';
		for (var i in options) {
			var selected_html = selected == i ? 'selected' : '';
			str += "<option value="+i+" "+selected_html+">"+options[i].name+"</option>";
		}
		return str;
	}

	$("[cascaded-data=address]").each(function(){
		var fields = $(this).attr("cascaded-fields").split("#");
		var province_select = provinceHtml(fields[0]);	
		var city_select = cityHtml(fields[1]);
		$(this).html(province_select + city_select);
	});	

	$("[cascaded-data=address]").delegate("[name=province],[name=idcard_province]", "change", function(){
		var pid = $(this).val();
		$(this).siblings("select").html(optionsHtml(loadCity(pid)));
	});

	$("[name=province], [name=idcard_province]").change();
});
