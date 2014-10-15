<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
	public static function all()
	{
		return parent::findAll(['uid' => \Yii::$app->user->getId()]);
	}
}
