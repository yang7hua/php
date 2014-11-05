<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Blog;
use yii\data\Pagination;

class Review extends ActiveRecord
{
	public static function add($data, $returnInfo = false)
	{
		$review = new Review();

		$uid = \Yii::$app->user->getId();
		if ($uid)
			$review->uid = $uid;

		$review->pid = $data['pid'];
		$review->blog_id = $data['blog_id'];
		$review->nickname = $data['nickname'];
		$review->content = htmlspecialchars(strip_tags($data['content']));
		$review->time = time();

		$result = $review->insert();
		if ($result) {
			Blog::reviewInc($review->blog_id);
			if ($returnInfo)
				return $review;
		}
		return $result;
	}

	public static function getListByBlogId($blog_id, $p = 1, $pageSize = 30)
	{
		$blog_id = intval($blog_id);
		$query = Review::find()->where(['blog_id'=>$blog_id]);
		$count = $query->count();

		$pagination = new Pagination([
			'defaultPageSize'	=> $pageSize,
			'totalCount'	=>	$count
		]);

		$list = $query->offset($pagination->offset)
					->limit($pagination->limit)
					->orderBy(['time'=>SORT_ASC])
					->asArray()
					->limit($pageSize)
					->all();
		return ['list'=>$list];
	}
}
