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

	//初稿
	public static function sketches($conditions, $limit = 10, $offset = 0)
	{
		$condition = self::buildConditions($conditions);

		$query = User::query();
		$result = $query->where($condition)
				->join('LoanSketch', 'L.uid = User.uid', 'L')
				->limit($limit, $offset)
				->columns(self::columns())
				->orderBy('User.addtime desc')
				->execute();
		if ($result)
			return Loan::format($result->toArray());
	}

	public static function buildConditions($conditions = [])
	{
		$_conditions = [];
		if (empty($conditions) || !is_array($conditions))
			return '';
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

	public static function columns($level = ['base'])
	{
		$base = 'User.uid, User.bid, User.oid, User.realname, User.idcard, User.addtime, User.mobile, 
						L.amount, L.deadline, L.use_type, L.repay_method, 
						L.deadline_type, L.lid, L.loan_type, L.status,
						User.spouse_name, User.spouse_idcard, User.spouse_mobile';
		$oinfo = 'O.username oname, B.name bname';
		$morebase = 'User.idcard_province, User.idcard_city, User.province, User.city, User.address,
					User.info, User.marriage, User.have_child, User.spouse_name, User.spouse_idcard,
					User.spouse_info, L.use_type_info, L.repay_source';

		$columns = [];
		foreach ($level as $row)
		{
			$columns[] = ${$row};
		}

		return implode(' ,', $columns);
	}

	public static function getCount($conditions, $model = 'Loan')
	{
		$condition = self::buildConditions($conditions);

		$query = User::query();
		$result = $query->where($condition)
				->join($model, 'L.uid = User.uid', 'L')
				->columns(self::columns())
				->orderBy('User.addtime desc')
				->execute();
		return $result->count();
	}

	public static function getSketchCount($conditions)
	{
		return self::getCount($conditions, 'LoanSketch');
	}

	public static function sketchInfo($uid, $level = ['base'])
	{
		$conditions['uid'] = $uid;
		$condition = self::buildConditions($conditions);

		$query = User::query();
		$result = $query->where($condition)
				->leftJoin('LoanSketch', 'L.uid = User.uid', 'L')
				->leftJoin('Operator', 'User.oid=O.oid', 'O')
				->leftJoin('Branch', 'User.bid=B.bid', 'B')
				->limit(1)
				->columns(self::columns($level))
				->orderBy('User.addtime desc')
				->execute();
		if ($result)
			return Loan::format($result->toArray())[0];
		return null;
	}

	public static function detailInfo($uid)
	{
		return self::sketchInfo($uid, ['base', 'oinfo', 'morebase']);
	}

	/**
	 * 获取贷款所有信息、全国风控提交之前的数据
	 */
	public static function infos($uid, $level = '*')
	{
		$uid = intval($uid);
		$infos = [];
		$infos['user'] = self::findFirst("uid=$uid")->toArray();

		$isArray = is_array($level);
		$all = $level == '*';
		if ($all || ($isArray and in_array('loansketch', $level))) {
			$infos['loansketch'] = LoanSketch::findByUid($uid);
			$infos['loansketch_advises'] = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'loansketch');
		}

		//面审
		if ($all || ($isArray and in_array('face', $level))) {
			$infos['face'] = Face::findByUid($uid);
			$infos['face_advises'] = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'face');
		}

		//外访
		if ($all || ($isArray and in_array('visit', $level))) {
			$infos['visit'] = Visit::findByUid($uid);
			$infos['visit_advises'] = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'visit');
		}

		//车评
		if ($all || ($isArray and in_array('car', $level))) {
			$infos['car'] = Car::findByUid($uid);
			$infos['car_advises'] = Advise::getAdvisesByUid($uid, Advise::STATUS_UNDO, 'car');
		}
		if ($all || ($isArray and in_array('car_files', $level))) {
			$infos['car_files'] = Files::getFilesByUid($uid, \App\Config\Loan::uploadTypes('car'));
		}

		//贷款
		if ($all || ($isArray and in_array('loan', $level))) {
			$infos['loan'] = Loan::findByUid($uid);
		}

		return $infos;
	}

	public static function edit($uid, $data)
	{
		$User = User::findFirst("uid=$uid");
		$User->uptime = time();
		foreach ($data as $field=>$value) {
			$User->$field = $value;
		}
		return $User->update();
	}
}
