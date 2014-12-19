<?php

namespace app\models\sysadm;

class Menubar extends \app\models\Model
{
	public static function all()
	{
		return [
			['id'	=>	1,	'text'	=>	'系统管理', 'pid'	=>	0],
			['id'	=>	11,	'text'	=>	'网站设置', 'pid'	=>	1, 'controller'	=>	'config', 'action'	=>	'site'],
			['id'	=>	12, 'text'	=>	'系统设置', 'pid'	=>	1, 'controller'	=>	'config', 'action'	=>	'sys'],

			['id'	=>	3,	'text'	=>	'菜单管理', 'pid'	=>	0],
			['id'	=>	31, 'text'	=>	'菜单分类', 'pid'	=>	3, 'controller'	=>	'category',	'action'	=>	'list'],
			['id'	=>	33, 'text'	=>	'菜单列表', 'pid'	=>	3, 'controller'	=>	'menu',	'action'	=>	'list'],
			['id'	=>	36, 'text'	=>	'套餐列表', 'pid'	=>	3, 'controller'	=>	'group', 'action'	=>	'list'],

			['id'	=>	5,	'text'	=>	'用户管理', 'pid'	=>	0],
			['id'	=>	51, 'text'	=>	'用户列表', 'pid'	=>	5, 'controller'	=>	'user', 'action'	=>	'list'],
			['id'	=>	53, 'text'	=>	'积分管理', 'pid'	=>	5, 'controller'	=>	'score', 'action'	=>	'list'],

			['id'	=>	6,	'text'	=>	'订单管理', 'pid'	=>	0],
			['id'	=>	63, 'text'	=>	'订单列表', 'pid'	=>	6, 'controller'	=>	'order',	'action'	=>	'list'],

		];
	}

	public static function tree()
	{
		$menus = self::all();

		$tree = [];
		foreach ($menus as $menu)
		{
			$menu['url'] = \Yii::$app->func->admUrl($menu['controller'] . '/' . $menu['action']);
			if ($menu['pid'] == 0):
				$menu['child'] = [];
				$tree[$menu['id']] = $menu;
			else:
				if (array_key_exists($menu['pid'], $tree)):
					$tree[$menu['pid']]['child'][$menu['id']] = $menu;
				endif;
			endif;
		}
		return $tree;
	}

	public static function output()
	{
		$menus = self::tree();

		$output = '';
		foreach ($menus as $menu):	
			$output .= "<h5 id='menu_{$menu['id']}'>{$menu['text']}</h5>";
			if ($menu['child']):
				$output .= '<ul>';
				foreach ($menu['child'] as $child):
					$output .= "<li controller='{$child['controller']}' action='{$child['action']}' id='child_{$child['id']}'><a href='{$child['url']}'>{$child['text']}</a></li>";
				endforeach;
				$output .= '</ul>';
			endif;
		endforeach;

		return $output;
	}

}
