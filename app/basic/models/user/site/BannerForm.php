<?php

namespace app\models\user\site;

use app\models\Banner;

class BannerForm extends Banner 
{
	public $name;
	public $url;
	public $pid = 0;
	public $sortno = 0;

	public function attributeLabels()
	{
		return [
			'name'	=>	'名称',
			'url'	=>	'URL',
			'pid'	=>	'父级导航',
			'sortno'	=>	'排序'
		];
	}

	public function rules()
	{
		return [
			[['name', 'url'], 'required'],
			['name', 'uniquedName']
		];
	}

	public function safeAttributes()
	{
		return [
			'name', 'url', 'pid', 'sortno'
		];
	}

	public function uniquedName($attribute, $params)
	{
		if (!$this->hasErrors()) {
			$banner = Banner::findOne(['name'=>$this->name]);
			if ($banner)
				$this->addError($attribute, '该导航名已存在');
		}
	}

	public function add()
	{
		$banner = new Banner;
		$banner->name = $this->name;
		$banner->url = $this->url;
		$banner->pid = intval($this->pid);
		$banner->sortno = intval($this->sortno);
		return $banner->insert();
	}

	public static function pids()
	{
		$pids = Banner::find()
				->where(['pid'=>0])
				->asArray()
				->all();

		$data = [0=>'无'];
		if (!$pids)
			return $data;
		foreach ($pids as $pid) {
			$data[$pid['id']] = $pid['name'];
		}
		return $data;
	}
}
