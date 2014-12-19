<?php

namespace app\models\sysadm;

use app\models\sysadm\CategoryForm;

class Category extends \app\models\Model
{
	const STATUS_NORMAL = 1;
	const STATUS_NO = 0;

	public static function status()
	{
		return [
			1	=>	'显示',
			0	=>	'不显示'
		];
	}

	public static function format($list)
	{
		foreach ($list as &$row)
		{
			$row['status_text'] = self::status()[$row['status']];
		}
		return $list;
	}

	public static function all()
	{
		$list = Category::find()
					->asArray()
					->all();
		return self::format($list);
	}

	public static function add(CategoryForm $form)
	{
		$category = new self();
		$category->pid = 0;
		$category->name = $form->name;
		$category->status = $form->status;
		$category->addtime = time();
		return $category->insert();
	}

	public static function edit($id, CategoryForm $form)
	{
		$category = Category::findOne($id);
		if (!$category)
			return false;
		$category->name = $form->name;
		$category->status = $form->status;
		return $category->save();
	}
}
