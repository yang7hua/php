<?php

class LoanForm extends ModelForm
{
	public static function fields()
	{
		return [
			'agree'	=>	[
				'uid'	=>	null,
				'oid'	=>	null,
				'amount'	=>	[
					'validator'	=>	['required'=>true]
				],
				'deadline'	=>	[
					'validator'	=>	['required'=>true]
				],
				'repay_method'	=>	[
					'validator'	=>	['required'=>true]
				],
				'apr'	=>	[],
				'reason'	=>	[],
				'remark'	=>	[],
				'status'	=>	[],
			],
			'refuse'	=>	[
				'uid'	=>	null,
				'oid'	=>	null,
				'reason'	=>	null,
				'remark'	=>	null,
				'status'	=>	null,
			]
		];
	}

	public function deal()
	{
		$uid = $this->data['uid'];
		unset($this->data['uid']);
		return Loan::deal($uid, $this->data);
	}
}
