<?php

namespace Assert;

/**
 * 是否已经加载过静态资源, 避免重复加载
 */
function loadedStatic($file, $judge = true)
{
	static $statics = [];
	if (!$judge)
		array_push($statics, $file);
	else {
		if (in_array($file, $statics))
			return true;
		else {
			array_push($statics, $file);
			return false;
		}
	}
}

function getAssert($key)
{
	$assert = [
		'app'	=>	[
			'jsfiles'	=>	[
				'basedir'	=> null,
				'files'	=>	[
					'lib/jquery-1.11.1.min.js',
					'lib/bootstrap.min.js',
					'common.js'
				]
			]
		],

		'validate'	=>	[
			'jsfiles'	=>	[
				'basedir'	=> null,
				'files'	=>	[
					'lib/jquery.validate.min.js',
					'lib/messages_zh.js',
					'lib/jquery.form.js',
					'validate.js?v=2014121602'
				],
				'depends'	=>	'\Assert\app'
			]
		],
		//省份城市
		'address'	=>	[
			'jsfiles'	=>	[
				'basedir'	=>	null,
				'files'	=>	[
					//'data/bdist.js',
					'data/tdist.js',
					'cascaded.js'
				],
				'depends'	=>	'\Assert\app'
			]
		],
		//车系
		'cars'	=>	[
			'jsfiles'	=>	[
				'basedir'	=>	null,
				'files'	=>	[
					'data/cars.js',
					'cascaded.js'
				],
				'depends'	=>	'\Assert\app'
			]
		],
		'ajaxfileupload'	=>	[
			'jsfiles'	=>	[
				'basedir'	=>	null,
				'files'	=>	[
					'lib/ajaxFileUpload.js',
					'ajaxFileUploadForm.js'
				],
				'depends'	=>	'\Assert\app'
			]
		]
	];
	return $assert[$key];
}

function app()
{
	return register(getAssert('app'));
}

function validate()
{
	return register(getAssert('validate'));
}

function address()
{
	return register(getAssert('address'));
}

function cars()
{
	return register(getAssert('cars'));
}

function ajaxFileUpload()
{
	return register(getAssert('ajaxfileupload'));
}

function register($assert)
{
	$str = null;
	if (isset($assert['jsfiles'])) {
		$jsfiles = $assert['jsfiles'];
		if (is_array($jsfiles) and key_exists('files', $jsfiles)) {
			foreach ($jsfiles['files'] as $file) {
				$str .= \Func\loadJsFile($file, ['depends'=>$jsfiles['depends']], $jsfiles['basedir']);
			}
		}
	}
	return $str;
}

function output($str, $fresh = false)
{
	static $html = null;
	if ($str)
		$html .= $str;
	if ($fresh)
		echo $html;
}
