<?php

/**
 * 督导
 */

class GpsController extends Controller
{
	public static function authorities()
	{
		return [
			'gps'	=>	[
				'name'	=>	'GPS',
				//'nationwide'	=>	true,
				'authorities'	=>	[
					'gps'	=>	'GPS安装'
				]
			]
		];
	}

	public static function actions()
	{
		return [
			'gps'	=>	[
				'list'	=>	['text'	=>	'客户列表', 'link'	=>	true],
				'gps'	=>	['text'	=>	'GPS安装'],
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
			$conditions[] = '{Loan}.gps' . ($post['deal'] == 1 ? '=1' : '!=1');
		}
		$conditions[] = '{Loan}.contract=1';

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
	 * GPS安装
	 */
	public function gpsAction()
	{
		if ($this->isAjax())
		{
			$data = $this->request->getPost();
			$uid = $data['uid'];
			!$uid and $this->error('参数错误');
			$data['gps'] = 1;

			$model = new LoanForm('gps');
			if ($result = $model->validate($data))
			{
				if ($model->sign())
				{
					Log::add($uid, $this->getOperatorId(), \App\Config\Log::loanOperate('gps'));
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
	}
}
