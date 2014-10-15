<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
	public static function all()
	{
		return parent::findAll(['uid' => \Yii::$app->user->getId()]);
	}

	public static function add($data)
	{
		$Category = new Category();
		$Category->uid = \Yii::$app->user->getId();
		$Category->name = $data['name'];
		$Category->pid = $data['pid'];
		return $Category->insert();
	}

	public static function findByName($name)
	{
		return parent::findOne(['name'=>$name, 'uid'=>\Yii::$app->user->getId()]);
	}
}
