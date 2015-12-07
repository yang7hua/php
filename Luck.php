<?php

class Hao_Action_Activity_Luck extends Hao_Action_Activity
{
	const TYPE = 1;

	static $once_invest_money = 1000;
	static $twice_invest_money = 3000;

	function _initialize()
	{
		parent::_initialize();
	}

	//奖品现金券发放设置
	private function get_reward_coupon($reward_id)
	{
		$coupon = array();
		switch ($reward_id) {
		case 2:
			$coupon = array_pad($coupon, 5, 100);	
			break;
		case 3:
			$coupon = array_pad($coupon, 3, 100);
			break;
		case 4:
			$coupon = array(100);
			break;
		case 5:
			$coupon = array(20, 30);
			break;
		case 1:
		default:
			break;
		}
		return $coupon;
	}

	//奖品设置及概率, $valid=true, 只查询名额没用完的奖项
	private function rewards($valid = true)
	{
		$map = array(
			'type'	=>	1,
		);
		if ($valid)
			$map['_string']	= '`done_count`<`count`';
		$rewards = M('luck_reward')->where($map)->order('reward_id asc')->select();
		//echo M('luck_reward')->getLastSql();
		return $rewards;
	}

	private function response($status, $msg, $return = 1)
	{
		$data = array(
			'status'	=>	$status,
		);
		if (is_array($msg))
			$data['data'] = $msg;
		else
			$data['msg'] = $msg;
		$this->ajaxReturn(false, $data, $return);
	}

	private function act_time()
	{
		if (APP_ONLINE)
			return array(strtotime('20151217'), strtotime('20151226 23:59:59'));
		return array(strtotime('20151207'), strtotime('20151226 23:59:59'));
	}

	function run($do)
	{
		if (!in_array($do, array('info', 'done')))
			$this->error('error.');

		//验证活动有效期
		$act_time = $this->act_time();
		if ($act_time[0] > time())
			$this->response(-10, '活动未开始', 0);
		if ($act_time[1] < time())
			$this->response(-10, '活动已结束', 0);

		//验证开奖有效期
		$luck_time = $this->luck_time();
		if ($luck_time[0] > time() and in_array($do, array('done')))
			$this->response(-20, '幸运大转盘开转未开始', 0);
		if ($luck_time[1] < time() and in_array($do, array('done')))
			$this->response(-20, '当期幸运大转盘已结束', 0);

		//验证会话
		if (empty($this->uid) and in_array($do, array('info', 'done')))
			$this->response(-1, '请先登录', 0);

		$this->$do();
	}

	//获取当前用户抽奖机会
	private function info()
	{
		$this->ajaxReturn($this->today_luck());
	}

	//随机抽取奖项, 返回奖项ID和名称
	private function rand_reward()
	{
		$rewards = $this->rewards();
		$reward_pro = array();
		$pro_sum = 0;
		$reward_name = array();
		foreach ($rewards as $row) {
			$reward_pro[$row['reward_id']] = $row['pro'];
			$reward_name[$row['reward_id']] = $row['reward_name'];
			$pro_sum += $row['pro'];
		}
		$reward_id = null;
		foreach ($reward_pro as $key => $pro) {
			$rand_pro = mt_rand(1, $pro_sum)+mt_rand(1,10)/10;
			//echo $key,',',$rand_pro,',',$pro,"<br/>";
			if ($rand_pro <= $pro) {
				$reward_id = $key;
				break;
			} else {
				$pro_sum -= $pro;
			}
		}
		return array($reward_id, $reward_name[$reward_id]);
	}

	//抽奖
	private function done()
	{
		$today_luck = $this->today_luck();
		if ($today_luck['count'] < 1)
			$this->response(-30, $today_luck['msg']);

		while (!$reward_id) {
			list($reward_id, $reward_name) = $this->rand_reward();
		}
		$data = array(
			'uid'	=>	$this->uid,
			'reward_id'	=>	$reward_id,
			'reward_name'	=>	$reward_name,
			'addtime'	=>	time()
		);
		$M = M('luck_reward_record');
		$M->startTrans();
		$res = $M->add($data);
		$flag = true;
		if ($res) {
			$map = array(
				'reward_id'	=>	$reward_id,
				'type'	=>	self::TYPE
			);
			if (M('luck_reward')->where($map)->setInc('done_count')) {
				$coupon = $this->get_reward_coupon($reward_id);
				if (is_array($coupon) and !empty($coupon)) {
					foreach ($coupon as $money) {
						if (!Hao_User::addCoupon($this->uid, $money, array(
							'type'	=>	Hao_Config::$type_coupon['活动奖励'],
							'name'	=>	'转盘奖励',
						))) {
							$flag = false;
						}
					}
				}
			} else {
				$flag = false;
			}
			if ($flag) {
				$M->commit();	
				$this->response(200, array('reward_id'=>$reward_id, 'reward_name'=>$reward_name));
			} else {
				$M->rollback();
				$this->response(500, '服务器忙', 0);
			}
		}
	}

