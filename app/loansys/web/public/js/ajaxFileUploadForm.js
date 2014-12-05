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
			}
		});
	}
	$(".btn-fileupload").each(function(){
		var url = $(this).attr("fileupload-url"),
			fileElementId = $(this).attr("fileupload-elementid"),
			filename = $(this).attr("fileupload-filename"),
			hiddeninput = $(this).attr("fileupload-hiddeninput"),
			trigger = $(this).attr("fileupload-trigger");

		function func()
		{
			if (!filename)
				filename = "filename";

			upload(url, fileElementId, filename, function(res){
				if (res.ret < 1) {
					alert(res.msg);
					return false;
				}
				if (hiddeninput)
				{
					$("[name="+hiddeninput+"]").val(res.data.filename);
				}
			});
		}
		if (trigger && trigger == 'change')
			$(this).on("change", func)
		else	
			$(this).on("click", func)
	});
});
