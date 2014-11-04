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
		'status', 'is_focus', 'uptime', 'thumb'];

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
		$where['cid'] = $cid;
		$where['status'] = $status;
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
			$html .= '&nbsp;<a class="primary" href="/tag/'.$tag.'">'.$tag.'</a>';
		}
		return $html;
	}

	//所有分类
	public static function categories($uid = 0)
	{
		return Category::all($uid);
	}

	//最新
	public static function newList($limit = 10)
	{
		//return self::_list(['status'=>self::STATUS_PUBLISH, 'is_private'=>0], 10, ['read'=>SORT_DESC, 'uptime'=>SORT_DESC]);
		$list = Blog::find()
				->from('blogs b')
				->select('b.id, b.cid, b.title, b.description, b.image, b.thumb, b.uptime, b.comment, b.read, c.name')
				->where(['b.status'=>self::STATUS_PUBLISH, 'b.is_private'=>0])	
				->orderBy(['b.uptime'=>SORT_DESC])
				->leftJoin('category c', 'c.cid=b.cid')
				->limit($limit)
				->asArray()
				->all();
		return self::format($list);
	}

	public static function format($data) 
	{
		foreach ($data as &$row) {
			if ($row['content'])
				$row['content'] = htmlspecialchars_decode($row['content']);
			$row['url'] = self::url($row['id']);
			if ($row['cid'])
				$row['c_url'] = Category::url($row['cid']);
		}
		return $data;
	}

	public static function url($id)
	{
		return '/blog/' . $id;
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

	public static function search($keyword)
	{
		$where = ['and', ['status'=>self::STATUS_PUBLISH, 'is_private'=>0], 'title like \'%'.$keyword.'%\''];
		return self::_list($where);
	}

	public static function getByIds(array $ids)
	{
		$where = ['and', ['status'=>self::STATUS_PUBLISH, 'is_private'=>0], ['in', 'id', $ids]];
		return self::_list($where);
	}
}
