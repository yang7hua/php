<?php

/**
 * 贷款相关操作
 */
class LoanController extends Controller
{

	public static function actions()
	{
		return [
			'apply'	=>	[
				'apply'	=> [
					'text'=>'贷款申请', 
					'link'=>true
				],
			],
			'see'	=>	[
				'list'	=>	[
					'text'=>'贷款列表',
					'link'	=>	true
				],
				'detail'	=>	[
					'text'	=>	'详情',
					'operator'	=>	true
				]
			],
			'face'	=>	[
				'face'	=>	[
					'text'	=>	'面审',
					'operator'	=>	true
				]
			],
			'visit'	=>	[
				'visit'	=>	[
					'text'	=>	'上门审查',
					'operator'	=>	true
				]
			],
			'car'	=>	[
				'car'	=>	[
					'text'	=>	'车评',
					'operator'	=>	true
				]
			]
		];
	}

	/**
	 * 权限管理配置
	 */
	public static function authorities()
	{
		return [
			'loan'	=>	[
				'name'	=>	'贷款管理',
				'authorities'	=>	[
					'see'	=>	'贷款列表',
					'apply'	=>	'贷款申请',
					'face'	=>	'面审',
					'visit'	=>	'上门审查',
					'car'	=>	'车评'
				]
			]
		];
	}

	/**
	 * 获取当前角色对于每笔贷款的操作权限
	 */
	public function operators()
	{
		static $operators = ['face', 'visit', 'car', 'detail'];
		static $auth = null;
		static $allow_operators = null;
		if ($allow_operators and is_array($allow_operators))
			return $allow_operators;

		if (!$auth)
			$auth = $this->getAuthByController();

		$actions =	self::actions(); 
		$allow_actions = [];
		foreach ($auth as $val)
		{
			if (array_key_exists($val, $actions))
				$allow_actions = array_merge($allow_actions, $actions[$val]);
		}
		$allow_operators = [];
		if (is_array($allow_actions))
		{
			foreach ($allow_actions as $key=>$val)
			{
				if (in_array($key, $operators) and $val['operator'])
				{
					array_push($allow_operators, [
						'url'	=>	\Func\url('loan/' . $key),
						'text'	=>	$val['text']
					]);
				}
			}
		}
		return $allow_operators;
	}

	/**
	 * 贷款申请
	 */
	public function applyAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();

			$data['oid'] = $this->getOperatorId();
			$User = new User();
			$modelForm = new UserForm('apply');
			if ($modelForm->validate($data)) 
			{
				$db = $User->getDb();
				$db->begin();
				if ($uid = $modelForm->apply()) 
				{
					$data['uid'] = $uid;
					$modelForm = new LoanForm('apply');
					if ($modelForm->validate($data) and $modelForm->apply()) {
						$db->commit();
						$this->success('操作成功');
					} else {
						$db->rollback();
						$this->success('操作失败');
					}
				} 
				else 
				{
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('操作失败');
			}
			exit();
		}
	}

	/**
	 * 贷款列表查看
	 */
	public function listAction()
	{
		$post = $this->request->getPost();
		if (isset($post['keyword']) and !empty($post['keyword']))
			$keyword = $post['keyword'];

		$conditions = [];
		if (preg_match('/^\d+$/', $keyword))
			$conditions['uid'] = intval($keyword);
		if (\Util\Validator::isCh($keyword))
			$conditions['realname'] = $keyword;

		$conditions['oid'] = $this->getOperatorId();
		$list = (new User())->select($conditions);

		$operators = $this->operators();
		$this->view->setVars([
				'list'	=>	$list,
				'operators'	=>	$operators
			]);
	}

	/**
	 * 贷款详情
	 */
	public function detailAction()
	{
		$uid = $this->dispatcher->getParams()[0];
		if (!$uid)
			$this->pageError('param');
	}
}
