<?php

namespace app\models\user;

use yii\base\Model;
use app\models\user\Blog;
use app\models\Tags;

class BlogForm extends Model
{
	public $id;
	public $title;
	public $cid;
	public $tags;
	public $content;
	public $description;
	public $allow_review;
	public $is_private;
	public $status;

	public function attributeLabels() 
	{
		return [
			'title'	=>	'标题',
			'cid'	=>	'分类',
			'tags'	=>	'标签',
			'content'	=>	'内容',
			'description'	=>	'描述',
			'allow_review'	=>	'允许评论',
			'is_private'	=>	'仅自己可见'
		];
	}

	public function safeAttributes()
	{
		return [
			'id','title','cid','tags','title','content','description','allow_review','is_private','status'
		];
	}

	public function rules()
	{
		return [
			[['title', 'cid', 'content', 'tags'], 'required'],
			['title', 'string', 'min'=>5, 'max'=>25],
			['tags', 'validateTags']
		];
	}

	public function validateTags($attribute, $params)
	{
		if (!Tags::validateTags($this->tags))
			$this->addError($attribute, Tags::ERROR_MSG);
	}

	public function add()
	{
		if ($this->validate()) {
			$data = [
				'cid'	=>	$this->cid,
				'title'	=>	$this->title,
				'content'	=>	$this->content,
				'status'	=>	'publish',
				'tags'	=>	$this->tags,
				'allow_review'	=>	$this->allow_review ? $this-allow_review : 1,
				'is_private'	=>	$this->is_private ? $this->is_private : 0
			];
			return Blog::add($this);
		}
		return false;
	}

	public function save($id)
	{
		if ($this->validate()) {
			return Blog::edit($this);
		}
		return false;
	}
}
