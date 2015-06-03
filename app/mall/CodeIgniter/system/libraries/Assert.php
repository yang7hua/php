<?php
namespace CI\Lib;

class Assert
{
	private $assert;

	private $str;

	function __construct()
	{
		$this->assert = [
			'app'	=>	[
				'jsfiles'	=>	[
					'basedir'	=> null,
					'files'	=>	[
						'lib/jquery-1.11.1.min.js',
						'lib/bootstrap.min.js',
						'common.js?v=2015041101',
					]
				]
			],

			'datagrid'	=>	[
				'jsfiles'	=>	[
					'files'	=>	[
						'data-grid.js'
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
						'validate.js?v=201502040902'
					],
					'depends'	=>	'app'
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
					'depends'	=>	'app'
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
					'depends'	=>	'app'
				]
			],
			'ajaxfileupload'	=>	[
				'jsfiles'	=>	[
					'basedir'	=>	null,
					'files'	=>	[
						'lib/ajaxFileUpload.js',
						'ajaxFileUploadForm.js'
					],
					'depends'	=>	'app'
				]
			],
			'swfupload'	=>	[
				'jsfiles'	=>	[
					'basedir'	=>	null,
					'files'	=>	[
						'swfupload/fileprogress.js',
						'swfupload/swfupload.js',
						'swfupload.js'	
					],
					'depends'	=>	'app'
				]
			]
		];
	}

	function __call($method, $args = [])
	{
		$this->register($this->getAssert($method));
	}

	function getAssert($key)
	{
		return $this->assert[$key];
	}

	/**
	 * 是否已经加载过静态资源, 避免重复加载
	 */
	static function loadedStatic($file, $judge = true)
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

	function register($assert)
	{
		$_INS =& get_instance();
		$str = null;
		if (isset($assert['jsfiles'])) 
		{
			$jsfiles = $assert['jsfiles'];
			if (is_array($jsfiles) and key_exists('files', $jsfiles)) 
			{
				foreach ($jsfiles['files'] as $file) 
				{
					if (isset($jsfiles['depends']))
					{
						if (is_callable($jsfiles['depends']))
						{
							$str .= $jsfiles['depends']();
						}
						else 
						{
							$str .= $this->$jsfiles['depends']();
						}
					}
					$str .= $_INS->load->view->loadJsFile($file, true);
				}
			}
		}
		$this->str .= $str;
	}

	function output()
	{
		echo $this->str;
	}

}
