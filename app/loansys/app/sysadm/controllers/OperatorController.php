<?php

class OperatorController extends Controller
{

	public static function actions()
	{
		return [
			'see'	=>	['list'],
			'opera'	=>	['add', 'edit']
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
		$this->view->disable();
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
}
