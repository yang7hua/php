<?php

namespace app\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
	public static function all($uid = 0)
	{
		if (!$uid)
			$uid = \Yii::$app->config->superId;
		$list = parent::find()
						->select(['cid', 'name', 'pid', 'count'])
						->where(['uid' => $uid])
						->asArray()
						->all();
		return self::format($list);
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
		return parent::findOne(['name'=>$name, 'uid'=>\Yii::$app->config->superId]);
	}

	public static function getName($cid)
	{
		return Category::find()
				->select(['name'])
				->where(['cid'=>$cid])
				->asArray()
				->one()['name'];
	}

	public static function countInc($cid, $point=1)
	{
		$category = Category::findOne(['cid'=>$cid, 'uid'=>\Yii::$app->user->getId()]);
		$category->count = $category->count+1;
		$category->save();
	}

	public static function homeList()
	{
		$list = parent::find()
			->select(['cid', 'name', 'home', 'count'])
			->where(['home'=>1, 'uid'=>\Yii::$app->config->superId])
			->asArray()
			->all();
		return self::format($list);
	}

	public static function url($cid)
	{
		return '/topic/' . $cid;
	}

	public static function format($data)
	{
		foreach ($data as &$row) {
			$row['url'] = self::url($row['cid']);
		}
		return $data;
	}
}
