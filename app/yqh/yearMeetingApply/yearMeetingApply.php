<?php

class Ack_Action_Events extends Ack_Action {

	public function yearMeetingApply()
	{
		static $fieldConfig = [
			'gender'	=>	[
				'w'	=>	'先生',
				'm'	=>	'女士'
			],
			'traffic'	=>	[
				'1'	=>	'飞机',
				'2'	=>	'动车',
				'3'	=>	'火车',
				'4'	=>	'汽车'	
			],
			'status'	=>	[
				'0'	=>	'已取消',
				'1'	=>	'申请成功',
				'20'	=>	'异常'
			]
		];	
		static $fieldValidator = [
			'realname'	=>	'/^[\x{4E00}-\x{9Fa5}]+$/u',
			'gender'	=>	'/^[w|m]{1}$/',
			'mobile'	=>	'/^[\d]{11}$/',
			'other_mobile'	=>	'/^([\d-]{11,15})?$/',
			'qq'	=>	'/^\d{3,13}$/',	
			'comefrom'	=>	'/^[\x{4E00}-\x{9Fa5}\s]+$/u',
			'traffic'	=>	'/^[1|2|3|4]{1}$/',
		];

		$uid = 1000;

		$data = $_REQUEST;

		//操作值
		$do = $data['_do'];
		if (empty($do))
			$this->ajaxReturn('非法操作', true, 0);
		unset($data['_do']);

		//需要登录
		if (in_array($do, ['apply', 'cancel']))
		{
			if (!$uid)
				$this->ajaxReturn('请先登录', true, 0);
		}
		//需要密码
		if (in_array($do, ['list']))
		{
			$password = 'yiqihaopassword';
			if (empty($data['password']) || $data['password'] != $password)
				$this->ajaxReturn('无权限查看', true, 0);
			unset($data['password']);
		}

		$M = M('year_meeting_apply');

		//检查是否已经报名过
		$exist = function($uid) use ($M)
		{
			$uid = intval($uid);
			return $M->where("uid=$uid")->find();	
		};

		//申请
		if ($do == 'apply')
		{
			/*
			if ($exist($uid))
				$this->ajaxReturn('禁止重复报名', true, 0);
			 */
			foreach ($data as $field=>$value)
			{
				if (!array_key_exists($field, $fieldValidator))
				{
					unset($data[$field]);
					continue;
				}
				if (!preg_match($fieldValidator[$field], $value))
					$this->ajaxReturn($field . '格式错误', true, 0);
			}
			$data['addtime'] = time();
			$data['status'] = 1;
			//修改
			if ($exist($uid))
			{
				if ($M->where("uid=$uid")->save($data))
				{
					return $this->ajaxReturn('修改成功', true);
				}
				else
				{
					return $this->ajaxReturn('修改失败', true, 0);
				}
			}
			//申请
			else
			{
				$data['uid'] = $uid;
				if ($M->add($data))	
				{
					return $this->ajaxReturn('报名成功', true);
				}
				else
				{
					return $this->ajaxReturn('报名失败', true, 0);
				}
			}	
		}

		//检查是否已经报名过
		if ($do == 'exist')
		{
			if (isset($data['uid']))	
				$uid = $data['uid'];
			if ($exist($uid))
				$this->ajaxReturn('已经报名', true);
			else
				$this->ajaxReturn('未报名', true, 0);
		}

		//查看报名列表
		if ($do == 'list')
		{
			$condition = 'status=1';
			$list = $M->where($condition)->select();
			$count = $M->where($condition)->count();
			foreach ($list as &$row)
			{
				$row['gender'] = $fieldConfig['gender'][$row['gender']];
				$row['traffic'] = $fieldConfig['traffic'][$row['traffic']];
				$row['status'] = $fieldConfig['status'][$row['status']];
				$row['addtime'] = date('Y-m-d H:i', $row['addtime']);
			}
			$this->ajaxReturn([
				'list'	=>	$list,
				'count'	=>	$count
			]);
		}

		//取消报名
		if ($do == 'cancel')
		{
			if (!$exist($uid))
				$this->ajaxReturn('无需取消', true, 0);

			$uid = intval($uid);
			if ($M->where("uid=$uid")->save(['status' => 0]))
				$this->ajaxReturn('取消成功', true);
			else
				$this->ajaxReturn('取消失败，稍后再试', true, 0);
		}
		
		exit();
	}

}

