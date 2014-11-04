<?php

namespace app\models\user;

use app\models\user\BlogForm;
use app\models\Tags;
use app\models\Category;

class Blog extends \app\models\Blog 
{
	//博客图片裁剪宽度
	const IMG_THUMB_WIDTH = 350;

	public static function all($limit = 10, $status = 'all')
	{
		$where['uid'] = \Yii::$app->user->getId();
		if ($status != 'all')
			$where['status'] = parent::STATUS_PUBLISH;

		return parent::_list($where, $limit);
	}

	public static function detail($id, array $condition = [])
	{
		return parent::detail($id, ['b.uid'=>\Yii::$app->user->getId()]);
	}

	public static function analyse($content)
	{
		$data = [
			'image'	=>	'',
			'thumb'	=>	'',
			'description' => ''
		];

		preg_match('/<img\s+src="([^"]+)"/', $content, $matches);
		if ($matches[1]) {
			$data['image'] = $matches[1];
			$data['thumb'] = \Yii::$app->util->thumbByWidth($data['image'], self::IMG_THUMB_WIDTH);
		}
		$content = strip_tags($content);
		if (($end = strpos($content, '。')) !== false) {
			if ($end < 50)
				$end = 200;
			$content = mb_substr($content, 0, $end, 'utf-8');
		}
		$data['description'] = $content;

		return $data;
	}

	public static function add(BlogForm $blogform)
	{
		$blog = new Blog();
		$blog->uid = \Yii::$app->user->getId();
		$blog->title = htmlspecialchars($blogform->title);

		$blog->content = htmlspecialchars($blogform->content);
		$blog->tags = $blogform->tags;
		$blog->cid = $blogform->cid ? $blogform->cid : 0;

		$blog->status = $blogform->status ? $blogform->status : self::STATUS_PUBLISH;
		$blog->is_private = $blogform->is_private ? $blogform->is_private : 0;
		$blog->allow_review = $blogform->allow_review ? $blogform->allow_review : 1;
		$blog->addtime = $blog->uptime = time();

		$analyse = self::analyse($blogform->content);
		if (!$blogform->description) {
			$blog->description = $analyse['description'];
		} else {
			$blog->description = $blogform->description;
		}
		//$blog->image = $blogform->image ? $blogform->image : $analyse['image'];
		$blog->image = $analyse['image'];
		$blog->thumb = $analyse['thumb'];

		$result = $blog->insert();

		if ($result) {
			Tags::add($blog->tags, $blog->id);
			if ($blog->status == self::STATUS_PUBLISH)
				Category::countInc($blog->cid);
			return true;
		} else {
			return false;
		}
	}


	public static function edit(BlogForm $blogform)
	{
		$uid = \Yii::$app->user->getId();
		$blog = Blog::findOne(['id'=>$blogform->id, 'uid'=>$uid]);
		$blog->title = htmlspecialchars($blogform->title);
		$blog->content = htmlspecialchars($blogform->content);
		if ($blog->tags != $blogform->tags) {
			$updateTags = true;
		}
		/*
		if ($blogform->status == self::STATUS_PUBLISH && $blog->status != self::STATUS_PUBLISH) {
			$countInc = true;
		}
		if ($blogform->status != self::STATUS_PUBLISH && $blog->status == self::STATUS_PUBLISH) {
			$countDec = true;
		}
		 */
		$analyse = self::analyse($blogform->content);
		if (!$blogform->description) {
			$blog->description = $analyse['description'];
		} else {
			$blog->description = $blogform->description;
		}
		//$blog->image = $blogform->image ? $blogform->image : $analyse['image'];
		$blog->image = $analyse['image'];
		$blog->thumb = $analyse['thumb'];

		$blog->tags = $blogform->tags;
		$blog->cid = $blogform->cid;

		$blog->status = $blogform->status ? $blogform->status : self::STATUS_PUBLISH;
		$blog->is_private = is_numeric($blogform->is_private) ? $blogform->is_private : 0;
		$blog->allow_review = is_numeric($blogform->allow_review) ? $blogform->allow_review : 1;
		$blog->uptime = time();
		$res = $blog->save();
		if ($res) {
			if (isset($updateTags) && $updateTags) {
				Tags::removeByBlogId($id);
				Tags::add($blog->tags, $id);
			}
			return true;
		}
		return false;
	}
}
