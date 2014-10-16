<?php

namespace app\controllers\user;

use yii\web\Controller\User;
use app\models\Profile;
use app\models\ProfileForm;

class ProfileController extends UserController
{
	public function actionInfo()
	{
		if (\Yii::$app->request->get('do') == 'edit') {
			$model = new ProfileForm();
			return $this->render('/user/profile/info_edit', ['model'=>$model]);
		}
		return $this->render('/user/profile/info');
	}

	public function actionAvatar()
	{
		if (\Yii::$app->request->get('do') == 'edit')
		{
			$model = new ProfileForm();
			return $this->render('/user/profile/avatar_edit', ['model'=>$model]);
		}
		return $this->redirect('/user/profile/avatar');	
	}
}
