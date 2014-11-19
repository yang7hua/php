<?php

class OperatorController extends Controller
{
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
				$this->error('参数错误');
			$modelForm = new OperatorForm();
			if ($result = $modelForm->validate($data)) {
				if ($modelForm->add())
					$this->success('操作成功');
				else
					$this->error('操作失败');
			}
			$this->error($result);
		}
	}

	public function existAction()
	{
		$username = $this->request->get('username');
		echo Operator::exist($username) ? 'false' : 'true';
		$this->view->disable();
	}
}
