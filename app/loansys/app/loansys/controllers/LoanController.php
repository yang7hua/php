<?php

/**
 * 贷款相关操作, 面审、实地外访、车评、复审
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
				],
				'reface'	=>	[
					'text'	=>	'面审意见',
					'operator'	=>	true
				]
			],
			'visit'	=>	[
				'visit'	=>	[
					'text'	=>	'实地外访',
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
					'visit'	=>	'实地外访',
					'car'	=>	'车评'
				]
			]
		];
	}

	public function initialize()
	{
		parent::initialize();
		$action = $this->getActionName();
		if ($this->isAjax() and in_array($action, ['face', 'visit', 'car', 'reface']))
		{
			$uid = $this->request->getPost('uid');
			if (!$uid)
				$this->error('参数错误');
			if (!$this->checkLoanStatus($uid, $action))
				$this->error('操作失败');
		}
	}

	/**
	 * 检查当前贷款项目是否需要对应操作
	 */
	public function checkLoanStatus($uid, $action)
	{
		$loansketch = User::sketchInfo($uid);
		if (!$loansketch)
			return false;
		$status = $loansketch['status'];
		switch($action)
		{
			case 'face':
				return \App\LoanStatus::needFace($status);
				break;
			case 'visit':
				return \App\LoanStatus::needVisit($status);
				break;
			case 'car':
				return \App\LoanStatus::needCarAssess($status);
				break;
			case 'reface':
				return \App\LoanStatus::needReface($status);
				break;
			default:
				return false;
				break;
		}
	}

	/**
	 * 获取当前角色对于每笔贷款的操作权限
	 */
	public function operators()
	{
		static $operators = ['face', 'reface', 'visit', 'car', 'detail'];
		static $allow_operators = null;

		if ($allow_operators and is_array($allow_operators))
			return $allow_operators;

		$allow_actions = $this->getActionsByAuth($this->getAuthByController());
		if (empty($allow_actions) || !is_array($allow_actions))
			return [];

		$allow_operators = [];
		foreach ($allow_actions as $key=>$val)
		{
			if (in_array($key, $operators) and $val['operator'])
			{
				array_push($allow_operators, [
					'url'	=>	\Func\url('loan/' . $key),
					'operate'	=>	$key,
					'text'	=>	$val['text']
				]);
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
			$data['bid'] = $this->getOperatorBid();

			$User = new User();
			$modelForm = new UserForm('apply');
			if ($modelForm->validate($data)) 
			{
				$db = $User->getDb();
				$db->begin();
				if ($uid = $modelForm->apply()) 
				{
					$data['uid'] = $uid;
					$modelForm = new LoanSketchForm('apply');
					if ($modelForm->validate($data) and $modelForm->apply()) {
						$db->commit();
						Log::add($uid, $data['oid'], \App\Config\Log::loanOperate('apply'));
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
		$conditions = [];

		//关键字搜索
		$post = $this->request->get();
		if (isset($post['keyword']) and !empty($post['keyword']))
		{
			$keyword = $post['keyword'];
			if (preg_match('/^\d+$/', $keyword))
				$conditions['uid'] = intval($keyword);
			if (\Util\Validator::isCh($keyword))
				$conditions['realname'] = $keyword;
		}

		//面审、上门核查、车评
		if ($this->authHasAction('face')
			|| $this->authHasAction('visit')
			|| $this->authHasAction('car')
		)
		{
			$conditions['bid'] = $this->getOperatorBid();
		}
		//客户经理
		else
		{
			$conditions['oid'] = $this->getOperatorId();
		}

		//分页
		$p = $this->urlParam();
		$limit = $this->limit($p);

		$User = new User();
		$list = $User->sketches($conditions, $limit[0], $limit[1]);
		$count = $User->getSketchCount($conditions);
		$page = $this->page($count, $limit[0], $p);

		if (!$this->isAjax())
		{
			$operates = $this->operators();
			$this->view->setVars([
				'operates'	=>	$operates,
			]);
		}
		$this->view->setVars([
				'list'	=>	$list,
				'page'	=>	$page
			]);
	}

	/**
	 * 预览贷款详情
	 */
	public function detailAction()
	{
		$uid = $this->urlParam();
		if (!$uid)
			$this->pageError('param');

		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, 'reface');
		if (empty($infos['detailInfo']))
			$this->pageError('param');

		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}

	/**
	 * 初审操作
	 */
	public function faceAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			if (empty($data['uid']))
				$this->error('参数错误');

			$data['oid'] = $this->getOperatorId();
			$data['addtime'] = time();

			$model = new FaceForm('face');
			if ($model->validate($data))
			{
				if ($model->face())
				{
					//更新状态
					LoanSketch::updateStatus($data['uid'], \Func\getArrayKey(\App\Config\Loan::status(), '初审'));	
					Log::add($data['uid'], $data['oid'], \App\Config\Log::loanOperate('face'));
					$this->success('操作成功');
				}
				else
				{
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}
		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, 'face');

		$infos['uid'] = $uid;
		$infos['action'] = 'face';
		$infos['operate']['face'] = $this->authHasAction('face');
		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}

	/**
	 * 上门核查
	 */
	public function visitAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			if (empty($data['uid']))
				$this->error('参数错误');

			$data['oid'] = $this->getOperatorId();
			$data['addtime'] = time();

			$model = new VisitForm('visit');
			if ($model->validate($data))
			{
				if ($model->visit())
				{
					//更新状态
					LoanSketch::updateStatus($data['uid'], \App\LoanStatus::getStatusVisit());
					Log::add($data['uid'], $data['oid'], \App\Config\Log::loanOperate('visit'));
					$this->success('操作成功');
				}
				else
				{
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}

		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, 'visit');

		$infos['uid'] = $uid;
		$infos['action'] = 'visit';
		$infos['operate']['visit'] = $this->authHasAction('visit');
		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}

	/**
	 * 车评 
	 */
	public function carAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			if (empty($data['uid']))
				$this->error('参数错误');

			$data['oid'] = $this->getOperatorId();
			if ($data['car_buytime'])
				$data['car_buytime'] = strtotime($data['car_buytime']);

			$model = new CarForm('assess');
			if ($model->validate($data))
			{
				if ($model->assess())
				{
					//更新状态
					LoanSketch::updateStatus($data['uid'], \App\LoanStatus::getStatusCarAssess());
					Log::add($data['uid'], $data['oid'], \App\Config\Log::loanOperate('car'));
					$this->success('操作成功');
				}
				else
				{
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}

		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, 'car');

		$infos['uid'] = $uid;
		$infos['action'] = 'car';
		$infos['operate']['car'] = $this->authHasAction('car');
		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}

	//复审
	public function refaceAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			if (empty($data['uid']))
				$this->error('参数错误');

			$model = new FaceForm('reface');
			if ($model->validate($data))
			{
				if ($model->reface())
				{
					//更新状态
					LoanSketch::updateStatus($data['uid'], \App\LoanStatus::getStatusReface());
					Log::add($data['uid'], $this->getOperatorId(), \App\Config\Log::loanOperate('reface'));
					$this->success('操作成功');
				}
				else
				{
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}
		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, 'reface');

		$infos['uid'] = $uid;
		$infos['action'] = 'reface';
		$infos['operate']['reface'] = $this->authHasAction('reface');
		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}


	/**
	 * 根据等级获取贷款详细信息
	 * @param $uid: 客户编号
	 * @param $level: 信息等级, 
	 *				base-基本信息,客户经理提交的信息
	 *				face-初审信息
	 *				check-核查信息
	 *				reface-复审
	 */
	private function detail($uid, $level = 'base')
	{
		$detailInfo = User::detailInfo($uid);

		if (empty($detailInfo))
			$this->pageError('param');

		$this->checkPermission($detailInfo);

		$infos = [];
		$infos['detailInfo'] = $detailInfo;

		//初审信息
		if (in_array($level, ['face', 'visit', 'check', 'car', 'reface']))
		{
			$infos['faceinfo'] = Face::findByUid($uid);
		}
		//上门核查信息、车评
		if (in_array($level, ['visit', 'check', 'car', 'reface']))
		{
			$infos['visitinfo'] = Visit::findByUid($uid);
		}
		//车评
		if (in_array($level, ['car', 'check', 'reface']))
		{
			$infos['carinfo'] = Car::findByUid($uid);
		}
		if (in_array($level, ['reface']))
		{
			$infos['refaceinfo'] = Face::refaceInfo($infos['faceinfo']);
		}

		return $infos;
	}

	/**
	 * 检查当前登录者是否具有查看权限
	 */
	private function checkPermission($detail)
	{
		//是否同一个门店
		if ($detail['bid'] != $this->getOperatorBid())
			$this->pageError('permission');
	}
}
