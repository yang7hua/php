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

	static $select_fields_list = ['id', 'cid', 'uid', 'title', 'addtime', 'tags', 'read', 'comment', 'description', 'image'];

	public static function tableName()
	{
		return 'blogs';
	}

	public static function analyse($content)
	{
		$data = [
			'image'	=>	'',
			'description' => ''
		];

		preg_match('/<img\s+src="([^"]+)"/', $content, $matches);
		if ($matches[1])
			$data['image'] = $matches[1];
		$content = strip_tags($content);
		if (($end = strpos($content, '。')) !== false) {
			if ($end < 50)
				$end = 100;
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
		$blog->description = $analyse['description'];
		//$blog->image = $blogform->image ? $blogform->image : $analyse['image'];
		$blog->image = $analyse['image'];

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

	public static function getListByCid($cid, $limit = 10, $status = Blog::STATUS_PUBLISH)
	{
		$where['status'] = $status;
		$where['cid'] = $cid;
		$where['is_private'] = 0;

		$query = Blog::find()->where($where)->select(self::$select_fields_list);
		$list = $query->limit($limit)
						->orderBy(['addtime'=>SORT_DESC])
						->asArray()
						->all();
		return [
			'list'	=> self::format($list)
		];
	}

	public static function getListByImg($limit = 5)
	{
		$where['status'] = Blog::STATUS_PUBLISH;
		$where['image'] = ['!='=>''];

		$query = Blog::find()->where($where)->select(self::$select_fields_list);
		$list = $query->limit($limit)
						->orderBy(['addtime'=>SORT_DESC])
						->asArray()
						->all();
		return [
			'list'	=>	self::format($list)
		];
	}

	public static function getListByAddtime($limit = 10)
	{
		$where['status'] = Blog::STATUS_PUBLISH;
		$list = Blog::find()->where($where)
							->select(self::$select_fields_list)
							->limit($limit)
							->orderBy(['addtime'=>SORT_DESC])
							->asArray()
							->all();
		return [
			'list' => self::format($list)
		];
	}

	//显示在主页的项目
	public static function homeList($limit = 10)
	{
		$category = Category::homeList();
		foreach ($category as &$c) {
			$list = Blog::find()
								->select(self::$select_fields_list)
								->where(['status'=>self::STATUS_PUBLISH, 'cid'=>$c['cid']])
								->limit($limit)	
								->orderBy(['addtime'=>SORT_DESC])
								->asArray()
								->all();
			$c['list'] = self::format($list);
		}
		return $category;
	}

	//文章详情
	public static function detail($id)
	{
		return Blog::find()
					->from('blogs b')
					->where(['id'=>$id])
					->leftJoin('category c', 'c.cid = b.cid')	
					->select('b.*, c.name, c.cid')
					->asArray()
					->one();
	}

	//点击+1
	public static function readInc($id, $point = 1)
	{
		$blog = Blog::findOne($id);
		$blog->read = $blog->read + $point;
		$blog->save();
	}

	//标签显示
	public static function showTags($tags)
	{
		$tags = explode(',', $tags);
		$html = '标签:&nbsp;';
		foreach ($tags as $tag) {
			$html .= '&nbsp;<a href="/tags/'.$tag.'">'.$tag.'</a>';
		}
		return $html;
	}

	//所有分类
	public static function categories($limit = 5)
	{
		return Category::all();
	}

	//热门
	public static function hotList($limit = 10)
	{
		$list = Blog::find()
				->select('b.*, c.name')
				->from('blogs b')
				->leftJoin('category c', 'c.cid=b.cid')
				->limit($limit)
				->orderBy(['read'=>SORT_DESC, 'addtime'=>SORT_DESC])
				->asArray()
				->all();
		return [
			'list' => self::format($list)
		];
	}

	public static function format($data) 
	{
		foreach ($data as &$row) {
			if ($row['content'])
				$row['content'] = htmlspecialchars_decode($row['content']);
			$row['url'] = '/blog/' . $row['id'];
		}
		return $data;
	}

	public static function prev($id, $cid = 0)
	{
		$where = 'id < '.$id;
		if ($cid)
			$where .= ' and cid='.$cid;

		$info = Blog::find()
					->select(['id', 'title'])
					->where($where)
					->asArray()
					->one();
		return $info ? self::format([$info])[0] : false;
	}

	public static function next($id, $cid = 0)
	{
		$where = 'id > '.$id;
		if ($cid)
			$where .= ' and cid='.$cid;

		$info = Blog::find()
					->select(['id', 'title'])
					->where($where)
					->asArray()
					->one();
		return $info ? self::format([$info])[0] : false;
	}
}
