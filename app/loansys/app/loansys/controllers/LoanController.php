<?php

class LoanController extends Controller
{

	public static function actions()
	{
		return [
			'apply'	=>	[
				'apply'	=> [
					'text'=>'贷款申请', 
					'link'=>true
				],
			],
			'see'	=>	[
				'list'	=>	[
					'text'=>'贷款列表',
					'link'	=>	true
				],
				'detail'	=>	'详情',
			],
			//操作部分
			'operator'	=>	[
			]
		];
	}

	public static function authorities()
	{
		return [
			'loan'	=>	[
				'name'	=>	'贷款管理',
				'authorities'	=>	[
					'see'	=>	'贷款列表',
					'apply'	=>	'贷款申请',
					'operator'	=>	'操作'
				]
			]
		];
	}

	public function applyAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();

			$data['oid'] = $this->getOperatorId();
			$User = new User();
			$modelForm = new UserForm('apply');
			$db = $User->getDb();
			$db->begin();
			if ($modelForm->validate($data)) {
				if ($uid = $modelForm->apply()) {
					$data['uid'] = $uid;
					$modelForm = new LoanForm('apply');
					if ($modelForm->validate($data) and $modelForm->apply()) {
						$db->commit();
						$this->success('操作成功');
					} else {
						$db->rollback();
						$this->success('操作失败');
					}
				} else {
					$this->error('操作失败');
				}
			}
			exit();
		}
	}

	public function listAction()
	{
		$post = $this->request->getPost();
		if (isset($post['keyword']) and !empty($post['keyword']))
			$keyword = $post['keyword'];

		$conditions = [];
		if (preg_match('/^\d+$/', $keyword))
			$conditions['uid'] = intval($keyword);
		if (\Util\Validator::isCh($keyword))
			$conditions['realname'] = $keyword;

		$conditions['oid'] = $this->getOperatorId();
		$list = (new User())->select($conditions);

		$this->view->setVars([
				'list'	=>	$list
			]);
	}

	public function detailAction()
	{
		$uid = $this->dispatcher->getParams()[0];
		if (!$uid)
			$this->pageError('param');
	}
}
