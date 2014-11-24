<?php

class LoanController extends Controller
{

	public static function actions()
	{
		return [
				'apply'	=>	['apply']
			];
	}

	public static function authorities()
	{
		return [
			'loan'	=>	[
				'name'	=>	'贷款管理',
				'authorities'	=>	[
					'apply'	=>	'贷款申请'	
				]
			]
		];
	}

	public function applyAction()
	{
		if ($this->isAjax()) {
			$data = $this->request->getPost();

			$modelForm = new UserForm('apply');
			if ($modelForm->validate($data)) {
				$uid = $modelForm->apply();
				echo $uid;
				exit();
			}
			exit();
		}
	}
}