	//获取开奖时间, 测试环境下, 偶数小时为有效开奖时间
	private function luck_time($type)
	{
		if (APP_ONLINE) {
			switch ($type) {
			case 'today':
			default:
				return array(strtotime(date('Ymd 12:00:00')), strtotime(date('Ymd 23:59:59')));
				break;
			case 'yesterday':
				$begin = strtotime('-1day', date('Ymd 12:00:00'));
				return array($begin, strtotime(date('Ymd 23:59:59', $begin)));
				break;
			}
		}
		$hour = date('H');
		if ($hour%2 == 0) {
			if ($type == 'yesterday') {
				$begin = strtotime('-2hour', strtotime(date('Ymd H:00:00')));
				return array($begin, strtotime(date('Ymd H:59:59', $begin)));
			}
			return array(strtotime(date('Ymd H:00:00')), strtotime(date('Ymd H:59:59')));
		}
		$begin = strtotime('+1hour', strtotime(date('Ymd H:00:00')));
		if ($type == 'yesterday')
			$begin = strtotime('-2hour', $begin);
		return array($begin, strtotime(date('Ymd H:59:59', $begin)));
	}

	//有效投资时间, 测试环境下,奇数小时为投资有效时间, 偶数小时为抽奖时间
	private function invest_time()
	{
		if (APP_ONLINE)
			return array(strtotime(date('Ymd 12:00:00')), strtotime(date('Ymd 17:00:00')));
		$hour = date('H');
		if ($hour%2 == 0) {
			$begin = strtotime('-1hour', strtotime(date('Ymd H:00:00')));
			return array($begin, strtotime(date('Ymd H:59:59', $begin)));
		}
		return array(strtotime(date('Ymd H:00:00')), strtotime(date('Ymd H:59:59')));
	}

	//用户当日有效时间内投资总额, 不包括债权转让
	private function invest_money()
	{
		$map = array(
			'uid'	=>	$this->uid,
			'bidtime'	=>	array('between', $this->invest_time()),
			'status'	=> array('egt', Hao_Status::$tender['成功'])
		);
		//echo date('Ymd His', $this->invest_time()[1]);
		$amount = M('tender')->where($map)->sum('pay_money');
		//echo M('tender')->getLastSql();
		return $amount;
	}

	//当前用户今日可抽奖次数
	private function today_luck()
	{
		$count = 0;
		$invest_money = floatval($this->invest_money());
		if ($invest_money <= 0) {
			$need_money = self::$once_invest_money;
			$msg = '您尚未参与投资，投资5万即可参与活动哦';
		} else if ($invest_money < self::$once_invest_money) {
			$need_money = self::$once_invest_money - $invest_money;
			$msg = '您还投资'.$need_money.'元即可参与抽奖哦';
		} else if ($invest_money < self::$twice_invest_money) {
			$count = 1;
			$need_money = self::$twice_invest_money - $invest_money;
			$msg = '您还投资 '.$need_money.'元即可额外抽奖一次哦';
		} else {
			$count = 2;
			$need_money = 0;
		}

		$map = array(
			'uid'	=>	$this->uid,
			'addtime'	=>	array('between', $this->luck_time()),
			'type'	=>	self::TYPE
		);
		//今天已抽次数
		$done_count = M('luck_reward_record')->where($map)->count();
		if ($done_count >= 1) {
			$count -= $done_count;
			if ($count < 1)
				$msg = '今日次数已达上限，明日再接再厉哦';
		}

		//昨天再来一次
		$map['addtime'] = array('between', $this->luck_time('yesterday'));
		$map['reward_id'] = 6;
		$yesterday_again = M('luck_reward_record')->where($map)->count();
		if ($yesterday_again > 0)
			$count += $yesterday_again;

		$return = array(
			'count'	=>	$count,
			'done_count'	=>	$done_count,
			'yesterday_again'	=>	$yesterday_again,
			'invest_money'	=>	$invest_money,
			'need_money'	=>	$need_money,
			'msg'	=>	null
		);
		if ($count < 1)
			$return['msg'] = $msg;
		return $return;
	}

}
