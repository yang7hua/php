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
			],
			//合同签署
			'contractSign'	=>	[
				'uid'	=>	null,
				'contract'	=>	['default'	=>	1],
				'bank'	=>	['required'	=>	true],
				'bank_card'	=>	['required'	=>	true],
				'bank_card_confirm'	=>	[
					'validator'	=>	[
						'equalTo'	=>	'[name=bank_card]'
					]
				],
				'begintime'	=>	null,
				'endtime'	=>	null,
				'status'	=>	null,
				'gps'	=>	['default'	=>	0],
				'remit_certify'	=>	['default'	=>	0],
				'return_num'	=>	[
					'default'	=>	0
				],
				'return_amount'	=>	['default'	=>	0],
				'last_repay_time'	=>	[],
				'next_repay_time'	=>	[],
			],
			'gps'	=>	[
				'uid'	=>	null,
				'gps'	=>	['required'	=>	true]
			],
			//上传汇款凭证
			'remit'	=>	[
				'uid'	=>	null,
				'remit_certify'	=>	['required'	=>	true]
			]
		];
	}

	//全国风控中心处理意见
	public function deal()
	{
		$uid = $this->data['uid'];
		unset($this->data['uid']);
		return Loan::deal($uid, $this->data);
	}

	//签署合同、银行卡号
	public function sign()
	{
		unset($this->data['bank_card_confirm']);
		$uid = $this->data['uid'];
		unset($this->data['uid']);

		return Loan::updateByUid($uid, $this->data);
	}

	//汇款凭证
	public function remit()
	{
		$uid = $this->data['uid'];
		return Loan::updateByUid($uid, $this->data);
	}
}
