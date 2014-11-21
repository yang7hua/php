<?php

class AuthorityForm extends ModelForm
{

	public static function fields()
	{
		return [
			'add'	=>	[
				'app'	=>	[
					'label'	=>	'项目名称',
					'type'	=>	'select',
					'options'	=>	[
						['value'	=>	1, 'name'	=>	'loansys'],
						['value'	=>	2, 'name'	=>	'sysadm'],
					]
				]
			]
		];
	}

}
