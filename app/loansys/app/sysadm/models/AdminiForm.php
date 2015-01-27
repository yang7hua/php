<?php

class AdminiForm extends ModelForm
{
	public static function fields()
	{
		return [
		'add'	=>	[
			'bid'	=>	[
				'label'	=>	'所属分店',
				'type'	=>	'select',
				'inputOptions'	=>	[
				],
				'options'	=>	Branch::options(['all'=>true]),
				'default'	=>	null,
				'validator'	=> [
					'required'	=> true,
				]	
			],
			'username'	=>	[
				'label'	=>	'账号',
				'type'	=>	'text',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],	
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	3,
					'maxlength'	=>	20,
					'regex'	=>	'^[\\\\w_]+$',
					'remote'	=>	\Func\url('/admini/exist')
				],
				'remark'	=>	'用户名在3-20个字符之间, 字母数字或下划线组成',
				'remarkOptions'	=>	[
					'class'	=>	'col-lg-4'
				]
			],
			'password'	=>	[
				'label'	=>	'密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],
				'validator'	=>	[
					'required'	=>	true,
					'minlength'	=>	6,
					'maxlength'	=>	12
				]
			],
			'repassword'	=>	[
				'label'	=>	'确认密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
					'class'	=>	'col-lg-3'
				],
				'validator'	=>	[
					'required'	=>	true,
					'equalTo'	=>	'[name=password]'
				]
			],
		],
		
		'edit'	=>	[
			'aid'	=>	[
				'type'	=>	'hidden'
			],
			'username'	=>	[
				'label'	=>	'用户名',
				'type'	=>	'plain',
				'default'	=>	null
			],
			'bid'	=>	[
				'label'	=>	'所属分店',
				'type'	=>	'select',
				'inputOptions'	=>	[
				],
				'options'	=>	Branch::options(['all'=>true]),
				'default'	=>	null,
				'validator'	=> [
					'required'	=> true,
				]	
			],
			'password'	=>	[
				'label'	=>	'密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
				],
				'validator'	=>	[
					'minlength'	=>	6,
					'maxlength'	=>	12
				]
			],
			'repassword'	=>	[
				'label'	=>	'确认密码',
				'type'	=>	'password',
				'inputOptions'	=>	[
				],
				'validator'	=>	[
					'equalTo'	=>	'[name=password]'
				]
			]
		],
		//用于登录
		'login'	=>	[
			'username'	=>	[
				'label'	=>	'用户名',
				'type'	=>	'text',
				'inputOptions'	=>	['class'=>'col-lg-8'],
				'validator'	=>	[
					'required'	=>	true
				]
			],
			'password'	=>	[
				'label'	=>	'密码',
				'type'	=>	'password',
				'inputOptions'	=>	['class'=>'col-lg-8'],
				'validator'	=>	[
					'required'	=>	true
				]
			],
			'captcha'	=>	[
				'label'	=>	'验证码',
				'type'	=>	'captcha',
				'inputOptions'	=>	['class'=>'col-lg-8'],
				'validator'	=>	[
					'required'	=>	true
				]
			]
		]

		];
	}

	public function add()
	{
		return Admini::add($this->data);
	}

	public function edit()
	{
		$aid = $this->data['aid'];
		unset($this->data['aid']);
		return Admini::edit($aid, $this->data);
	}

	public function login()
	{
		return Admini::login($this->data);
	}
}
