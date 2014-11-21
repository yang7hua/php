<?php

class AuthorityController extends Controller
{
	public static function actions()
	{
		return [
				'allot'	=>	['allot']
			];
	}

	public static function authorities()
	{
		return [
			'authority'	=>	[
				'name'	=>	'权限管理',
				'authorities'	=>	[
					'allot'	=>	'权限分配'
				]
			]
		];
	}
	
	public function listAction()
	{
		$list = Authority::all();
	}

	public function addAction()
	{
	}

	/**
	 * 将json字符串auth转换成数组
	 */
	public static function toArray($auth)
	{
		$return = [];
		$json = json_decode($auth);
		function analyse($obj) {
			$return = [];
			foreach ($obj as $k=>$v) {
				$return[$k] = $v;
			}
			return $return;
		}
		foreach ($json as $key=>$row) {
			$return[$key] = analyse($row);
		}
		return $return;
	}	

	/**
	 * 给角色分配权限
	 */
	public function allotAction()
	{
		if ($this->isAjax()) {	
			$data = $this->request->getPost();
			$data['auth'] = serialize(self::toArray($data['auth']));

			switch ($data['type']) {
				case 'role':
					$modelForm = new RoleForm('auth');
					$data['rid'] = $data['id'];
					unset($data['id']);
					break;
				case 'operator':
					$data['oid'] = $data['id'];
					unset($data['id']);
					$modelForm = new OperatorForm('auth');
					break;
				default:
					$this->error('参数错误');
					break;
			}

			if ($result = $modelForm->validate($data)) {
				if ($modelForm->allot())
					$this->success('操作成功');
				else
					$this->success('操作失败');
			}
			$this->error('操作失败');
		}

		$params = $this->dispatcher->getParams();
		$type = $params[0];
		$id = $params[1];
		if (empty($type) || empty($id))
			$this->pageError('param');

		switch ($type) {
			case 'role':
				$info = Role::findById($id);
				$modelForm = new RoleForm('auth', $info);
				break;
			case 'operator':
				$info = Operator::findById($id);
				$modelForm = new OperatorForm('auth', $info);
				break;
		}
		$this->view->setVars([
			'info'	=>	$info,
			'form'	=>	$modelForm,
			'authorities'	=>	Authority::all(),
			'formparams'	=>	[
				'action'	=>	\Func\url('/authority/allot/role/'),
				'type'	=>	$type,
				'id'	=>	$id
			]
		]);
	}

}
