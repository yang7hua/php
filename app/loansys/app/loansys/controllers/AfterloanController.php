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
				'addrepay'	=>	['text'	=>	'添加还款记录']
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
	}
}
