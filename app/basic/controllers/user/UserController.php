<?php

namespace app\controllers\user;

use yii\web\Controller;
use app\models\User;
use app\models\UserForm;

class UserController extends Controller
{
	public $layout = 'user';

	public function actionIndex() {
		$user = User::findByUsername('yanghua');
		echo $user->password;
		echo "<br/>";
		echo User::createPassword('yanghua', $user->salt)['password'];
	}

	public function actionLogin()
	{
		$model = new UserForm(['scenario'=>'login']);
		if (!\Yii::$app->user->isGuest)
			return $this->goHome();
		if ($model->load(\Yii::$app->request->post()) && $model->login()) {
			return $this->goHome();
		} else {
			return $this->render('/user/login', ['model'=>$model]);
		}
	}

	/*
	public function actionLogout()
	{
		if (User::isLogin()) {
			$session = \Yii::$app->session;
			$session->remove('username');
			$session->remove('uid');
		}
		return $this->goHome();
	}
	 */

	public function actionReg()
	{
		$model = new User(['scenario'=>'reg']);
		if ($model->load(\Yii::$app->request->post()) && $model->reg()) {
			return $this->goHome();
		} else {
			return $this->render('/user/reg', ['model'=>$model]);
		}
	}
}
