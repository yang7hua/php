<?php

class PublicController extends Controller
{
	public function initialize()
	{
		parent::initialize();
		$this->noMainLayout();
	}

	public function loginAction()
	{
		if ($this->isLogin())
			$this->redirect(\Func\url('/', true));

		if ($this->isAjax()) {
			$data = $this->request->getPost();
			if (empty($data))
				$this->pageError('param');
			$modelForm = new OperatorForm('login');
			if ($result = $modelForm->validate($data)) {
				if ($info = $modelForm->login()) {
					$_sess = [
						'oid'	=>	$info->oid,
						'username'	=>	$info->username,
						'rid'	=>	$info->rid,
						'rname'	=>	Role::getNameById($info->rid),
						'bname'	=>	Branch::getNameById($info->bid),	
						'auth'	=>	Operator::getAuthByRid($info->rid)
						];
					$this->session->set('operator', $_sess);
					$this->success([
						'msg'=>'登录成功', 
						'redirect'=>[
							'url'=>\Func\url('/loan/list'),
							'seconds'	=>	0	
						]
					]);
				} else {
					$this->error('账号或密码错误');
				}
			}
			$this->error('参数错误');
		}

		$this->single('login');
	}

	public function logoutAction()
	{
		$this->session->remove('operator');
		$this->pageSuccess('退出成功', \Func\url('/'), 1);
	}
}
