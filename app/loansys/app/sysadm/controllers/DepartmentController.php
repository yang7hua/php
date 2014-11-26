<?php

class DepartmentController extends Controller
{

	public static function actions()
	{	
		return [
			'list'	=>	['list' => '部门列表'],
			'opera'	=>	['add' => '添加部门', 'edit' => '修改部门', 'del' => '删除部门']
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
		$this->view->setVars([
			'formparams'	=>	[
			'event'	=>	'add',
			'action'	=>	\Func\url('department/add')
			]
		]);
	}

	public function editAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new DepartmentForm('edit');
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->edit())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
		}

		$oid = $this->dispatcher->getParams()[0];
		if (empty($oid))
			$this->pageError('param');
		$operator = Department::findById($oid);
		if (!$operator)
			$this->pageError('param');

		$form = new DepartmentForm('edit', $operator);
		$this->view->setVars([
				'formparams'	=>	[
					'event'	=>	'edit',
					'action'	=>	\Func\url('/department/edit')	
				],
				'data'	=>	$operator
			]);
		$this->view->pick('department/add');
	}
}
