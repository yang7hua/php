<?php

/**
 * 贷款相关操作, 面审、实地外访、车评、复审
 */
class LoanController extends Controller
{

	public static function specialsActions()
	{
		return [
			'files'	=>	[
				'controller'	=>	'rc',
				'action'	=>	['operate']
			],
			'info'	=>	[
				'controller'	=>	'*',
				'action'	=>	'*'
			]
		];
	}

	public static function actions()
	{
		return [
			'apply'	=>	[
				'apply'	=> [
					'text'=>'贷款申请', 
					'link'=>true
				],
				'upload'	=>	[],
				'doadvises'	=>	[]
			],
			'see'	=>	[
				'list'	=>	[
					'text'=>'贷款列表',
					'link'	=>	true
				],
				'detail'	=>	[
					'text'	=>	'详情',
					'operator'	=>	true
				],
				'files'	=>	[
					'text'	=>	'车评详情'
				],
			],
			'face'	=>	[
				'face'	=>	[
					'text'	=>	'面审',
					'operator'	=>	true
				],
				'reface'	=>	[
					'text'	=>	'面审意见',
					'operator'	=>	true
				],
				'upload'	=>	[],
				'doadvises'	=>	[]
			],
			'visit'	=>	[
				'visit'	=>	[
					'text'	=>	'实地外访',
					'operator'	=>	true
				],
				'doadvises'	=>	[]
			],
			'car'	=>	[
				'car'	=>	[
					'text'	=>	'车评',
					'operator'	=>	true
				],
				'upload'	=>	[],
				'advise'	=>	[],
				'doadvises'	=>	[]
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
			//if ($this->checkLoanStatus($uid, $action))
			//	$this->error('该贷款状态下不能操作');
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
		$uid = $this->urlParam();
		if ($this->isAjax()) {
			$data = $this->request->getPost();
			$data['oid'] = $this->getOperatorId();
			$data['bid'] = $this->getOperatorBid();

			if ($uid and !$this->canLoanEdit(false, $uid)) {
				$this->error('无权限修改');
			}
			$User = new User();
			$modelForm = new UserForm('apply');
			if ($modelForm->validate($data)) 
			{
				if ($uid) {
					if ($modelForm->edit($uid)) {
						$modelForm = new LoanSketchForm('apply');
						if ($modelForm->validate($data) and $modelForm->edit($uid)) {
							Log::add($uid, $data['oid'], \App\Config\Log::loanOperate('edit_loan_sketch') . ',uid:' . $uid);
							$this->success('修改成功');
						} 
						$this->error('修改失败');
					}
					$this->error('修改失败');
				} else if ($uid = $modelForm->apply()) {
					$data['uid'] = $uid;
					$modelForm = new LoanSketchForm('apply');
					if ($modelForm->validate($data) and $modelForm->apply()) {
						Log::add($uid, $data['oid'], \App\Config\Log::loanOperate('apply'));
						$this->success('操作成功');
					} else {
						$this->error('操作失败');
					}
				} else {
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('操作失败');
			}
			exit();
		}
		if ($uid) {
			$user = $this->detail($uid, ['user', 'loansketch']);
			$this->view->setVars(array_merge($user['user'], $user['loansketch']));
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

		//客户经理
		if ($this->authHasAction('apply'))
		{
			$conditions['oid'] = $this->getOperatorId();
		}
		//面审、上门核查、车评、有权限查看列表的人
		else if ($this->authHasAction('face')
			|| $this->authHasAction('visit')
			|| $this->authHasAction('car')
			|| $this->authHasAction('list')
		)
		{
			$conditions['bid'] = $this->getOperatorBid();
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

		$infos = $this->detail($uid);
		if (empty($infos['user']))
			$this->pageError('param');
		$infos['doadvises_url'] = '/loan/doadvises/';
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);
		$infos['adviseTypes'] = $this->adviseTypes();

		$this->view->setVars($infos);
		$this->view->pick('loan/detail');
	}

	/**
	 * 初审操作
	 */
	public function faceAction($uid, $action = null)
	{
		$uid = $this->urlParam();
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
				if ($model->face($uid))
				{
					//更新状态
					LoanSketch::updateStatus($data['uid'], \App\LoanStatus::getStatusFace());	
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
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, ['user', 'loansketch', 'face']);

		$infos['uid'] = $uid;
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);
		$infos['action'] = $action;

		$adviseTypes = $this->adviseTypes();
		if (!isset($infos['visit']) or empty($infos['visit']))
			unset($adviseTypes['visit']);
		if (!isset($infos['car']) or empty($infos['car']))
			unset($adviseTypes['car']);
		$infos['adviseTypes'] = $adviseTypes;
		$infos['doadvises_url'] = '/loan/doadvises/';

		$this->view->setVars($infos);
		$this->view->pick('loan/info/face');
	}

	/**
	 * 上门核查
	 */
	public function visitAction($uid, $action = null)
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
				if ($model->visit($action))
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

		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, ['user', 'loansketch', 'visit']);

		$infos['uid'] = $uid;
		$infos['doadvises_url'] = '/loan/doadvises/';
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);
		$infos['action'] = $action;
		$this->view->setVars($infos);
		$this->view->pick('loan/info/visit');
	}

