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
			'url'	=>	'/'
		],
		[
			'id'	=>	11,
			'pid'	=>	1,
			'name'	=>	'部门管理',
			'order'	=>	1,
			'url'	=>	'/department/list'
		],	
		[
			'id'	=>	12,
			'pid'	=>	1,
			'name'	=>	'角色管理',
			'order'	=>	3,
			'url'	=>	'/role/list'
		],
		[
			'id'	=>	13,
			'pid'	=>	1,
			'name'	=>	'成员管理',
			'order'	=>	6,
			'url'	=>	'/operator/list'
		],
	];

	public static function all()
	{
		return self::tree(self::$menus);
	}

	public static function format($menus)
	{
		foreach ($menus as &$menu) {
			$menu['url'] = parent::baseUrl($menu['url']);
		}
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
