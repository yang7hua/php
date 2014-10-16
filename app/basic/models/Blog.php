<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\BlogForm;
use app\models\Tags;
use yii\data\Pagination;
use yii\web\UrlManager;

class Blog extends ActiveRecord
{
	const STATUS_PUBLISH	= 'publish';
	const STATUS_SKETCH		= 'sketch';
	const STATUS_TRASH		= 'trash';
	const STATUS_DELETED	= 'deleted';

	public static function tableName()
	{
		return 'blogs';
	}

	public static function add(BlogForm $blogform)
	{
		$blog = new Blog();
		$blog->uid = \Yii::$app->user->getId();
		$blog->title = htmlspecialchars($blogform->title);
		$blog->content = htmlspecialchars($blogform->content);
		$blog->tags = $blogform->tags;
		$blog->status = $blogform->status ? $blogform->status : 'sketch';
		$blog->is_private = $blogform->is_private ? $blogform->is_private : 0;
		$blog->allow_review = $blogform->allow_review ? $blogform->allow_review : 1;
		$blog->addtime = $blog->uptime = time();

		$result = $blog->insert();

		if ($result) {
			Tags::add($blog->tags, $blog->id);
			return true;
		} else {
			return false;
		}
	}

	public static function _list()
	{
		$query = Blog::find()->where(['status'=>Blog::STATUS_SKETCH]);
		$countQuery = clone $query;
		$pages = new Pagination([
			'totalCount' => $countQuery->count(), 
			'defaultPageSize' => 1,
			/*
			'route'	=>	'/user/?<:page>',
			'urlManager'	=>	new UrlManager([
				'enablePrettyUrl' => true,
				'showScriptName'	=>	false,
				'rules'	=>	[
				]
			])
			*/
		]);
		$data = $query->offset($pages->offset)
						->limit($pages->limit)
						->all();
		return [
			'list'	=>	$data,
			'pages'	=>	$pages
		];
	}
}
