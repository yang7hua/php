<?php

namespace app\models;

use yii\base\Model;

class BlogForm extends Model
{
	public $title;
	public $cid;
	public $tags;
	public $content;
	public $allow_review;
	public $is_private;

	public function attributeLabels() 
	{
		return [
			'title'	=>	'标题',
			'cid'	=>	'分类',
			'tags'	=>	'标签',
			'content'	=>	'内容',
			'allow_review'	=>	'允许评论',
			'is_private'	=>	'仅自己可见'
		];
	}
}
