<?php
/**
 * 全国风控中心相关操作
 */

class RcController extends Controller
{
	public static function authorities()
	{
		return [
			'rc'	=>	[
				'name'	=>	'风控中心',
				'nationwide'	=>	true,//全国
				'authorities'	=>	[
					'operate'	=>	'审批'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			//审批
			'operate'	=>	[
				'index'	=>	null,
				'list'	=>	['text'	=>	'案件列表',	'link'	=>	true ],
				'detail'=>	['text'	=>	'已处理案件详情' ],
				'case'	=>	['text'	=>	'案件详情'],
				'deal'	=>	['text'	=>	'处理', 'operate'	=>	true ],
				'advise'	=>	[]
			]
		];
	}

	public function indexAction()
	{
		$this->redirect(\Func\url('/rc/list', true));
	}

	//处理搜索条件
	private function searchConditions()
	{
		$conditions = [];

		$post = $this->request->get();
		if (isset($post['keyword']) and !empty($post['keyword']))
		{
			$keyword = $post['keyword'];
			if (preg_match('/^\d+$/', $keyword))
				$conditions[] = '{User}.uid = ' . intval($keyword);
			if (\Util\Validator::isCh($keyword))
				$conditions[] = '{User}.realname' . $keyword;
		}
		if (isset($post['bid']) and !empty($post['bid']))
		{
			$conditions[] = '{User}.bid='.intval($post['bid']);
		}

		return $conditions;
	}

	/**
	 * 案件列表
	 */
	public function listAction()
	{
		$p = $this->urlParam();
		$limit = $this->limit($p);

		$post = $this->request->get();
		if (isset($post['deal']) and $post['deal'] == 1)
		{
			$condition = implode($this->searchConditions(), ' and ');
			$list = Loan::all($condition, $limit);
			$deal = true;
		}
		else 
		{
			$condition = implode($this->searchConditions(), ' and ');
			$list = LoanSketch::rclist($condition, $limit);
			$deal = false;
		}

		$count = $list['count'];
		$list = $list['list'];

		$page = $this->page($count, $limit[0], $p);

		$this->view->setVars([
			'list'	=>	$list,
			'page'	=>	$page,
			'deal'	=>	$deal
		]);
	}

	/**
	 * 案件详情
	 */
	public function caseAction($uid)
	{
		empty($uid) and $this->pageError('param');

		$infos = User::infos($uid);
		!$infos and $this->redirect(\Func\url('rc/list', true));
		$infos['advise_types'] = \App\Config\Loan::adviseTypes();
		$infos['can_modify_actions'] = $this->canModifyActions($uid, $infos['loansketch']['status']);

		$this->view->setVars($infos);
	}

	public function detailAction($uid)
	{
		empty($uid) and $this->pageError('param');

		$infos = User::infos($uid);
		$this->view->setVars($infos);
	}

	/**
	 * 处理案件
	 */
	public function dealAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();

			$type = $data['type'];
			if (!in_array($type, ['agree', 'refuse']))
				$this->error('参数错误');

			$data['oid'] = $this->getOperatorId();
			$data['status'] = $type == 'agree' ? \App\LoanStatus::getStatusRcAgree() : \App\LoanStatus::getStatusRcRefuse();

			$model = new LoanForm($type);
			$result = $model->validate($data);
			if ($result)
			{
				if ($model->deal())
				{
					LoanSketch::updateStatus($data['uid'], $data['status']);
					Log::add($data['uid'], $data['oid'], \App\Config\Log::loanOperate('rc'));
					$this->success('操作成功');
				}
				else
				{
					Log::add($data['uid'], $data['oid'], \App\Config\Log::loanOperate('rc_refuse'));
					$this->error('操作失败');
				}
			}
			else
			{
				$this->error('验证失败');
			}
			exit();
		}
	}

	public function adviseAction($uid)
	{
		$data = $this->request->getPost();	
		$adviseTypes = \App\Config\Loan::adviseTypes();

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

	private function canModifyActions($uid, $status)
	{
		$advises = Advise::formatByType(Advise::getAdvisesByUid($uid));

		$actions = [
			'loansketch'=>0, 
			'visit'	=>	0,
			'car'	=>	0,
			'face'	=>	0,
			'rc'	=>	0
		];
		$advises_undo = array_intersect_key($advises, $actions);
		if ($advises_undo) {
			$this->view->setVars([
				'advises'	=>	$advises_undo
			]);
		} else if (\App\LoanStatus::needRc($status)) {
			$actions['rc'] = true;
		}
		return $actions;
	}

}
