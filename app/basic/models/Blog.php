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

	static $select_fields_list = ['id', 'cid', 'uid', 'title', 'addtime', 'tags', 
		'read', 'comment', 'description', 'image', 'is_private', 'allow_review',
		'status', 'is_focus'];

	public static function tableName()
	{
		return 'blogs';
	}

	public static function status()
	{
		return [
			self::STATUS_PUBLISH => '发布',	
			self::STATUS_SKETCH	=> '草稿',	
			self::STATUS_TRASH => '回收站',	
		//	self::STATUS_DELETED => '删除'
		];
	}

	public static function _list($where, $limit = 10, $orderBy = ['uptime'=>SORT_DESC], $select = [])
	{
		if (empty($select))
			$select = self::$select_fields_list;
		$query = Blog::find()->where($where)->select($select);

		$count = $query->count();
		$pagination = new Pagination([
			'defaultPageSize'	=>	$limit,
			'totalCount'	=>	$count
		]);

		$list = $query->offset($pagination->offset)
					->limit($pagination->limit)
					->orderBy($orderBy)
					->asArray()
					->all();
		return [
			'list'	=>	self::format($list),
			'page'	=>	$pagination
		];
	}

	//通过分类ID获取
	public static function getListByCid($cid, $limit = 10, $status = Blog::STATUS_PUBLISH)
	{
		$where['status'] = $status;
		$where['cid'] = $cid;
		$where['is_private'] = 0;

		return self::_list($where, $limit);
	}

	public static function getListByAddtime($limit = 10)
	{
		$where['status'] = Blog::STATUS_PUBLISH;
		$where['is_private'] = 0;

		return self::_list($where, $limit);
	}

	//显示在主页的项目
	public static function homeList($limit = 10)
	{
		$category = Category::homeList();
		foreach ($category as &$c) {
			$list = self::_list(['status'=>self::STATUS_PUBLISH, 'cid'=>$c['cid'], 'is_private'=>0], $limit)['list'];
			$c['list'] = $list;
		}
		return $category;
	}

	//文章详情
	public static function detail($id, array $condition = [])
	{
		$where['id'] = intval($id);
		if ($condition)
			$where = array_merge($where, $condition);
		$info = Blog::find()
					->from('blogs b')
					->where($where)
					->leftJoin('category c', 'c.cid = b.cid')	
					->select('b.*, c.name, c.cid')
					->asArray()
					->one();
		return self::format([$info])[0];
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
	public static function categories($uid = 0)
	{
		return Category::all($uid);
	}

	//热门
	public static function hotList($limit = 10)
	{
		/*
		$list = Blog::find()
				->select('b.*, c.name')
				->from('blogs b')
				->where(['b.is_private'=>0, 'status'=>Blog::STATUS_PUBLISH])
				->leftJoin('category c', 'c.cid=b.cid')
				->limit($limit)
				->orderBy(['read'=>SORT_DESC, 'uptime'=>SORT_DESC])
				->asArray()
				->all();
		return [
			'list' => self::format($list)
		];
		*/

		return self::_list(['is_private'=>0, 'status'=>self::STATUS_PUBLISH], 10, ['read'=>SORT_DESC, 'uptime'=>SORT_DESC]);
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
		$where .= ' and status=\''.self::STATUS_PUBLISH.'\' and is_private=0';

		$info = Blog::find()
					->select(['id', 'title'])
					->where($where)
					->asArray()
					->orderBy(['id'=>SORT_DESC])
					->one();
		return $info ? self::format([$info])[0] : false;
	}

	public static function next($id, $cid = 0)
	{
		$where = 'id > '.$id;
		if ($cid)
			$where .= ' and cid='.$cid;
		$where .= ' and status=\''.self::STATUS_PUBLISH.'\' and is_private=0';

		$info = Blog::find()
					->select(['id', 'title'])
					->where($where)
					->asArray()
					->orderBy(['id'=>SORT_ASC])
					->one();
		return $info ? self::format([$info])[0] : false;
	}

	public static function baseInfo($id)
	{
		$id = intval($id);
		return Blog::find()
				->where(['id'=>$id])
				->select(self::$select_fields_list)
				->asArray()
				->one();
	}
}
