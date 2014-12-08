<?php

class FinanceController extends Controller
{

	public static function authorities()	
	{
		return [
			'finance'	=>	[
				'name'	=>	'财务',
				'authorities'	=>	[
					'operate'	=>	'汇款凭证等操作'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'operate'	=>	[
				'list'	=>	['text'	=>	'客户列表', 'link'	=>	true],
				'detail'	=>	['text'	=>	'详情'],
				'remit'	=>	['text'	=>	'汇款凭证']
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

		$conditions[] = '{Loan}.status='.\App\LoanStatus::getStatusRcAgree();

		if (isset($post['deal']) and in_array($post['deal'], [1, -1]))
		{
			$conditions[] = '{Loan}.remit_certify' . ($post['deal'] == 1 ? '!=' : '=') . '\'\'';
		}
		$conditions[] = '{Loan}.contract=1 and {Loan}.gps=1';

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

	public function detailAction()
	{
		$uid = $this->urlParam();
		empty($uid) and $this->pageError('param');

		$loan = Loan::findByUid($uid);
		$user = User::findFirst($uid)->toArray();

		$this->view->setVars([
			'loan'	=>	$loan,
			'user'	=>	$user,
		]);
	}

	public function remitAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			$uid = $data['uid'];
			!$uid and $this->error('参数错误');

			$model = new LoanForm('remit');
			if ($result = $model->validate($data))
			{
				if ($model->remit())
				{
					Log::add($uid, $this->getOperatorId(), \App\Config\Log::loanOperate('remit_certify'));
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
