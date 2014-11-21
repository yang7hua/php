<?php

class DepartmentController extends Controller
{

	public static function actions()
	{	
		return [
			'list'	=>	['list'],
			'opera'	=>	['add', 'edit', 'del']
		];
	}	

	public static function authorities()
	{
		return [
			'department'	=>	[
				'name'	=>	'部门管理',
				'authorities'	=>	[
					'list'	=>	'查看',
					'opera'	=>	'操作'
				]
			]
		];
	}

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
