<?php

class DepartmentController extends Controller
{
	public function listAction()
	{
		$departments = Department::all();
		$this->view->setVar('departments', $departments);
	}

	public function addAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->error('参数错误');
			$modelForm = new DepartmentForm();
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->add())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
		}
	}
}
