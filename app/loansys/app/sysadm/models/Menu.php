<?php

/**
 * 所有菜单
 */
class Menu extends Model
{
	private static $menus = [
		[
			'id'	=>	1,
			'pid'	=>	0,
			'name'	=>	'组织管理',
			'order'	=>	1,
			'url'	=>	'/',
		],
		[
			'id'	=>	11,
			'pid'	=>	1,
			'name'	=>	'部门管理',
			'order'	=>	1,
			'url'	=>	'/department/list',
			'controller'	=>	'department',
			'action'	=>	'list'
		],	
		[
			'id'	=>	12,
			'pid'	=>	1,
			'name'	=>	'角色管理',
			'order'	=>	3,
			'url'	=>	'/role/list',
			'controller'	=>	'role',
			'action'	=>	'list'
		],
		[
			'id'	=>	13,
			'pid'	=>	1,
			'name'	=>	'账号管理',
			'order'	=>	6,
			'url'	=>	'/operator/list',
			'controller'	=>	'operator',
			'action'	=>	'list'
		],
	];

	public static function all($format = true)
	{
		$menus = self::filter(self::$menus);
		if ($format)
			return self::tree($menus);
		else
			return $menus;
	}

	public static function filter($menus)
	{
		$su = [
			[
				'id'	=>	3,
				'pid'	=>	0,
				'name'	=>	'门店管理',
				'order'	=>	1,
				'url'	=>	'/',
			],
			[
				'id'	=>	10,
				'pid'	=>	3,
				'name'	=>	'门店列表',
				'order'	=>	1,
				'url'	=>	'/branch/list',
				'controller'	=>	'branch',
				'action'	=>	'list'
			],	
			[
				'id'	=>	11,
				'pid'	=>	3,
				'name'	=>	'管理员账号',
				'order'	=>	2,
				'url'	=>	'/admini/list',
				'controller'	=>	'admini',
				'action'	=>	'list'
			],	
		];
		if (self::isNationWideBid()) {
			$menus = array_merge($su, $menus);
		}
		/*
		foreach ($menus as $key=>$menu) {
			if (in_array($menu['controller'], $filter))
				unset($menus[$key]);
		}
		 */
		return $menus;
	}

	public static function tree($menus)
	{
		$return = [];
		foreach ($menus as $menu) {
			$menu['url'] = parent::baseUrl($menu['url']);
			if ($menu['pid'] == 0) :
				$menu['children'] = [];
				$return[$menu['id']] = $menu;
			else :
				array_push($return[$menu['pid']]['children'], $menu);
			endif;
		}
		return $return;
	}
}
