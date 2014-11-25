<?php

class RoleController extends Controller
{

	public static function actions()
	{
		return [
			'see'	=>	['list'=>'角色列表'],
			'opera'	=>	['add'	=>	'添加角色', 'edit' => '修改角色']
		];
	}

	public static function authorities()
	{
		return [
			'role'	=>	[
				'name'	=>	'角色管理',
				'authorities'	=>	[
					'see'	=>	'查看',
					'opera'	=>	'操作',
				]
			]
		];
	}

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

		$this->view->setVars([
				'formparams'	=>	[
					'event'	=>	'add',
					'action'	=>	\Func\url('/role/add')	
				],
			]);
	}

	public function editAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new RoleForm('edit');
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->edit())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
		}

		$rid = $this->dispatcher->getParams()[0];
		if (empty($rid))
			$this->pageError('param');
		$role = Role::findById($rid);

		$form = new RoleForm('edit', $operator);
		$this->view->setVars([
				'page'	=>	[
					'title'	=>	'编辑角色',
				],
				'formparams'	=>	[
					'event'	=>	'edit',
					'action'	=>	\Func\url('/role/edit')	
				],
				'data'	=>	$role
			]);
		$this->view->pick('role/add');
	}
}
