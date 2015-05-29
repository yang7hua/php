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

	if (typeof cars == 'object')
	{
		var car_brand = {};
		$.each(cars, function(k, v){
			var ca = v.name.split(" ");
			var c = ca[0].toUpperCase();
			if (car_brand[c]) {
				car_brand[c].push(v);
			} else {
				car_brand[c] = [v];
			}
		});
		//车系
		function carBrandSelect()
		{
			var str = '<ul>';
			$.each(car_brand, function(k, v){
				str += "<li>";
				str += "<div class='car-brand-alpha pull-left'>"+k+"</div>";
				str += "<div class='car-brand-name pull-left'>";
				$.each(v, function(a, b){
					var name = b.name.split(" ")[1];
					str += "<span car-brand-alpha="+k+">"+name+"</span>";	
				});
				str += "</div>";
				str += "<div class='clear'></div>";
				str += "</li>";
			});
			str += "</ul>";
			return str;
		}

		function carTypeSelect(options)
		{
			var str = '';
			if (options)
			{
				$.each(options, function(a, b){
					str += "<li>"+b.showName+"</li>";
				});
			}
			return str;
		}

		function changeCarType(key)
		{
			$.each(cars, function(a, b){
				if (b.name == key) {
					var car_type = car_box.find(".car_type");
					car_type.find("ul").html(carTypeSelect(b.child));
					car_type.addClass("opened");
					return false;
				}
			});
		}

		function carBrandHtml(fieldname, value, carClass)
		{
			if (value == undefined)
				value = '';
			if (carClass == undefined)
				carClass = '';
			var str = "<div class='car_brand'>";
			str += "<input name='"+fieldname+"' value='"+value+"' class='form-control "+carClass+"' placeholder='品牌'/>";
			str += carBrandSelect();
			str += "</div>";
			return str;
		}

		function carTypeHtml(fieldname, value, carClass)
		{
			if (value == undefined)
				value = '';
			if (carClass == undefined)
				carClass = '';
			var str = "<div class='car_type'>";
			str += "<input name='"+fieldname+"' value='"+value+"' class='form-control "+carClass+"' placeholder='型号'/>";
			str += "<ul>";
			str += carTypeSelect();
			str += "</ul>";
			str += "</div>";
			return str;
		}
				
		var car_box = $("[cascaded-data=car]");
		car_box.each(function(){
			var fields = $(this).attr("cascaded-fields").split("#");
			var carBrandValue = $(this).attr(fields[0]),
				carTypeValue = $(this).attr(fields[1]),
				carClass = $(this).attr("car_class");
			var car_brand_html = carBrandHtml(fields[0], carBrandValue, carClass);			
			var car_type_html = carTypeHtml(fields[1], carTypeValue, carClass);
			var help_block_html = "<div class='col-lg-2 help-block'></div>";
			$(this).html(car_brand_html + car_type_html + help_block_html);
		});
		car_box.delegate("[name=car_brand]", "click", function(){
			var p = $(this).siblings("ul").parent();
			p.toggleClass("opened");
			if (p.hasClass("opened"))
				car_box.find(".car_type").removeClass("opened");
		})
		car_box.find("[name=car_type]").on("click", function(){
			$(this).closest(".car_type").toggleClass("opened");
		});
		car_box.find(".car_brand").delegate("ul li span", "click", function(){
			var alpha = $(this).attr("car-brand-alpha"),
				text = $(this).text();
			car_box.find("[name=car_brand]").val(text);
			$(this).closest(".car_brand").removeClass("opened");
			changeCarType(alpha + " " + text);
		})
		car_box.find(".car_type").delegate("ul li", "click", function(){
			car_box.find("[name=car_type]").val($(this).text());
			$(this).closest(".car_type").removeClass("opened");
		})
	}
});
