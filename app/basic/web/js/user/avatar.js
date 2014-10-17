function jcrop(obj, size ,options){
	var $this = this,
		jcrop = null,
		thumbs = null;
	//原始图片的宽高 
	this.size = size; 
	//需要压缩的图片宽高
	this.thumbSize = null;
	//裁剪宽高
	this.coords = null;

	//图片宽高、box宽高
	this.resizeImage = function(imgW, imgH, boxW, boxH, fullbox){
		var boxScale = boxW/boxH;
		var imgScale = imgW/imgH;
		var width = 0;
		var height = 0;
		if (imgScale >= 1) {
			if (fullbox) {
				height = boxH;
				width = height*imgScale;
			} else {
				width = boxW;	
				height = width/imgScale;
			}
		} else {
			if (fullbox) {
				width = boxW;
				height = width/imgScale;
			} else {
				height = boxH;
				width = height*imgScale;
			}
		}
		return {
			width : width,
			height : height,
			scale : imgScale 
		};
	}
	changeImgSize = function(coords){
		//缩放比率
		var scaleW = coords.w / this.thumbSize.width,
			scaleH = coords.h / this.thumbSize.height,
		//移动比例
			scaleLeft = coords.x / this.thumbSize.width,
			scaleTop = coords.y / this.thumbSize.height;
		this.thumbs.each(function(){
			var thumb = $(this),
				img = thumb.find("img"),
				boxW = thumb.width(),
				boxH = thumb.height();
			var imgW = boxW / scaleW,
				imgH = boxH / scaleH,
				imgLeft = boxW * scaleLeft,
				imgTop = boxH * scaleTop;
			img.css({
				width : imgW,
				height : imgH,
				left : -imgLeft,
				top : -imgTop
			});
		});
	}
	//初始化图片尺寸
	setOriginSize = function(obj, fullbox, mainimg){
		obj.each(function(){
			var box = $(this),
				img = box.find("img"),
				wh = null;

			if (mainimg) {
				wh = resizeImage($this.size.width, $this.size.height, box.width(), box.height(), fullbox);
				$this.thumbSize = wh;
			} else
				wh = resizeImage(img.width(), img.height(), box.width(), box.height(), fullbox);
			img.css({
				width : wh.width,
				height : wh.height
			});
		});
	}

	init = function(){
		this.jcrop = $(obj);
		this.thumbs = $(".thumb");
		//主图
		this.setOriginSize(this.jcrop, false, true);
		//裁剪图
		this.setOriginSize(this.thumbs, true);

		var jcropOptions = {
			aspectRatio : 1,
			minSize : [180, 180],
			setSelect : [0, 0, 180, 180],
			onSelect : function(e){
				
			},
			onChange : function(e){
				changeImgSize(e);
			}
		};
		if (typeof options == 'object')
			$.extend(jcropOptions, options);
		this.jcrop.find("img").Jcrop(jcropOptions);
	}

	init();

	return this;
}

$(function(){
	var jcrop1 = null;
	$("[type=file]").on("change", function(){
		var $this = $(this);
		var url = $this.parents('form').attr('action');
		$.ajaxFileUpload({
			url : url,
			fileElementId : $this.attr('id'),
			dataType : 'json',
			type : 'post',
			success : function(res){
				$("#jcrop-image, .thumb img").attr('src', res.avatar);
				$("[name=avatar]").val(res.avatar);
				jcrop1 = jcrop($('#jcrop'), {width:res.width, height:res.height}, {
					onSelect : function(e){
						$("[name=coords]").val(e.w + ',' + e.h + ',' + e.x + ',' + e.y);
					}
				});
			}
		});
		return false;
	});
	$("#saveAvatar").on("click", function(){
		var avatar = $("[name=avatar]").val(),
			coords = $("[name=coords]").val(),
			width  = jcrop1.thumbSize.width,
			height = jcrop1.thumbSize.height;
		$.ajax({
			url : "/user/profile/avatar/save",
			type : "post",
			dataType : "json",
			data : {
				avatar : avatar,
				coords : coords,
				width : width,
				height : height
			}, 
			success : function(res){
				if (res.ret)
					location.href = '/user/profile/info';
				else
					alert(res.msg);
			}
		});
		return false;
	});
});
