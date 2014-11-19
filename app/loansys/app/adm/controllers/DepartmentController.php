<?php

class DepartmentController extends Controller
{
	public function listAction()
	{
		$departments = Department::find();
		$this->view->setVar('departments', $departments);
	}

	public function addAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->error('参数错误');
			$this->ajaxReturn($data);
		}
	}
}
