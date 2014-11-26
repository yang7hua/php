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
		var city = province[pid].city;
		if (city)
			city[0] = {name:'请选择'};
		return city;
	}

	function selectHtml(fieldname, options, selected)
	{
		var str = "<select name='"+fieldname+"' class='form-control'>";
		str += optionsHtml(options, selected);
		str += "</select>";

		return str;
	}

	function provinceHtml(fieldname, selected)
	{
		province[0] = {'name':'请选择'};
		return selectHtml(fieldname, province, selected);
	}

	function cityHtml(fieldname, pid, selected)
	{
		var city = [];
		city[0]	=	{name:"请选择"};
		if (pid)
			city = loadCity(pid);
		return selectHtml(fieldname, city, selected);
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
		var _province = $(this).attr("address-province") || 0,
			_city = $(this).attr("address-city") || 0;

		var province_select = provinceHtml(fields[0], _province);	
		var city_select = cityHtml(fields[1], _province, _city);
		$(this).html(province_select + city_select);
	});	

	$("[cascaded-data=address]").delegate("[name=province],[name=idcard_province]", "change", function(){
		var pid = $(this).val();
		$(this).siblings("select").html(optionsHtml(loadCity(pid)));
	});

	//$("[name=province], [name=idcard_province]").change();

	$("[address-format=province]").each(function(){
		var province_id = parseInt($(this).text()),
			province_text = "";
		if (province_id == 0)
			province_text = "--";	
		else
			province_text = province[province_id].name;

		$(this).text(province_text);
	});
	$("[address-format=city]").each(function(){
		var city_id = parseInt($(this).text()),
			city_text = "";
		if (city_id == 0)
			city_text = "--";	
		else {
			var province_id = $(this).attr("address-province");
			var citys = loadCity(province_id);
			city_text = citys[city_id].name;
		}

		$(this).text(city_text);
	});
});
