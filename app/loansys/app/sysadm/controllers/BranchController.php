<?php

class BranchController extends AdmController
{

	public static function actions()
	{	
		return [
			'list'	=>	['list' => '门店列表'],
			'opera'	=>	['add' => '添加门店', 'edit' => '修改门店', 'del' => '删除门店']
		];
	}	

	public static function authorities()
	{
		return [
			'branch'	=>	[
				'name'	=>	'门店管理',
				'superbid'	=>	true,
				'authorities'	=>	[
					'list'	=>	'查看',
					'opera'	=>	'操作'
				]
			]
		];
	}

	public function listAction()
	{
		$branches = Branch::all(['all'=>true]);
		$this->view->setVar('branches', $branches);
	}

	public function editAction()
	{
		if ($this->isAjax()) 
		{
			$data = $this->request->getPost();
			$modelForm = new BranchForm('edit');
			if ($modelForm->validate($data))
			{
				if ($modelForm->edit())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}
		$id = $this->dispatcher->getParams()[0];
		if (empty($id))
			$this->pageError('param');
		$info = Branch::findById($id);
		if (!$info)
			$this->pageError('param');
		$this->view->setVars([
				'info'	=>	$info,
				'formparams'	=>	[
					'event'	=>	'edit',
					'action'	=>	\Func\url('/branch/edit')
				]
			]);
		$this->view->pick('branch/add');
	}

	public function addAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->error('参数错误');
			$modelForm = new BranchForm();
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
				'action'	=>	\Func\url('/branch/add')	
			]
		]);
	}
}
