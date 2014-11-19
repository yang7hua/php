<?php

class RoleController extends Controller
{
	public function listAction()
	{
		$roles = Role::all();
		$this->view->setVar('roles', $roles);
	}

	public function addAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->error('参数错误');
			$modelForm = new RoleForm();
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
