<?php

class Files extends Model
{

	public function add($data)
	{
		$data['addtime'] = time();
		$File = new Files();
		foreach ($data as $field=>$value)
		{
			$File->$field = $value;
		}
		if (!$File->create()) {
			$this->outputErrors($File);
			return false;
		}
		return true;
	}

	public static function getFilesByUid($uid, $type = 0, $limit = [10, 0])
	{
		$condition = 'uid='.intval($uid);
		if ($type) {
			$condition .= ' and type='.$type;
		}	
		$files = self::query()
				->columns('*')
				->where($condition)
				->limit($limit[0], $limit[1])
				->orderBy('id asc')
				->execute()
				->toArray();
		return $files;
	}

}