	/**
	 * 车评 
	 */
	public function carAction($uid, $action = null)
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();

			$data['oid'] = $this->getOperatorId();
			if ($data['car_register_date'])
				$data['car_register_date'] = strtotime($data['car_register_date']);

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

		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, ['user', 'loansketch', 'car', 'car_files']);

		$infos['uid'] = $uid;
		$infos['doadvises_url'] = '/loan/doadvises/'.$uid;
		$infos['action'] = $action;
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);
		$this->view->setVars($infos);
		$this->view->pick('loan/info/car');
	}

	//复审
	public function refaceAction($uid, $action = null)
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();

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
		empty($uid) and $this->pageError('param');

		$infos = $this->detail($uid, ['user', 'face', 'loansketch']);

		$infos['uid'] = $uid;
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);
		$infos['action'] = $action;

		$this->view->setVars($infos);
		$this->view->pick('loan/info/reface');
	}


	/**
	 * 根据等级获取贷款详细信息
	 * @param $uid: 客户编号
	 * @param $level: 信息等级, 
	 *				user-基本信息,客户经理提交的信息
	 *				loansketch-贷款初稿
	 *				face-初审信息
	 *				visit-核查信息
	 *				car-车评
	 */
	private function detail($uid, $level = ['user', 'loansketch', 'visit', 'face', 'car'])
	{
		return User::infos($uid, $level);
		/*
		$this->ajaxReturn($infos);
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
		 */
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

	public function filesAction($uid, $type)
	{
		$uid = intval($uid);
		if (!$type)
			$this->pageError('param');
		$typeid = \App\Config\Loan::uploadTypes($type);
		$files = Files::getFilesByUid($uid, $typeid);
		$detail['uid'] = $uid;
		$detail['files'] = $files;
		$detail['upload_auth'] = $this->authHasAction($type);
		$this->view->setVars($detail);
		$this->view->pick('loan/files/'.$type);
	}

	public function uploadAction($type, $uid)
	{
		//权限
		static $types = [
			'car'	=>	[
				'auth'	=>	'car',
				'label'	=>	'车辆照片'
			],
			'loan'	=>	[
				'auth'	=>	'apply',
				'label'	=>	'贷款资料'
			],
			'face'	=>	[
				'auth'	=>	'face',
				'label'	=>	'面审资料'
			]
		];
		$typeid = \App\Config\Loan::uploadTypes($type);
		if (!$typeid)
			$this->pageError('param');
		$label = $types[$type]['label'];

		if ($this->request->getPost()) {
			$file = $this->upload($type)[0];
			$result = $file['success'];
			unset($file['success']);
			if ($result) {
				$data = [
					'uid'	=>	$uid,
					'oid'	=>	$this->getOperatorId(),
					'type'	=>	$typeid,
					'label'	=>	$label,
					'path'	=>	'/'.$file['filename'],
					'is_img'	=>	(\Func\isImg($file['filename']) ? 1 : 0),
					'info'	=>	' '
				];
				if ((new Files)->add($data))
					$this->ajaxReturn($file);
				else
					$this->error('操作失败');
			} else {
				$this->ajaxReturn($file['errmsg'], 0);
			}
			exit();
		}

		$files = Files::getFilesByUid($uid, $typeid);

		$this->view->setVars([
			'label'	=>	$label,
			'uid'	=>	$uid,
			'type'	=>	$type,
			'files'	=>	$files
		]);
		$this->view->pick('loan/upload');
	}	

	/**
	 * 获取可以提反馈意见、修改的
	 */
	private function adviseTypes()
	{
		return \App\Config\Loan::adviseTypes(['loansketch', 'visit', 'car']);
	}

	/**
	 * 反馈
	 * 反馈信息将会把贷款草稿状态恢复到之前的状态
	 */
	public function adviseAction($uid)
	{
		$data = $this->request->getPost();	
		$adviseTypes = $this->adviseTypes();

		$adviseType = $data['advisetype'];
		$reason = $data['reason'];
		if (!array_key_exists($adviseType, $adviseTypes) || empty($reason)) {
			$this->error('参数错误');
		}
		$foid = $this->getOperatorId();
		if (Loan::advise($uid, $foid, $adviseType, $reason))
			$this->success('操作成功');
		$this->error('操作失败');
	}

	public function doadvisesAction()
	{
		$data = $this->request->getPost();
		if (isset($data['ids']) and is_array($data['ids'])) {
			$ids = implode(',', $data['ids']);
		} else {
			$this->error('请选择要处理的任务');
		}
		if (!preg_match('/^[,\d]+$/', $ids))
			$this->error('参数不合法');
		if (Advise::doAdvises($ids))
			$this->success('操作成功');
		$this->error('操作失败');
		exit();
	}

	/**
	 * 获取当前操作者所具有的面审、车评、外访等权限
	 * 判断是否有待处理任务、和贷款状态
	 */
	private function canModifyActions($uid, $status, $type = null)
	{
		$apply	=	$this->authHasAction('apply');
		$face	=	$this->authHasAction('face');
		$visit	=	$this->authHasAction('visit');
		$car	=	$this->authHasAction('car');
		$actions = [
			'apply'	=>	false,
			'face'	=>	false,
			'visit'	=>	false,
			'car'	=>	false,
			'reface'	=>	false
		];
		$advises = Advise::formatByType(Advise::getAdvisesByUid($uid));
		if ($apply and ($status == \App\LoanStatus::getStatusSketch() || array_key_exists('loansketch', $advises)))
			$actions['apply'] = true;
		if ($face and (\App\LoanStatus::needFace($status) || array_key_exists('face', $advises)) and !array_key_exists('loansketch', $advises))
			$actions['face'] = true;
		if ($visit and (\App\LoanStatus::needVisit($status) || array_key_exists('visit', $advises)))
			$actions['visit'] = true;
		if ($car and (\App\LoanStatus::needCarAssess($status) || array_key_exists('car', $advises)))
			$actions['car'] = true;
		if ($face and (\App\LoanStatus::needReface($status) || array_key_exists('reface', $advises)))
			$actions['reface'] = true;

		if ($type) {
			return array_key_exists($type, $actions) ? $actions[$type] : false;
		}
		$this->view->setVars([
			'advises'	=>	$advises
		]);

		return $actions;
	}

	/**
	 * 公共预览
	 */
	public function infoAction($uid, $type, $content = '*')
	{
		$action = $type . 'Action';
		if ($content == 'files') {
			return $this->filesAction($uid, $type);
		}
		if (method_exists($this, $action))
			return $this->$action($uid);
		return $this->pageError('page');
	}

}
