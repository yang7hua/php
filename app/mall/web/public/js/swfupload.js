var swfu = null,
	swfu_setting = {
		upload_url	:	upload_url,
		flash_url	:	'/public/js/swfupload/swfupload.swf',
		file_upload_limit	:	file_upload_limit,
		file_types	:	file_types,
		file_post_name	:	'file',
		upload_target	:	'upload-progress',
		button_placeholder_id	:	'btn-upload',
		button_width	:	70,
		button_height	:	22,
		button_cursor	:	SWFUpload.CURSOR.HAND,
		button_text	:	'选择文件',
		button_window_mode	:	SWFUpload.WINDOW_MODE.TRANSPARENT,
		file_dialog_complete_handler :	file_dialog_complete_handler,
		upload_start_handler	:	upload_start_handler,
		upload_error_handler	:	upload_error_handler,
		upload_success_handler	:	upload_success_handler,
		upload_progress_handler	:	upload_progress_handler,
		upload_complete_handler	:	upload_complete_handler,
		custom_settings	:	{
			icoWaiting_css	:	'upload-progress-icowaiting',
			fname_css	:	'upload-progress-filename',
			state_div_css	:	'upload-progress-state-div',
			state_bar_css	:	'upload-progress-state-bar',
			percent_css	:	'upload-progress-percent',
			href_delete_css	:	'upload-progress-delete',
		}
	};
	if (typeof swfu_setting_extend == 'object') {
		$.extend(swfu_setting, swfu_setting_extend);
	}
function file_dialog_complete_handler(numFilesSelected, numFilesQueued)
{
	try {
		if (numFilesSelected > 0)
			swfu.startUpload();
	} catch (ex) {
		this.debug(ex);
	}
}
function upload_progress_handler(file, bytesLoaded, bytesTotal)
{
	//console.log(file, bytesLoaded, bytesTotal);
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		var progress = new FileProgress(file,  this.settings.upload_target);
		progress.setProgress(percent);
		if (percent == 100) {
			//progress.toggleCancel(false, this);
			uploadNum++;
			setUploadNumber(uploadNum);
			progress.setStatus("上传成功");
			progress.toggleCancel(true, this);
		} else {
			progress.setStatus("正在上传中，已完成"+percent+"%");
			progress.toggleCancel(true, this);
		}
	} catch (ex) {
		this.debug(ex);
	}
}
function upload_complete_handler(file)
{
	this.startUpload();
}
function upload_start_handler(file)
{
}
function upload_error_handler(file, error, message)
{
	alert(message);
}
function upload_success_handler(file, server, response)
{
	if (server) {
		server = JSON.parse(server);
		if (server.ret < 1) {
			alert(server.msg);
		}
	}
}

swfu = new SWFUpload(swfu_setting);
