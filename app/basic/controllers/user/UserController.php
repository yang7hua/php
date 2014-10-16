<?php

namespace app\controllers\user;

use yii\web\Controller;
use app\models\User;
use app\models\UserForm;

class UserController extends Controller
{
	public $layout = 'user';
	private $public_actions = ['login', 'logout', 'reg'];

	public function beforeAction($action)
	{
		if (!in_array($action->id, $this->public_actions) && \Yii::$app->user->isGuest)
			$this->redirect('/user/login');
		return true;
	}

	public function actionIndex() {
		return $this->render('/user/index');
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

	public function actionLogout()
	{
		if (!\Yii::$app->user->isGuest) {
			\Yii::$app->user->logout();
		}
		return $this->goHome();
	}

	public function actionReg()
	{
		$model = new UserForm(['scenario'=>'reg']);
		if ($model->load(\Yii::$app->request->post()) && $model->reg()) {
			return $this->goHome();
		} else {
			return $this->render('/user/reg', ['model'=>$model]);
		}
	}
}
