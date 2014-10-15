<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\BlogForm;
use app\models\Tags;

class Blog extends ActiveRecord
{
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
}
