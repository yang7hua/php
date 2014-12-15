<?php

return [
	'enablePrettyUrl'	=>	true,
	'showScriptName'	=>	false,
	'rules'	=>	[
		//博客详情
		'/blog/<id:\d+>'	=>	'/blog/detail',
		
		//搜索
		'/search/<keyword:[^/]+>'	=>	'/search/search',

		//标签
		'/tag/<tag:[^/]+>'	=>	'/tag/tag',

		//分类
		'/topic/<topic:[\w]+>'	=>	'/blog/topic',

		//分类列表分页
		'/topic/<topic:[\w]+>/<page:[\d]+>'	=>	'/blog/topic',

		//用户中心
		'/user/'	=>	'/user/user/index',
		'/user/<action:(login|reg|logout)>'	=>	'/user/user/<action>',
		'/user/site/<code:[a-z]+>'	=>	'/user/site',
		'/user/site/<code:[a-z]+>/<do:[a-z]+>'	=>	'/user/site',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<do:[a-z]+>'	=>	'/user/<controller>/<action>',
		'/user/<controller:[a-z]+>/<action:[a-z]+>/<id:\d+>'	=>	'/user/<controller>/<action>'
	]
];
