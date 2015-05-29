<?php

class CI_View
{

	protected $_ci_view_paths = [VIEWPATH];

	protected $_ci_cached_vars = [];

	protected $_ci_ext = '.php';

	public function __construct()
	{
	}

	protected function layout($layout = 'index')
	{
		$flag = false;
		foreach ([VIEWPATH.'layout/'] as $path)
		{
			$view_file = $path.trim($layout,'/').$this->_ci_ext;
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
			$this->_ci_cached_vars[$key] = $value;
		}
		if (is_array($key))
		{
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $key);
		}
		return $this;
	}

	public function display($view = null, $vars = null, $return = false, $ext = '.php')
	{
		$_CI =& get_instance();

		foreach (get_object_vars($_CI) as $_ci_key=>$_ci_var)
		{
			if (!isset($this->$_ci_key))
			{
				$this->$_ci_key =& $_CI->$_ci_key;
			}
		}

		if (is_null($view))
		{
			$view = $_CI->get_controller() . '/' . $_CI->get_action();
		}

		$file_exists = false;
		foreach ($this->_ci_view_paths as $path)
		{
			$view_file = $path . $view . $this->_ci_ext;
			if (file_exists($view_file))
			{
				$file_exists = true;
				break;
			}
		}

		$buffer = $this->pick($view_file, $vars, $ext);

		if ($return)
		{
			return $buffer;
		}
		else
		{
			$_CI->output->append_output($buffer);
			if (is_ajax())
			{
				exit(json_encode($this->_ci_cached_vars));
			}
		}

		return $this;
	}

	public function pick($view = null, $vars = null, $ext = '.php')
	{
		file_exists($view) or show_error('Unable to load the requested file: '.$view);

		if (is_array($vars))
		{
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $vars);
		}
		extract($this->_ci_cached_vars);

		ob_start();

		include($view); // include() vs include_once() allows for multiple views with the same name

		log_message('info', 'File loaded: '.$view);

		$buffer = ob_get_contents();
		@ob_end_clean();

		if (preg_match('/{Layout(#([\w\/]+))?}/', $buffer, $matches))
		{
			$buffer = str_replace('{Layout#'.$matches[2].'}','',$buffer);
			$layout = $this->layout(strtolower($matches[2]));
			$buffer = str_replace('{Content}', $buffer, $layout);
		}
		if (preg_match('/{Include(#([\w\/]+))?}/', $buffer, $matches))
		{
			$include = $this->display($matches[2], [], true);
			$buffer = str_replace('{Include#'.$matches[2].'}', $include, $buffer);
		}

		return $buffer;
	}


}
