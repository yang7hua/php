<?php

/**
 * 督导
 */

class SupervisorController extends AfterRcController
{
	public static function authorities()
	{
		return [
			'supervisor'	=>	[
				'name'	=>	'督导',
				//'nationwide'	=>	true,
				'authorities'	=>	[
					'contract'	=>	'合同签署',
					'pledgenotary'	=>	'抵押公证'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'contract'	=>	[
				'list'	=>	['text'	=>	'客户列表', 'link'	=>	true],
				'sign'	=>	['text'	=>	'合同签署'],
			],
			'pledgenotary'	=>	[
				'list'	=>	['text'	=>	'客户列表', 'link'	=>	true],
				'pledgenotary'	=>	['text'	=>	'抵押公证'],
			]
		];
	}

	//处理搜索条件
	private function searchConditions()
	{
		$conditions = [];
		if (!$this->isNationWideBid())
		{
			$bid = $this->getOperatorBid();
			$conditions[] = '{User}.bid='.$bid;
		}

		$post = $this->request->get();
		if (isset($post['keyword']) and !empty($post['keyword']))
		{
			$keyword = $post['keyword'];
			if (preg_match('/^\d+$/', $keyword))
				$conditions[] = '{User}.uid = ' . intval($keyword);
			if (\Util\Validator::isCh($keyword))
				$conditions[] = '{User}.realname = \'' . $keyword . '\'';
		}

		if (isset($post['deal']) and in_array($post['deal'], [1, -1]))
		{
			if ($post['deal'] == 1)
			{
				$conditions[] = '{Loan}.bank!=\'\'';
				$conditions[] = '{Loan}.status>='.\App\LoanStatus::getStatusRcAgree();
			}
			else
			{
				$conditions[] = '{Loan}.status='.\App\LoanStatus::getStatusRcAgree();
			}
		}

		return $conditions;
	}

	public function listAction()
	{
		$p = $this->urlParam();
		$limit = $this->limit($p);

		$condition = implode($this->searchConditions(), ' and ');
		$list = Loan::all($condition, $limit, ['base', 'branch', 'user', 'other']);

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
	 * 合同签署
	 */
	public function signAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			$uid = $data['uid'];
			!$uid and $this->error('参数错误');

			$data['begintime'] = strtotime(date('Y-m-d 23:59:59', time()));//还款开始时间,签署合同当天23:59:59秒计时
			//$data['status']	= \App\LoanStatus::getStatusRepay();
			$data['return_num'] = 0;
			$data['return_amount'] = 0;
			$data['last_repay_time'] = $data['begintime'];
			$data['next_repay_time'] = strtotime('+1 month', $data['begintime']);
			$data['endtime'] = 0;

			$model = new LoanForm('contractSign');
			if ($result = $model->validate($data))
			{
				if ($model->sign())
				{
					Log::add($data['uid'], $this->getOperatorId(), \App\Config\Log::loanOperate('sign'));
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

		$loan = Loan::findByUid($uid);
		$user = User::findFirst($uid)->toArray();

		$this->view->setVars([
			'loan'	=>	$loan,
			'user'	=>	$user,
		]);
		$this->view->pick('afterrc/detail');
	}

	/**
	 * 抵押公证
	 */
	public function pledgenotaryAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			$uid = $data['uid'];
			!$uid and $this->error('参数错误');

			$model = new LoanForm('pledge_notary');
			$data['pledge_notary'] = 1;
			if ($result = $model->validate($data))
			{
				if ($model->pledgenotary())
				{
					Log::add($data['uid'], $this->getOperatorId(), \App\Config\Log::loanOperate('pledgenotary'));
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
