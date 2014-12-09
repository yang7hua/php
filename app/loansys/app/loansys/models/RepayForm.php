<?php

class RepayForm extends ModelForm
{
	public static function fields()
	{
		return [
			'add'	=>	[
				'uid'	=>	[],
				'lid'	=>	[],
				'oid'	=>	[],
				'amount'	=>	[],
				'no'	=>	[],
				'status'	=>	[],
				'date'	=>	[],
				'addtime'	=>	[],
			],
			'repay'	=>	[
				'id'	=>	[],
				'uid'	=>	[],
				'amount'	=>	[],
				'date'	=>	[]
			]
		];
	}

	public function add()
	{
		return Repay::add($this->data);
	}

	public function repay()
	{
		$id = $this->data['id'];
		unset($this->data['id']);
		return Repay::doRepay($id, $this->data);
	}
}
