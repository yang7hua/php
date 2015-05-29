$(function(){

	function showNotSupport()
	{
		$("#notifycation-not-support").slideDown();
	}

	function closeNotify(id)
	{
		$.ajax({
			url	: "/public/notify/" + id,
			type : "post",
			dataType : "json",
			success : function(res) {
			}
		});
	}

	if (util.getCookie('notify') == null)
		util.setCookie('notify', '', 24);

	function showNotifycation(data)
	{
		var icon_url = "";
		for (var row in data) {
			var notify = data[row];

			var cookie = util.getCookie('notify'),
				id = ',' + notify.notification.id + ',';
			if (!cookie || cookie.indexOf(id) == -1) {
				console.log(cookie + id);
				util.setCookie('notify', cookie + id, 24);

				if (window.webkitNotifications) { 
					var notifycation = window.webkitNotifications.createNotification(icon_url, notify.title, notify.body); 
					notifycation.show();
				} else if (window.Notification) {
					var notifycation = new Notification(notify.title, {
						body : notify.body,
					});
				}
				notifycation.onclick = function(){
					closeNotify(notify.notification.id);
				}
				notifycation.onclose = function(){
					closeNotify(notify.notification.id);
				}
			}

		}
	}

	function getNotifications()
	{
		setInterval(function(){
			$.ajax({
				url : "/public/notify",
				type : "post",
				dataType : "json",
				success : function(res){
					if (res.ret > 0 && res.data) {
						showNotifycation(res.data);
					}
				}
			});
		}, 10000);	
	}

	if (("Notification" in window) || window.webkitNotifications) {
		if (Notification) {
			if (Notification.permission !== "granted")
				Notification.requestPermission();	
		} else if (webkitNotifications) {
			if (webkitNotifications.checkPermission() !== 0)
				window.webkitNotifications.requestPermission();
		}
		getNotifications();
	} else {
		showNotSupport();
	}
});
