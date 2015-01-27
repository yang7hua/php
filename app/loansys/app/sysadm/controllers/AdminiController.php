<?php

class AdminiController extends AdmController
{
	public function listAction()
	{
		$list = Admini::all();
		$this->view->setVars([
				'list'	=>	$list
			]);
	}

	public function addAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new AdminiForm('add');
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->add())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
			exit();
		}
		$this->view->setVars([
			'formparams'	=>	[
				'event'	=>	'add',
				'action'	=>	\Func\url('/admini/add')	
			]
			]);
	}

	public function existAction()
	{
		$username = $this->request->get('username');
		echo Admini::exist($username) ? 'false' : 'true';
		exit();
	}

	public function editAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new AdminiForm('edit');
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->edit())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
		}

		$id = $this->dispatcher->getParams()[0];
		if (empty($id))
			$this->pageError('param');
		$admini = Admini::findById($id);
		if (!$admini)
			$this->pageError('param');

		$form = new AdminiForm('edit', $admini);
		$this->view->setVars([
				'page'	=>	[
					'title'	=>	'编辑成员',
				],
				'formparams'	=>	[
					'event'	=>	'edit',
					'action'	=>	\Func\url('/admini/edit')	
				],
				'data'	=>	$admini
			]);
		$this->view->pick('admini/add');
	}

	public function freezeAction()
	{
		$this->changeStatus(Admini::STATUS_FREEZE);
	}

	public function unfreezeAction()
	{
		$this->changeStatus(Admini::STATUS_NORMAL);
	}

	public function changeStatus($status)
	{
		$aid = intval($this->urlParam());
		empty($aid) and $this->error('参数错误');

		$info = Admini::findFirst($aid);	
		empty($info) and $this->error('该账号不存在');

		$info->status = $status; 
		if ($info->update())
			$this->success('操作成功');
		else
			$this->error('操作失败');
	}

}
