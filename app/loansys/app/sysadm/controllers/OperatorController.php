<?php

class OperatorController extends Controller
{

	public static function actions()
	{
		return [
			'see'	=>	[
				'list'	=>	'账号列表'
			],
			'opera'	=>	[
			'add'	=>	'添加账号', 
			'edit'	=>	'修改账号', 
			'exist'	=>	'唯一检测'
			]
		];
	}

	public static function authorities()
	{
		return [
			'operator'	=>	[
				'name'	=>	'账号管理',
				'authorities'	=>	[
					'see'	=>	'查看',
					'opera'	=>	'操作',
				]
			]
		];
	}

	public function listAction()
	{
		$operators = Operator::all();
		$this->view->setVar('operators', $operators);
	}

	public function addAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new OperatorForm('add');
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
					'action'	=>	\Func\url('/operator/add')	
				],
			]);
	}

	public function existAction()
	{
		$username = $this->request->get('username');
		echo Operator::exist($username) ? 'false' : 'true';
		exit();
	}

	public function editAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new OperatorForm('edit');
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
		$operator = Operator::findById($oid);
		if (!$operator)
			$this->pageError('param');

		$form = new OperatorForm('edit', $operator);
		$this->view->setVars([
				'page'	=>	[
					'title'	=>	'编辑成员',
				],
				'formparams'	=>	[
					'event'	=>	'edit',
					'action'	=>	\Func\url('/operator/edit')	
				],
				'data'	=>	$operator
			]);
		$this->view->pick('operator/add');
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
		$oid = intval($this->urlParam());
		empty($oid) and $this->error('参数错误');

		$info = Operator::findFirst($oid);	
		empty($info) and $this->error('该账号不存在');

		$info->status = $status; 
		if ($info->update())
			$this->success('操作成功');
		else
			$this->error('操作失败');
	}
}
