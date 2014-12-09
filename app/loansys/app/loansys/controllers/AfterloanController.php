<?php

/**
 * 贷后管理
 */
class AfterloanController extends Controller
{
	public static function authorities()
	{
		return [
			'afterloan'	=>	[
				'name'	=>	'贷后管理',
				'authorities'	=>	[
					'operate'	=>	'管理'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'operate'	=>	[
				'list'	=>	['text'	=>	'贷款列表', 'link'	=>	true],
				'overdue'	=>	['text'	=>	'逾期列表', 'link'	=>	true],
				'detail'	=>	['text'	=>	'详情'],
				'addrepay'	=>	['text'	=>	'添加还款记录'],
				'repay'	=>	['text'	=>	'还款']
			]
		];
	}

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

		$conditions[] = '{Loan}.status='.\App\LoanStatus::getStatusRepay();

		return $conditions;
	}

	/**
	 * 贷款列表
	 */
	public function listAction()
	{
		$p = $this->urlParam();
		$limit = $this->limit($p);

		$condition = implode($this->searchConditions(), ' and ');
		$list = Loan::all($condition, $limit, ['base', 'branch', 'user', 'repay']);

		$count = $list['count'];
		$list = $list['list'];

		$page = $this->page($count, $limit[0], $p);

		$this->view->setVars([
			'list'	=>	$list,
			'page'	=>	$page
		]);
	}

	/**
	 * 逾期列表
	 */
	public function overdueAction()
	{
	}

	/**
	 * 贷款详情
	 */
	public function detailAction()
	{
		$uid = $this->urlParam();
		!$uid and $this->pageError('param');

		$detail = Loan::findByUid($uid);
		!$detail and $this->pageError('param');

		$repayList = Repay::findByUid($uid);

		$this->view->setVars([
			'detail'	=>	$detail,
			'repayList'	=>	$repayList
		]);
	}

	/**
	 * 添加还款记录
	 */
	public function addrepayAction()
	{
		$data = $this->request->getPost();
		empty($data['uid']) and $this->error('参数错误');

		if (!Loan::isValidNo($data['uid'], $data['no']))
			$this->error('参数错误');

		$data['oid'] = $this->getOperatorId();
		!empty($data['date']) and $data['date'] = strtotime($data['date']);
		$data['addtime'] = time();
		$data['status'] == 0 and $data['date'] = 0;

		$model = new RepayForm('add');
		if ($result = $model->validate($data))
		{
			if ($model->add())
			{
				if ($data['status'] == 1)
					Loan::updateRepay($data['uid'], $data['amount'], $data['no']);
				$this->success('操作成功');
			}
			else
				$this->error('操作失败');
		}
		else
		{
			$this->error('验证失败');
		}
		exit();
	}

	public function repayAction()
	{
		$data = $this->request->getPost();

		(empty($data['uid']) || empty($data['id']) || empty($data['date']) || empty($data['amount'])) and $this->error('参数错误');
		$data['status'] = 1;
		$data['date'] = strtotime($data['date']);

		$model = new RepayForm('repay');
		if ($result = $model->validate($data))
		{
			if ($model->repay())
			{
				Loan::updateRepay($data['uid'], $data['amount'], $data['no']);
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
	}

}
