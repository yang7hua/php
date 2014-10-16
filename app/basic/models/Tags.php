<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tags extends ActiveRecord
{
	//标签规则
	static $pattern = '/^[\x{4E00}-\x{9Fa5}A-Za-z,]*$/u';

	const ERROR_MSG = '标签只能包含字母或汉字，多个请用\',\'分隔';

	public static function tableName()
	{
		return 'tags';
	}

	//添加标签
	public static function add($tags, $blog_id)
	{
		$data = [];
		if(Tags::validateTags($tags)) {
			$tags = explode(',', $tags);
		}
		foreach ($tags as $tag) {
			array_push($data, ['name'=>$tag, 'blog_id'=>$blog_id]);
		}

		parent::getDb()->createCommand()
				->batchInsert(self::tableName(), ['name', 'blog_id'], $data)
				->execute();
	}

	public static function validateTags($tags) 
	{
		return preg_match(self::$pattern, $tags);
	}
}
