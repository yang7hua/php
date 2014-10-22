<?php
namespace app\models;

use yii\db\ActiveRecord;

//网站相关信息
class Site
{
	public $info = null;

	public function __construct()
	{
		$this->info = new Info();
	}
}

class Info
{
	public $sitename = '522802009';

}
