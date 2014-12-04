<?php

class LoanSketch extends Model
{

	public function getSource()
	{
		global $config;
		return $config->database->prefix . 'loan_sketch';
	}

	public static function add($data, $lastInsId = false)
	{
		$Loan = new LoanSketch();
		$data['addtime'] = time();
		foreach ($data as $field=>$value)
		{
			$Loan->{$field} = $value;
		}
		if ($Loan->create())
		{
			return $lastInsId ? $Loan->lid : true;
		}
		$this->outputErrors($Loan);
		return false;
	}

	//更新初稿案件的状态
	public static function updateStatus($uid, $status)
	{
		$info = LoanSketch::findFirst("uid=$uid");
		if (!$info)
			return false;

		//面审
		if ($status == \App\LoanStatus::getStatusFace())
		{
		}
		//实地外访
		else if ($status == \App\LoanStatus::getStatusVisit() and \App\LoanStatus::hasCarAssess($info->status))
		{
			$status = \App\LoanStatus::getStatusChecked();
		}
		//车评
		else if ($status == \App\LoanStatus::getStatusCarAssess() and \App\LoanStatus::hasVisit($info->status))
		{
			$status = \App\LoanStatus::getStatusChecked();
		}

		$info->status = $status;
		return $info->update();
	}

	private static function formatConditions($condition)
	{
		return str_replace(['{User}', '{LoanSketch}', '{Branch}'], ['U', 'LoanSketch', 'B'], $condition);
	}

	//获取推送到全国风控中心的案件
	public static function rclist($condition = '', $limit = [10, 0])
	{
		$baseCondition = 'LoanSketch.status='.\App\LoanStatus::getStatusRc();
		$condition = empty($condition) ? $baseCondition : $baseCondition . ' and ' . $condition;

		$columns = [
			'U.bid, B.name bname, LoanSketch.uid, LoanSketch.loan_type, LoanSketch.use_type,
			LoanSketch.amount, LoanSketch.deadline, LoanSketch.deadline_type, LoanSketch.days,
			LoanSketch.repay_method, LoanSketch.repay_source, LoanSketch.addtime'
		];
		$condition = self::formatConditions($condition);
		$query = self::query()
					->leftJoin('User', 'U.uid=LoanSketch.uid', 'U')
					->leftJoin('Branch', 'B.bid=U.bid', 'B')
					->where($condition)
					->orderBy('LoanSketch.addtime desc')
					->columns($columns);

		$count = $query->execute()->count();
		$list = $query->limit($limit[0], $limit[1])
						->execute();
		$list = $list ? $list->toArray() : [];

		return [
			'list'	=>	Loan::format($list),
			'count'	=>	$count
		];
	}

}
