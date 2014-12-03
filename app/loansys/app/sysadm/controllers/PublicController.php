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
			$modelForm = new AdminiForm('login');
			if ($result = $modelForm->validate($data)) {
				if ($info = $modelForm->login()) {
					$this->session->set('adm', $info);
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
			$error = $modelForm->getErrors();
			if ($error)
				$this->error($error);
			$this->error('参数错误');
		}

		$this->view->setLayout('plain');
		$this->view->pick('single/login');
	}

	public function logoutAction()
	{
		$this->session->remove('adm');
		$this->pageSuccess('退出成功', \Func\url('/'), 1);
	}

}
