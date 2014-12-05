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
				'lid'	=>	null,
				'contract'	=>	['default'	=>	1],
				'bank'	=>	['required'	=>	true],
				'bank_card'	=>	['required'	=>	true],
				'bank_card_confirm'	=>	[
					'validator'	=>	[
						'equalTo'	=>	'[name=bank_card]'
					]
				]
			],
			'gps'	=>	[
				'lid'	=>	null,
				'gps'	=>	['required'	=>	true]
			],
			//上传汇款凭证
			'remit'	=>	[
				'lid'	=>	null,
				'remit_certify'	=>	['required'	=>	true]
			]
		];
	}

	public function deal()
	{
		$uid = $this->data['uid'];
		unset($this->data['uid']);
		return Loan::deal($uid, $this->data);
	}

	public function sign()
	{
		unset($this->data['bank_card_confirm']);
		$lid = $this->data['lid'];
		unset($this->data['lid']);

		return Loan::sign($lid, $this->data);
	}
}
