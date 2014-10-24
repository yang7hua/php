<?php

namespace app\models\user\site;


class Focus extends \app\models\Focus
{
	public static function add($data)
	{
		$model = new Focus();
		$model->title = $data['title'];
		$model->blog_id = $data['blog_id'];
		$model->image = $data['image'];
		$model->type = $data['type'];
		return $model->insert();
	}

	public static function exist($blog_id, $type)
	{
		return Focus::find()
					->select(['id'])
					->where(['blog_id'=>$blog_id, 'type'=>$type])
					->one();
	}

	public static function existByImage($image)
	{
		return Focus::find()
					->select('id')
					->where(['image'=>$image])
					->one();
	}
}
