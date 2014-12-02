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

}
