<?php

class Admini extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('\Models\Admini', 'admini');
	}

	public function login()
	{
		if ($this->has_login())
			$this->go_home();

		$this->check_captcha();
		$username = $this->input->request('username');
		$password = $this->input->request('password');

		$admini = $this->admini->find_by_aname($username);
		$admini or $this->error('账号不存在');
		$admini->password == password($password) or $this->error('密码错误');
		$this->admini->is_ok($admini->status) or $this->error('账号异常，无法登录');

		$this->session->set_userdata([
			'admini'	=>	[
				'aname'	=>	$admini->aname,
				'role_id'	=>	$admini->role_id,
			]
		]);
		$this->success('登录成功');
	}

	public function create()
	{
		$username = $this->input->request('username');
		$password = $this->input->request('password');
		$username or $this->error('账号不能为空');
		$password or $this->error('密码不能为空');

		$aid = $this->admini->create($username, $password, 1);
		$aid and $this->success('操作成功');
	}
}
