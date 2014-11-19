<?php

class Controller extends \Phf\Mvc\Controller
{
	protected $view = null;

	public function initialize()
	{
		global $view;
		$this->view = $view;
	}

	public function emptyAction()
	{
		echo 'base Controller .';
	}

	public function isAjax()
	{
		if ($this->request->isAjax() || $this->request->get('format') === 'json')
			return true;
		return false;
	}

	public function ajaxReturn($data, $success = true)
	{
		$return = array();
		$return['ret'] = $success ? 1 : 0;
		if($success){
			if(is_string($data))
				$return['msg'] = $data;
			else if(is_array($data))
				$return['data'] = $data;
		}else{
			$return['msg'] = $data;
		}
		exit(json_encode($return));
	}

	public function error($output)
	{
		$this->ajaxReturn($output, false);
	}

	public function success($output)
	{
		$this->ajaxReturn($output);
	}
}
