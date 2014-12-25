<?php

namespace app\models\sysadm;

use app\models\sysadm\MenuForm;

class Menu extends \app\models\Model
{
	public static function status()
	{
		return [
			1	=>	'上架',
			10	=>	'下架'
		];
	}

	public static function peppery()
	{
		return [
			0	=>	'不辣',
			1	=>	'1',
			2	=>	'2',
			3	=>	'3',
			4	=>	'4',
			5	=>	'5'
		];
	}

	//分类
	public static function categories()
	{
		$categories = Category::find(['status'	=>	Category::STATUS_NORMAL])
			->asArray()
			->select('cid,name')
			->all();

		$options = [''	=>	'请选择'];
		if (!$categories)
			return $options;

		foreach ($categories as $row)
		{
			$options[$row['cid']] = $row['name'];
		}
		return $options;
	}

	//活动
	public static function activities()
	{
		$options = ['0'	=>	'无'];
		return $options;
	}

	//新品
	public static function newOptions()
	{
		return [
			1	=>	'是',
			0	=>	'否'
		];
	}

	//供应时间
	public static function provideOptions()
	{
		return [
			0	=>	'全天',
			1	=>	'上午',	
			10	=>	'下午'
		];
	}

	public static function all()
	{
		$list = Menu::find()
				->from('sys_menu b')
				->leftJoin('sys_category c', 'c.cid=b.cid')
				->select('c.name, b.*')
				->asArray()
				->all();
		return self::format($list);
	}

	public static function format($list)
	{
		foreach ($list as &$row)
		{
			$row['status_text'] = self::status()[$row['status']];
			$row['provide_time_text'] = self::provideOptions()[$row['provide_time']];
		}
		return $list;
	}

	public static function add(MenuForm $form)
	{
		$menu = new self();

		$menu->cid = $form->cid;
		$menu->aid = $form->aid;
		$menu->title = $form->title;
		$menu->price = $form->price;
		$menu->favorable_price = $form->favorable_price;
		$menu->img = '';
		$menu->new = $form->new;
		$menu->provide_time	= $form->provide_time;
		$menu->peppery = $form->peppery;
		$menu->status = $form->status;
		$menu->addtime = time();

		return $menu->insert();
	}

	public static function edit($id, MenuForm $form)
	{
		$menu = Menu::findOne($id);
		if (!$menu)
			return false;
		$menu->cid = $form->cid;
		$menu->aid = $form->aid;
		$menu->title = $form->title;
		$menu->price = $form->price;
		$menu->favorable_price = $form->favorable_price;
		$menu->new = $form->new;
		$menu->provide_time	= $form->provide_time;
		$menu->peppery = $form->peppery;
		$menu->status = $form->status;

		return $menu->save();
	}
}
