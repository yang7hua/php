<?php

namespace app\controllers\sysadm;

use app\models\sysadm\Group;
use app\models\sysadm\GroupForm;

class GroupController extends Controller
{

	public function actionList()
	{
		$list = Group::all();
		return $this->render('list', [
			'list'	=>	$list
		]);
	}

	public function actionAdd()
	{
		$model = new GroupForm(['scenario'	=>	'add']);
		return $this->render('add', [
			'model'	=>	$model
		]);
	}

}
