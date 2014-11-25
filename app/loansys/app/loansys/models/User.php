<?php

class User extends Model
{


	protected function rawFields()
	{
		//return ['lid', 'contact_info', 'child_info', 'spouse_name', 'spouse_idcard', 'spouse_info', 'gender', 'birthdate'];
		return [];
	}

	public static function add($data, $lastInsID = false)
	{
		$user = new User();
		$data['addtime'] = time();
		//$data['lid'] = \Func\uniqidByTime();
		foreach ($data as $key=>$val) {
			$user->{$key}	=	$val;
		}
		if ($user->create()) {
			return $lastInsID ? $user->uid : true;
		}
		return false;
	}

	public static function editByUid($uid, $data)
	{
		$uinfo = User::findFirst($uid);
		if (!$uinfo)
			return false;
		foreach ($data as $field=>$value) {
			$uinfo->$field = $value;
		}
		if ($uinfo->update())
			return true;
	}

	public static function select($conditions, $limit = 10)
	{
		$condition = self::buildConditions($conditions);

		$query = User::query();
		$result = $query->where($condition)
				->join('Loan', 'Loan.uid = User.uid')
				->limit($limit)
				->columns(self::columns())
				->orderBy('User.addtime desc')
				->execute();
		if ($result)
			return Loan::format($result->toArray());
	}

	public static function buildConditions($conditions)
	{
		$_conditions = [];
		foreach ($conditions as $field=>$value)
		{
			if (is_string($value))
				array_push($_conditions, "User.$field = '$value'");
			else
				array_push($_conditions, "User.$field = $value");
		}
		return implode(' and ', $_conditions);
	}

	public static function getLoanByOid($oid, $limit = 10)
	{
		return self::select(['oid'=>$oid], $limit);
	}

	public static function columns()
	{
		return 'User.uid, User.realname, User.idcard, User.addtime, User.mobile, 
						Loan.amount, Loan.deadline, Loan.use_type, Loan.repay_method, 
						Loan.deadline_type, Loan.lid, Loan.loan_type, Loan.status';
	}
}
