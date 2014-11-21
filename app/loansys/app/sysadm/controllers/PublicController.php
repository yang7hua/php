<?php

/**
 * 但页面
 */
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
					$this->session->set('oid', $info->oid);
					$this->session->set('o_name', $info->name);
					$this->session->set('o_rid', $info->rid);
					$this->session->set('o_auth', Authority::getAuthByRid($info->rid));
					$this->success([
						'msg'=>'登录成功', 
						'redirect'=>[
							'url'=>\Func\url('/'),
							'seconds'	=>	0	
						]
					]);
				} else
					$this->error('账号或密码错误');
			}
			$this->error($result);
		}

		$this->view->setLayout('plain');
		$this->view->pick('single/login');
	}

	public function logoutAction()
	{
		$this->session->remove('oid');
		$this->session->remove('o_name');
		$this->session->remove('o_rid');
		$this->pageSuccess('退出成功', \Func\url('/'), 1);
	}

}
