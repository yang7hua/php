<?php

namespace app\controllers\sysadm;

use \app\models\sysadm\AdminiForm;

class PublicController extends Controller
{
	public function actionLogin()
	{
		$model = new AdminiForm(['scenario'=>'login']);
		return $this->single('login', ['model'=>$model]);
	}
}
