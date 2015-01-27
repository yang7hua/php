<?php

/**
 * 运营
 */
class RunController extends Controller
{

	public static function authorities()
	{
		return [
			'run'	=>	[
				'name'	=>	'运营',
				'nationwide'	=>	true,
				'authorities'	=>	[
					'operate'	=>	'确认放款'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'operate'	=>	[
				'list'	=>	['text'	=>	'贷款列表', 'link'	=>	true],
				'confirm'	=>	['text'	=>	'确认放款']
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

		if (isset($post['deal']) and in_array($post['deal'], [-1, 1])) {
			if ($post['deal'] == 1) {
				$conditions[] = '{Loan}.status>='.\App\LoanStatus::getStatusRunConfirm();
			} else {
				$conditions[] = '{Loan}.status='.\App\LoanStatus::getStatusRcAgree();
				$conditions[] = '{Loan}.gps=1 and {Loan}.contract=1 and {Loan}.car_key=1 and {Loan}.pledge_notary=1';
			}
		} else {
			$conditions[] = '{Loan}.status>='.\App\LoanStatus::getStatusRcAgree();
			$conditions[] = '{Loan}.gps=1 and {Loan}.contract=1 and {Loan}.car_key=1 and {Loan}.pledge_notary=1';
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
			'page'	=>	$page
		]);
	}


	/**
	 * 确认放款
	 */
	public function confirmAction($uid)
	{
		if ($this->isAjax()) {
			!$uid and $this->error('参数错误');
			if (Loan::updateStatus($uid, \App\LoanStatus::getStatusRunConfirm())) {
				Log::add($uid, $this->getOperatorId(), \App\Config\Log::loanOperate('runconfirm'));
				$this->success('操作成功');
			}
			$this->error('操作失败');
		}
		$loan = Loan::findByUid($uid);	
		$user = User::findFirst($uid)->toArray();

		$this->view->setVars([
			'loan'	=>	$loan,
			'user'	=>	$user
		]);
		$this->view->pick('run/detail');
	}

}
