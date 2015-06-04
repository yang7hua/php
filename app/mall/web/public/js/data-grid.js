$(function(){

	var Grid = {
		grid : null,
		fields : null,
		src : null,
		data : null,
		selected : [],
		multi_select : false,
		dbclick : true,

		modal : {},

		init : function(grid) {
			this.grid = grid;
			this.src = this.grid.attr("src");
			this.get_fields();
			if (grid.attr("dbclick") == "false")
				this.dbclick = false;
			if (grid.attr("modal-edit"))
				this.modal["edit"] = $(grid.attr("modal-edit"));
			return this;
		},
		
		load : function(data, callback) {
			var o = this.grid;
			util.loading(o, true);	
			$.ajax({
				url : this.src,
				data : data,
				type : "post",
				dataType : "json",
				success : function(res) {
					util.loading(o, false);	
					if (typeof callback == "function") {
						callback(res);
					}
				}
			});
		},
		get_fields : function() {
			fields = this.grid.find("[field]");
			if (fields.size() < 1)
				return;
			var _fields = [];
			$.each(fields, function(k, field){
				var field = $(field),
					_field = field.attr("field");
				_fields[_field] = {
					"text" : field.text()
				};
				var format = field.attr("format");
				if (format)
					_fields[_field]["format"] = format;
			});
			this.fields = _fields;
			return this;
		},

		render_header : function() {
			var html = "<table class='table table-bordered table-striped'>";
			html += "<thead><tr>";
			var fields = this.fields;
			for (var i in this.fields) {
				html += "<th>"+fields[i].text+"</th>";
			};
			html += "</tr></thead>";
			return html;
		},
		render_footer : function() {
			return "</table>";	
		},

		output_grid : function(list) {
			this.grid.html("");
			var html = this.render_header();

			this.data = list;

			html += "<tbody>";
			var fields = this.fields;
			$.each(list, function(k, row) {
				html += "<tr row='"+k+"'>";
				for (var i in fields) {
					var field = fields[i];
					var v = row[i];
					if (row[i] == null)
						v = "";
					if (field["format"]) {
						v = eval("("+field["format"]+"("+v+"))");
					}
					html += "<td>"+v+"</td>";
				}
				html += "</tr>";
			});
			html += "</tbody>";
			html += this.render_footer();
			this.grid.append(html);
			return this;
		},

		output_page : function(page) {
			var html = "<ul class='pagination'>"
				+"<li class='disabled'><a href='#'>"+page.count+"条记录</a></li>";
			for (var p in page.list) {
				p = page.list[p];
				if (p == page.now)
					html += "<li class='active'>";
				else
					html += "<li>";
				html += "<a href='#' p="+p+">"+p+"</a>";
				html += "</li>";
			}
			html +="<li class='disabled'><a href='#'>"+page.now+"/"+page.total+"页</a></li>",
				+"</ul>";
			this.grid.append(html);
			return this;
		},

		select_row : function(row, select) {
			var selected = [];
			for (var i in this.selected) {
				if (this.selected[i] != row) {
					if (this.multi_select) {
						selected.push(this.selected[i]);
					} else {
						//取消选中
						this.grid.find("tbody tr").eq(this.selected[i]).removeClass("selected");
					}
				}
			}
			if (select && row != null) {
				selected.push(row);
			}
			this.selected = selected;
			return this;
		},

		edit : function(row) {
			var modal = this.modal.edit;
			if (modal == undefined) {
				return;
			}
			modal.find("form")[0].reset();
			var row = row || grid.selected[0];
			var data = grid.data[row];
			for (var i in data) {
				var f = modal.find("[name="+i+"]");
				if (f) {
					f.val(data[i]);
				}
			}
			modal.modal();
		}
	};

	var grid = Grid.init($(".data-grid"));

	function callback(res)
	{
		if (res["result"] < 1) {
			return;
		}
		if (res["data"]) {
			grid.output_grid(res["data"]["list"]).output_page(res["data"]["page"]);
		}
	}

	grid.load({}, function(res){
		callback(res);
	});

	//分页
	grid.grid.delegate("a[p]", "click", function() {
		var p = $(this).attr("p");
		grid.load({p:p}, function(res){
			callback(res);
		});
		return false;
	});

	//选中行
	if (grid.dbclick) {
		grid.grid.delegate("table tbody tr", "dblclick", function() {
			var row = $(this).attr("row");
			grid.edit(row);
		});
	}
	grid.grid.delegate("table tbody tr", "click", function() {
		$(this).toggleClass("selected");
		var flag = $(this).hasClass("selected");
		grid.select_row($(this).attr("row"), flag);
	});

	$("[data-action=edit]").on("click", function(){
		if (grid.selected.length > 1) {
			alert("最多同时编辑一行");
			return;
		}
		if (grid.selected.length < 1) {
			alert("请先选择要编辑的行");
			return;
		}
		grid.edit();
	});
	$("[data-action=add]").on("click", function(){
		var modal = $("#modal-edit");
		modal.find("[name]").each(function(){
			var type = $(this)[0]["tagName"].toLowerCase();
			if (type == "input" || type == "textarea" || type == "hidden")
				$(this).val("");
		});
		modal.modal();
	});
});
