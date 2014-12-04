<?php
//全国风控中心

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
				'deal'	=>	['text'	=>	'处理', 'operate'	=>	true ]
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
	public function caseAction()
	{
		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$infos = $this->loanSketch($uid);
		!$infos and $this->pageError('param');

		$this->view->setVars($infos);
	}

	public function detailAction()
	{
		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$loan = Loan::findByUid($uid);
		$user = User::findFirst($uid)->toArray();
		/*
		$face = Face::findByUid($uid);
		$visit = Visit::findByUid($uid);
		$carassess = Car::findByUid($uid);
		 */

		$this->view->setVars([
			'loan'	=>	$loan,
			'user'	=>	$user,
			/*
			'face'	=>	$face,
			'visit'	=>	$visit,
			'carassess'	=>	$carassess
			 */
		]);
	}

	/**
	 * 获待处理案件所有信息
	 */
	private function loanSketch($uid)
	{
		//贷款信息
		$LoanSketch = LoanSketch::findByUid($uid);
		if (!$LoanSketch || !\App\LoanStatus::isCase($LoanSketch['status']))
			return false;

		$user = User::findFirst($uid)->toArray();
		$face = Face::findByUid($uid);
		$visit = Visit::findByUid($uid);
		$carassess = Car::findByUid($uid);

		return [
			'loan'	=>	$LoanSketch,
			'user'	=>	$user,
			'face'	=>	$face,
			'visit'	=>	$visit,
			'carassess'	=>	$carassess
		];
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
	}
}
