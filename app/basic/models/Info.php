<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\user\site\InfoForm;

class Info extends ActiveRecord
{
	const TYPE_SITE = 1;
	const TYPE_FOCUS = 2;

	public static function tableName()
	{
		return 'info';
	}

	public static function updateSiteinfo($keys, InfoForm $form)
	{
		foreach ($keys as $key) {
			self::up($key, self::TYPE_SITE, $form->{$key});
		}
		return true;
	}

	public static function up($key, $type, $value)
	{
		$where = [
			'key'	=>	$key,
			'type'	=>	$type
		];
		$info = Info::find()
			->where($where)
			->one();
		if (!$info) {
			return self::add($key, $type, $value);
		}
		$info->value = $value;
		return $info->save();
	}

	public static function add($key, $type, $value)
	{
		$info = new Info();
		$info->key = $key;
		$info->type = $type;
		$info->value = $value;
		return $info->save();
	}

	//获取网站配置信息
	public static function siteInfo()
	{
		$data = Info::find()
				->where(['type'=>self::TYPE_SITE])
				->asArray()
				->all();
		return self::format($data);
	}

	//获取首页焦点图
	public static function indexFocus()
	{
		$data = Info::find()
				->where(['key'=>'index', 'type'=>self::TYPE_FOCUS])
				->asArray()
				->all();
	}

	public static function format($data)
	{
		$return = [];
		foreach ($data as $row) {
			$return[$row['key']] = $row['value'];
		}
		return $return;
	}
}
