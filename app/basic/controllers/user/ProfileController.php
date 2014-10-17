<?php

namespace app\controllers\user;

use app\models\Profile;
use app\models\ProfileForm;
use app\models\AvatarForm;
use yii\web\UploadedFile;
use yii\imagine\Image;

class ProfileController extends UserController
{
	public function actionCrop()
	{
	}

	public function actionInfo()
	{
		if (\Yii::$app->request->get('do') == 'edit') {
			$model = new ProfileForm();
			$info = Profile::info();
			return $this->render('/user/profile/info_edit', ['model'=>$model, 'info'=>$info]);
		}
		return $this->render('/user/profile/info');
	}

	public function actionAvatar()
	{
		if (\Yii::$app->request->get('do') == 'edit')
		{
			$model = new AvatarForm();
			if (\Yii::$app->request->isPost) {
				$model->avatar = UploadedFile::getInstance($model, 'avatar');
				if ($model->validate()) {
					$uploadDir = 'upload/avatar/' . date('Ym');
					if (!file_exists($uploadDir))
						mkdir($uploadDir);
					$uploadFile = $uploadDir . '/' . $model->avatar->name;
					$model->avatar->saveAs($uploadFile);
					$model->avatar->name = '/' . $uploadFile;

					list($width, $height) = getimagesize($uploadFile);
					return $this->ajaxReturn([
						'avatar'	=>	$model->avatar->name,
						'width'	=> $width,
						'height'	=>	$height	
					]);
				}
			}
			return $this->render('/user/profile/avatar_edit', ['model'=>$model]);
		} else if (\Yii::$app->request->get('do') == 'save') {
			$avatar = \Yii::$app->request->post('avatar');
			$width = intval(\Yii::$app->request->post('width'));
			$height = intval(\Yii::$app->request->post('height'));
			$img = $this->thumb($avatar, $width, $height);

			$coords = explode(',', \Yii::$app->request->post('coords'));
			$img = $this->crop($img, $coords[0], $coords[1], [$coords[2], $coords[3]]);

			Profile::saveAvatar($img);
			return $this->ajaxReturn(['msg'=>'保存成功']);

		}
		return $this->redirect('/user/profile/avatar');	
	}
}
