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
				'detail'=>	['text'	=>	'详情', 'operate'	=>	true ]
			]
		];
	}

	public function indexAction()
	{
		$this->redirect(\Func\url('/rc/list', true));
	}

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

		$condition = implode($this->searchConditions(), ' and ');
		$list = LoanSketch::rclist($condition, $limit);
		$count = $list['count'];
		$list = $list['list'];

		$page = $this->page($count, $limit[0], $p);

		$this->view->setVars([
			'list'	=>	$list,
			'page'	=>	$page
		]);
		$this->view->pick('rc/list');
	}
}
