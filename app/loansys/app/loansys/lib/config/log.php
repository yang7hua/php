<?php

namespace App\Config;

class Log
{
	//贷款相关操作
	public static function loanOperate($operate)
	{
		$texts = [
			'apply'	=>	'贷款申请成功',
			'edit_loan_sketch'	=>	'编辑贷款信息',
			'face'	=>	'初审完成',
			'visit'	=>	'实地外访完成',
			'car'	=>	'车评完成',
			'reface'	=>	'复审完成',
			'rc'	=>	'全国风控中心添加处理意见',
			'rc_refuse'		=>	'全国风控中心拒绝案件',
			'sign'	=>	'签署合同',
			'gps'	=>	'GPS安装',
			'carkey'	=>	'车钥匙',
			'pledgenotary'	=>	'抵押公证',
			'runconfirm'	=>	'确认放款',
			'remit_certify'	=>	'汇款成功、汇款凭证上传'		
		];

		return array_key_exists($operate, $texts) ? $texts[$operate] : '';
	}
}
