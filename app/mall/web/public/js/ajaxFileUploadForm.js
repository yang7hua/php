$(function(){
	function upload(url, fileElementId, filename, callback) 
	{
		$.ajaxFileUpload({
			url : url,
			fileElementId : fileElementId,
			type : "post",
			dataType : "json",
			data : {
				filename : filename
			},
			success : function(res) {
				if (typeof callback == 'function')
					callback(res);

				if (res.ret < 1) {
					alert(res.msg);	
					return;
				}
			},
			error: function (data, status, e) {//服务器响应失败处理函数 {
				alert(e);
			}
		});
		return false;
	}
	$(".btn-fileupload").each(function(){
		var url = $(this).attr("fileupload-url"),
			fileElementId = $(this).attr("fileupload-elementid"),
			filename = $(this).attr("fileupload-filename"),
			hiddeninput = $(this).attr("fileupload-hiddeninput"),
			trigger = $(this).attr("fileupload-trigger"),
			_alert = $(this).attr("fileupload-alert"),
			reload = $(this).attr("fileupload-reload");

		function func()
		{
			if (!filename)
				filename = "filename";

			upload(url, fileElementId, filename, function(res){
				if (res.ret < 1) {
					alert(res.msg);
					return false;
				}
				if (hiddeninput) {
					$("[name="+hiddeninput+"]").val(res.data.filename);
				}
				if (_alert) {
					alert('上传成功');
				}
				if (reload) {
					location.reload();
				}
			});
			return false;
		}
		if (trigger && trigger == 'change')
			$(this).on("change", func)
		else	
			$(this).on("click", func)
	});
});
