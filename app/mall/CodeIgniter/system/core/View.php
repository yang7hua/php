<?php

namespace CI\Core;

class View
{

	protected $_view_paths = [VIEWPATH];

	protected $_cached_vars = [];

	protected $_ext = '.php';

	##模板常量替换
	protected $_parse_strs = [];

	public function __construct()
	{
		$this->parse_strs = config_item('parse_strs');
	}

	protected function layout($layout = 'index')
	{
		$flag = false;
		foreach ([VIEWPATH.'layout/'] as $path)
		{
			$view_file = $path.trim($layout,'/').$this->_ext;
			if (file_exists($view_file))
			{
				$flag = true;
				break;
			}
		}
		$flag or show_error('Unable to load the requested file: '.$view_file);

		$buffer = $this->pick($view_file);
		return $buffer;
	}

	public function assign($key, $value = null) 
	{
		if (is_string($key))
		{
			if (is_null($value))
			{
				show_error('Assign argument 2 must be define.');
			}
			$this->_cached_vars[$key] = $value;
		}
		if (is_array($key))
		{
			$this->_cached_vars = array_merge($this->_cached_vars, $key);
		}
		return $this;
	}

	public function display($view = null, $vars = null, $return = false)
	{
		$_INS =& get_instance();

		foreach (get_object_vars($_INS) as $_key=>$_var)
		{
			if (!isset($this->$_key))
			{
				$this->$_key =& $_INS->$_key;
			}
		}

		if (is_null($view))
		{
			$view = $_INS->get_controller() . '/' . $_INS->get_action();
		}

		$file_exists = false;
		foreach ($this->_view_paths as $path)
		{
			$view_file = $path . $view . $this->_ext;
			if (file_exists($view_file))
			{
				$file_exists = true;
				break;
			}
		}

		$buffer = $this->pick($view_file, $vars);

		if ($return)
		{
			return $buffer;
		}
		else
		{
			$_INS->output->append_output($buffer);
			if (is_ajax())
			{
				exit(json_encode($this->_cached_vars));
			}
		}

		return $this;
	}

	public function pick($file = null, $vars = null)
	{
		file_exists($file) or show_error('Unable to load the requested file: '.$file);

		if (is_array($vars))
		{
			$this->_cached_vars = array_merge($this->_cached_vars, $vars);
		}
		extract($this->_cached_vars);

		ob_start();

		include($file); // include() vs include_once() allows for multiple views with the same name

		log_message('info', 'File loaded: '.$file);

		$buffer = ob_get_contents();
		@ob_end_clean();

		##layout
		if (preg_match('/{Layout(#([\w\/]+))?}/', $buffer, $matches))
		{
			$buffer = str_replace('{Layout#'.$matches[2].'}','',$buffer);
			$layout = $this->layout(strtolower($matches[2]));
			$buffer = str_replace('{Content}', $buffer, $layout);
		}
		##include
		if (preg_match('/{Include(#([\w\/]+))?}/', $buffer, $matches))
		{
			$include = $this->display($matches[2], [], true);
			$buffer = str_replace('{Include#'.$matches[2].'}', $include, $buffer);
		}
		$buffer = str_replace(array_keys($this->parse_strs), array_values($this->parse_strs), $buffer);

		return $buffer;
	}

	/**
	 * 加载js文件到assert中
	 * @fresh: true则直接返回
	 */
	function loadJsFile($filename, $fresh = false)
	{
		$str = null;
		static $loaded = [];

		if ($filename) 
		{
			if (strpos($filename, '.') === false)
				$filename .= '.js';

			$file = _PUBLIC . '/js/' . $filename;
			if ($loaded and isset($loaded[$file]))	
				return;
			$str .= '<script type="text/javascript" src="' . $file . '"></script>';
			$loaded[$file] = true;
		}

		if ($fresh)
			return $str;
		echo $str;
	}

}
