<?php

namespace app\models;

use yii\db\ActiveRecord;

class Banner extends ActiveRecord
{

	public static function tableName()
	{
		return 'banner';
	}


	public static function getBanner()
	{
		$data = Banner::find()
					->orderBy(['sortno'=>SORT_ASC, 'id'=>SORT_DESC])
					->asArray()
					->all();
		return self::format($data);
	}

	//层次关系排列
	public static function format($data)
	{
		$banners = [];
		$childs = [];
		foreach ($data as $row) {
			if ($row['pid'] == 0)
				$banners[$row['id']] = $row;
			else
				$childs[] = $row;
		}
		if (!empty($childs)) {
			foreach ($childs as $child) {
				$banners[$child['pid']]['child'][$child['id']] = $child;
			}
		}
		return $banners;
	}

}
