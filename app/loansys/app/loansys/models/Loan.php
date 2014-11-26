<?php

class Loan extends Model
{

	public static function add($data, $lastInsId = false)
	{
		$Loan = new Loan();
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

	public static function format($data)
	{
		static $repay_method = null;
		static $use_type = null;
		static $loan_type = null;
		static $status = null;

		if (!$repay_method)
			$repay_method = \App\Config\Loan::repayMethod();
		if (!$use_type)
			$use_type = \App\Config\Loan::useType();
		if (!$loan_type)
			$loan_type = \App\Config\Loan::loanType();
		if (!$status)
			$status = \App\Config\Loan::status();

		foreach ($data as &$row) 
		{
			$row['repay_method_text'] = $repay_method[$row['repay_method']];
			$row['use_type_text'] = $use_type[$row['use_type']];
			$row['loan_type_text'] = $loan_type[$row['loan_type']];
			$row['addtime'] = date('Y/m/d', $row['addtime']);
			$row['status_text'] = $status[$row['status']];
		}
		return $data;
	}

}
