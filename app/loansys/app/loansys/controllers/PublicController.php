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
						'bid'	=>	$info->bid,
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
			$error = $modelForm->getErrors();
			if ($error)
				$this->error($error);
			$this->error('参数错误');
		}

		$this->single('login');
	}

	public function logoutAction()
	{
		//session_destroy();
		$this->session->remove('operator');
		$this->pageSuccess('退出成功', \Func\url('/'), 1);
	}

	public function captchaAction()
	{
		$params = $this->request->get();
		$width = isset($params['w']) ? $params['w'] : 85;
		$height = isset($params['h']) ? $params['h'] : 35;
		$color = isset($params['color']) ? $params['color'] : 'orange';
		$this->captcha($width, $height, $color);
	}

	public function uploadAction()
	{
		switch ($this->request->get('filename'))
		{
			case 'file_remit_certify':
				$dir = 'certify';
				break;
			default:
				$dir = '';
				break;
		}
		$fileinfo = $this->upload($dir);
		if (!$fileinfo)
			$this->error('上传失败');
		if (count($fileinfo))
		{
			$fileinfo = $fileinfo[0];
			if ($fileinfo['success'])
			{
				unset($fileinfo['success']);
				$this->success($fileinfo);
			}
			else
			{
				$this->error($fileinfo['errmsg']);
			}
		}
		exit();
	}
}
