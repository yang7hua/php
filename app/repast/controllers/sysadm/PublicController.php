<?php

namespace app\controllers\sysadm;

use \app\models\sysadm\AdminiForm;

class PublicController extends Controller
{
	public function actionLogin()
	{
		$model = new AdminiForm(['scenario'=>'login']);

		if ($model->load(\Yii::$app->request->post()) and ($admini = $model->login()))
		{
			$this->login($admini);
			return $this->goHome();
		}

		return $this->single('login', ['model'=>$model]);
	}

}
