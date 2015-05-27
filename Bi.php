<?php

class Hao_Bi
{
	const MONEY_ZERO = '0.00';

	/**
	 * 各种sql查询status值
	 */
	static function status($key)
	{
		switch ($key) {
			case 'recharge':
				return ['in', [
					Hao_Status::$recharge['充值中'], 
					Hao_Status::$recharge['待确认'], 
					Hao_Status::$recharge['充值成功']
					]];
				break;

			case 'drawcash':
				return ['egt', Hao_Status::$drawcash['等待处理']];
				break;

			case 'tender':
				return ['in', [
					Hao_Status::$tender['还款中'],
					Hao_Status::$tender['还款成功']
					]];
				break;

			case 'loan':
				return ['in', [
					Hao_Status::$loan['招标中'],
					Hao_Status::$loan['流标中'],
					Hao_Status::$loan['已流标'],
					Hao_Status::$loan['满标待审'],
					Hao_Status::$loan['还款中'],
					Hao_Status::$loan['还款成功'],
					Hao_Status::$loan['提前还款'],
					Hao_Status::$loan['系统已代还'],
					Hao_Status::$loan['代还已回收'],
					]];
				break;

			default:
				return null;
				break;
		}
	}

	static function onlineDate()
	{
		return '20120907';
	}

	/**
	 * 获取某日期的当月第一天和最后一天
	 * 默认为本月
	 */
	static function getFirstAndLastDateOfMonth($date = null)
	{
		$month_time = strtotime(is_null($date) 
			? date('Y-m-01') 
			: date('Y-m-01', (self::isTime($date) ? $date : strtotime($date))) );
		$first_date = date('Y-m-d', $month_time);
		$last_date = date('Y-m-d', strtotime($first_date . ' +1month -1day'));
		return [$first_date, $last_date];
	}

	/**
	 * 获取某一天的当周第一天和最后一天
	 * 默认周一天第一天
	 * 如果周日为第一天, 则$firstDay='sunday'
	 */
	static function getFirstAndLastDateOfWeek($date = null, $firstDay = null)
	{
		$date = is_null($date) ? date('Y-m-d') : (self::isTime($date) ? date('Y-m-d', $date) : $date);
		if ($firstDay == 'sunday')
			$first_date = date('Y-m-d', strtotime($date . ' this week -1day'));
		else
			$first_date = date('Y-m-d', strtotime($date . ' this week'));
		$last_date = date('Y-m-d', strtotime($first_date . ' +6day'));
		return [$first_date, $last_date];
	}

	static function isTime($str)
	{
		return preg_match('/^\d{10}$/', $str);
	}

	/**
	 * 获取指定日期的起始、结束时间戳
	 * 默认是上线第一天开始到现在的时间
	 * 如果指定了date,但是未指定end_date, 则返回date当天
	 */
	static function getTimeAreaOfDate($date = null, $end_date = null)
	{
		$begin_time = empty($date) ? strtotime(self::onlineDate()) : (self::isTime($date) ? $date : strtotime($date));
		$begin = strtotime(date('Y-m-d', $begin_time));

		if (empty($end_date))
			$end = $date ? strtotime(date('Y-m-d 23:59:59', $begin)) : time();
		else
			$end = self::isTime($end_date) ? $end_date : strtotime($end_date);

		return [$begin, $end];
	}

	static function whereOfTimeArea($date = null, $end = null)
	{
		if ($date == 'today') {
			return ['between', self::getTimeAreaOfDate(date('Y-m-d'))];

		} else if ($date == 'yesterday') {
			return ['between', self::getTimeAreaOfDate(strtotime(($end ? $end : date('Y-m-d')) . ' -1day'))];

		} else if ($date == 'this week') {
			list($first_date, $last_date) = self::getFirstAndLastDateOfWeek($end);
			return ['between', self::getTimeAreaOfDate($first_date, $last_date)];

		} else if ($date == 'this month') {
			list($first_date, $last_date) = self::getFirstAndLastDateOfMonth($end);
			return ['between', self::getTimeAreaOfDate($first_date, $last_date)];

		} else if (preg_match('/^-\d+(day|days|month|year)$/', $date)) {
			return ['between', self::getTimeAreaOfDate(strtotime(($end ? $end : date('Y-m-d')) . ' ' . $date), $end)];

		} else {
			return ['between', self::getTimeAreaOfDate($date, $end)];

		}
	}

	static function getValuesOfListByField($list, $field, $distinct = false)
	{
		$values = [];
		foreach ($list as $row) {
			if ($distinct and in_array($row[$field], $values))
				continue;
			$values[] = $row[$field];
		}
		return $values;
	}

	/**
	 * 新增用户数
	 */
	static function newUserCount($date = null, $end = null)
	{
		$M_user = M('user');

		if (is_null($date) and is_null($end))
			return $M_user->count();

		$map['addtime'] = self::whereOfTimeArea($date, $end);
		return $M_user->where($map)->count();
	}

	/**
	 * 新增用户均值:统计周期内同一时段新增用户数/统计周期
	 */
	static function newUserAvg($date = null, $end = null)
	{
	}

	/**
	 * 登录的用户数
	 */
	static function loginUserCount($date = null, $end = null)
	{
		$M_user_login = M('user_login');
		if (is_null($date) and is_null($end))
			return $M_user_login->count('distinct uid');

		$map['login_time'] = self::whereOfTimeArea($date, $end);
		return $M_user_login->where($map)->count('distinct uid');
	}

	/**
	 * 通过时间和余额范围查询用户数
	 */
	static function userCountByDateAndAmountArea($date = null, $end = null, $min = null, $max = null)
	{
		$map['addtime'] = self::whereOfTimeArea($date, $end);
		if (!is_null($min) and !is_null($max))
			$map['amount'] = ['between', [$min, $max]];
		else if (!is_null($min))
			$map['amount'] = ['egt', $min];
		else if (!is_null($max))
			$map['amount'] = ['lgt', $max];
		return M('user')->where($map)->count();
	}

	/**
	 * 某一时间段充值用户数
	 */
	static function rechargeUserCount($date = null, $end = null)
	{
		$M_recharge = M('recharge');

		$map['status'] = self::status('recharge');
		$map['addtime'] = self::whereOfTimeArea($date, $end);

		return $M_recharge->where($map)->count('distinct uid');
	}

	/**
	 * 某一时间段充值金额
	 */
	static function rechargeAmount($date = null, $end = null)
	{
		$M_recharge = M('recharge');

		$map['status'] = self::status('recharge');
		$map['addtime'] = self::whereOfTimeArea($date, $end);

		$amount = $M_recharge->where($map)->sum('money');
		return $amount ? $amount : self::MONEY_ZERO;
	}

	/**
	 * 时间范围内注册且充值的用户, 排除老用户充值数据, 
	 */
	static function newUserAndRechargeUser($date = null, $end = null)
	{
		$timearea = self::whereOfTimeArea($date, $end);
		$user_map['addtime'] = $timearea;

		$recharge_map['status'] = self::status('recharge');
		$recharge_map['addtime'] = $timearea;

		$ulist = M('user')->where($user_map)->field('uid')->select();
		$rlist = M('recharge')->where($recharge_map)->field('uid,money')->select();

		$new_uids = self::getValuesOfListByField($ulist, 'uid', true);
		$recharge_uids = self::getValuesOfListByField($rlist, 'uid', true);
		$new_recharge_uids = array_intersect($new_uids, $recharge_uids);

		$data = [
			'new_uids' => $new_uids,
			'recharge_uids'	=>	$recharge_uids,
			'recharge_amount'	=>	0,
			'new_recharge_uids'	=>	$new_recharge_uids,
			'new_recharge_amount'	=>	0
		];
		foreach ($rlist as $recharge) {
			$data['recharge_amount'] += $recharge['money'];
			if (in_array($recharge['uid'], $new_recharge_uids))
				$data['new_recharge_amount'] += $recharge['money'];
		}
		return $data;
	}

	static function newUserAndRechargeUserCount($date = null, $end = null)
	{
		return count(self::newUserAndRechargeUser($date, $end)['new_recharge_uids']);
	}

	/**
	 * 注册且充值 / 注册
	 */
	static function newUserAndRechargeUserRechargeRate($date = null, $end = null)
	{
		$users = self::newUserAndRechargeUser($date, $end);
		if (empty($users['new_uids']))
			return 0;
		return sprintf('%.2f', count($users['new_recharge_uids']) / count($users['new_uids']));
	}

	/**
	 * 人均充值金额
	 */
	static function rechargeRate($date = null, $end = null)
	{
		$count = self::rechargeUserCount($date, $end);
		if ($count < 1)
			return 0;
		return sprintf('%.2f', self::rechargeAmount($date, $end) / $count);
	}

	/**
	 * 新增充值用户、金额, 包括老用户第一次的充值
	 */
	static function newRecharge($date = null, $end = null)
	{
		$recharge = [
			'uids'	=>	[],
			'amount'	=>	0,
			'new_uids'	=>	[],
			'new_amount'	=>	0
		];

		$M_recharge = M('recharge');
		$timearea = self::whereOfTimeArea($date, $end);
		$recharge_map['status'] = self::status('recharge');
		$recharge_map['addtime'] = $timearea;
		$list = $M_recharge->where($recharge_map)->field('uid,money')->select();
		if (!$list)
			return $recharge;

		foreach ($list as $row) {
			$uid = $row['uid'];
			if (!array_key_exists($uid, $recharge['uids'])) {
				$recharge['uids'][$uid] = 0; 
			}
			$recharge['uids'][$uid] += $row['money'];
		}
		foreach ($recharge['uids'] as $uid=>$money) {
			//判断之前有没有充值，如果没有，则说明是新增充值
			$map = [
				'uid'	=>	$uid,
				'status'	=>	self::status('recharge'),
				'addtime'	=>	['lt', $timearea[1][0]]
			];
			$recharge['amount'] += $money;
			if ($M_recharge->where($map)->count()) {
				continue;
			}
			$recharge['new_amount'] += $money;
			if (!in_array($uid, $recharge['new_uids']))
				$recharge['new_uids'][] = $uid;
		}
		return $recharge;
	}

	/**
	 * 充值渠道
	 */
	static function rechargeTypes()
	{
		$M_recharge = M('recharge');
		$types = $M_recharge->distinct(true)->field('type')->select();
		return self::getValuesOfListByField($types, 'type');
	}

	/**
	 * 根据充值渠道查询充值用户数目，排重
	 */
	static function rechargeUserCountByRtype($type, $date = null, $end = null)
	{
		$M_recharge = M('recharge');
		$map['type'] = $type;
		$map['addtime'] = self::whereOfTimeArea($date, $end);
		return $M_recharge->where($map)->count('distinct uid');
	}

	/**
	 * 根据充值渠道查询充值用户, 返回充值笔数、成功笔数、金额、第一次充值的用户数
	 */
	static function rechargeByRtype($type, $date = null, $end = null)
	{
		$recharge = [
			'count'	=>	0,
			'ok'	=>	0,
			'ing'	=>	0,
			'fail'	=>	0,
			'first_user_count'	=>	0,
			'uids'	=>	[],
			'amount'	=>	0
		];
		$M_recharge = M('recharge');
		$map['type'] = $type;
		$map['addtime'] = self::whereOfTimeArea($date, $end);
		$ulist = $M_recharge->where($map)->field('uid,money,status')->select();

		$recharge['count'] = count($ulist);
		foreach ($ulist as $row) {
			$uid = $row['uid'];
			$recharge['amount'] += $row['money'];
			if (!in_array($uid, $recharge['uids'])) 
				$recharge['uids'][] = $uid;
			switch ($row['status']) {
				case Hao_Status::$recharge['充值中'];
				case Hao_Status::$recharge['待确认'];
					$recharge['ing']++;
					break;
				case Hao_Status::$recharge['充值成功'];
					$recharge['ok']++;
					break;
				default:
					$recharge['fail']++;
					break;
			}	
			$new_map = [
				'uid'	=>	$uid,
				'type'	=>	$type,
				'addtime'	=>	['lt', $map['addtime'][1][0]],
			];
			if (!$M_recharge->where($new_map)->count())
				$recharge['first_user_count']++;
		}
		return $recharge;
	}

	/**
	 * 充值排名
	 */
	static function rechargeRanking($date = null, $end = null, $total = 100)
	{
		$map['R.status'] = self::status('recharge');
		$map['R.addtime'] = self::whereOfTimeArea($date, $end);
		return M('recharge')->alias('R')
			->join(C('DB_PREFIX') . 'user U on U.uid=R.uid')
			->where($map)
			->field('sum(R.money) total,U.uname')
			->group('R.uid')
			->order('total desc')
			->limit("0,$total")
			->select();
	}

	static function newUserRechargeRate($date = null, $end = null)
	{
		$recharge = self::newUserRecharge($date, $end);
		if (empty($recharge['uids']))
			return 0;
		return sprintf('%.2f', $recharge['amount'] / count($recharge['uids']));
	}

	/**
	 * 某一时间段投标用户数
	 */
	static function bidUserCount($date = null, $end = null)
	{
		$M_tender = M('tender');

		$map['status'] = self::status('tender');
		$map['bidtime'] = self::whereOfTimeArea($date, $end);

		return $M_tender->where($map)->count('distinct uid');
	}

	/**
	 * 时间段内投标金额
	 */
	static function bidAmount($date = null, $end = null)
	{
		$M_tender = M('tender');

		$map['status'] = self::status('tender');
		$map['bidtime'] = self::whereOfTimeArea($date, $end);

		$amount = $M_tender->where($map)->sum('money');
		return $amount ? $amount : self::MONEY_ZERO;
	}

	/**
	 * 时间范围内注册且投标的用户
	 */
	static function newUserAndBidUser($date = null, $end = null)
	{
		$timearea = self::whereOfTimeArea($date, $end);
		$user_map['addtime'] = $timearea;

		$tender_map['status'] = self::status('tender');
		$tender_map['bidtime'] = $timearea;

		$ulist = M('user')->where($user_map)->field('uid')->select();
		$tlist = M('tender')->where($tender_map)->field('uid,money')->select();

		$new_uids = self::getValuesOfListByField($ulist, 'uid', true);
		$bid_uids = self::getValuesOfListByField($tlist, 'uid', true);

		$new_bid_uids = array_intersect($new_uids, $bid_uids);

		$data = [
			'new_uids'	=>	$new_uids,
			'bid_uids'	=>	$bid_uids,
			'new_bid_uids'	=>	$new_bid_uids,
			'new_bid_amount'	=>	0,
			'bid_amount'	=>	0
		];
		foreach ($tlist as $tender) {
			$data['bid_amount'] += $tender['money'];
			if (!in_array($tender['uid'], $new_bid_uids))
				continue;
			$data['new_bid_amount'] += $tender['money'];
		}
		return $data;
	}

	static function newUserAndBidUserCount($date = null, $end = null)
	{
		return count(self::newUserAndBidUser($date, $end)['new_bid_uids']);
	}

	/**
	 * 注册且投标 / 新增注册
	 */
	static function newUserAndBidUserBidRate($date = null, $end = null)
	{
		$users = self::newUserAndBidUser($date, $end);
		if (empty($users['new_uids']))
			return 0;
		return sprintf('%.2f', count($users['new_bid_uids']) / count($users['new_uids']));
	}

	/**
	 * 人均充值金额
	 */
	static function bidRate($date = null, $end = null)
	{
		$count = self::bidUserCount($date, $end);
		if ($count < 1)
			return 0;
		return sprintf('%.2f', self::bidAmount($date, $end) / $count);
	}

	/**
	 * 第一次投标用户
	 */
	static function newBid($date = null, $end = null)
	{
		$bid = [
			'uids'	=>	[],
			'amount'	=>	0,
		];

		$M_tender = M('tender');
		$timearea = self::whereOfTimeArea($date, $end);
		$tender_map['status'] = self::status('tender');
		$tender_map['bidtime'] = $timearea;
		$list = $M_tender->where($tender_map)->field('uid,money')->select();
		if (!$list)
			return $bid;

		foreach ($list as $row) {
			$uid = $row['uid'];
			if (!array_key_exists($uid, $bid['uids'])) {
				$bid['uids'][$uid] = 0; 
			}
			$bid['uids'][$uid] += $row['money'];
		}
		foreach ($bid['uids'] as $uid=>$money) {
			//判断之前有没有充值，如果没有，则说明是新增充值
			$map = [
				'uid'	=>	$uid,
				'status'	=>	self::status('tender'),
				'bidtime'	=>	['lt', $timearea[1][0]]
			];
			if ($M_tender->where($map)->count()) {
				unset($bid['uids'][$uid]);
				continue;
			}
			$bid['amount'] += $money;
		}
		return $bid;
	}

	/**
	 * 新增投标比率
	 */
	static function newBidRate($date = null, $end = null)
	{
		$bid = self::newBid($date, $end);
		if (empty($bid['uids']))
			return 0;
		return sprintf('%.2f', $bid['amount'] / count($bid['uids']));
	}

	/**
	 * 投标排名
	 */
	static function bidRanking($date = null, $end = null, $total = 100)
	{
		$map['T.status'] = self::status('tender');
		$map['T.bidtime'] = self::whereOfTimeArea($date, $end);
		return M('tender')->alias('T')
			->join(C('DB_PREFIX') . 'user U on U.uid=T.uid')
			->where($map)
			->field('sum(T.money) total,U.uname')
			->group('T.uid')
			->order('total desc')
			->limit("0,$total")
			->select();
	}

	/**
	 * 提现用户
	 */
	static function drawcashUserCount($date = null, $end = null)
	{
		$M_drawcash = M('drawcash');

		$map['status'] = self::status('drawcash');
		$map['addtime'] = self::whereOfTimeArea($date, $end);

		return $M_drawcash->where($map)->count('distinct uid');
	}

	/**
	 * 提现总额
	 */
	static function drawcashAmount($date = null, $end = null)
	{
		$M_drawcash = M('drawcash');

		$map['status'] = self::status('drawcash');
		$map['addtime'] = self::whereOfTimeArea($date, $end);

		$amount = $M_drawcash->where($map)->sum('money');
		return $amount ? $amount : self::MONEY_ZERO;
	}

	/**
	 * 提现排名
	 */
	static function drawcashRanking($date = null, $end = null, $total = 100)
	{
		$map['D.status'] = self::status('drawcash');
		$map['D.addtime'] = self::whereOfTimeArea($date, $end);
		return M('drawcash')->alias('D')
			->join(C('DB_PREFIX') . 'user U on U.uid=D.uid')
			->where($map)
			->field('sum(D.money) total,U.uname')
			->group('D.uid')
			->order('total desc')
			->limit("0,$total")
			->select();
	}

	/**
	 * arpu
	 */
	static function arpu($date = null)
	{
		$bidUserCount = self::bidUserCount(self::onlineDate(), self::getTimeAreaOfDate($date)[1]);
		if ($bidUserCount < 1)
			return 0;

		$bidAmount = self::bidAmount($date);
		return sprintf('%.2f', $bidAmount/$bidUserCount);
	}

	/**
	 * 充值arpu
	 */
	static function arpuOfRecharge($date = null)
	{
		$date or $date = date('Y-m-d');
		$rechargeUserCount = self::rechargeUserCount(self::onlineDate(), self::getTimeAreaOfDate($date)[1]);
		if ($rechargeUserCount < 1)
			return 0;

		$rechargeAmount = self::rechargeAmount($date);
		return sprintf('%.2f', $rechargeAmount / $rechargeUserCount);
	}

	/**
	 * 当日注册用户投资 arpu
	 */
	static function arpuOfUserBid($date = null)
	{
		$date or $date = date('Y-m-d');
	   	$newUserCount = self::newUserCount(self::onlineDate(), self::getTimeAreaOfDate($date)[1]);
		if ($newUserCount < 1)
			return 0;

		$bidAmount = self::bidAmount($date);
		return sprintf('%.2f', $arpu);
	}

	/**
	 * 累计投标arpu
	 */
	static function arpuOfBid($sdate = null, $edate = null)
	{
		$ucount = self::newUserCount($sdate, $edate);
		if ($ucount < 1)
			return 0;
		return sprintf('%.2f', self::bidAmount($sdate, $edate) / $ucount);
	}

	/**
	 * 累计运营天数
	 */
	static function daysOfOnline($edate = null)
	{
		$etime = is_null($edate) ? time() : strtotime($edate);
		$online = strtotime(self::onlineDate());
		if ($etime < $online)
			return 0;
		return ceil(($etime - $online) / 86400);
	}

	/**
	 * 一次性用户数
	 */
	static function singleUserCount($sdate = null, $edate = null)
	{
		$total = self::newUserCount($sdate, $edate);
		if ($total < 1)
			return 0;
		$map['login_time'] = 0;
		$map['addtime'] = self::whereOfTimeArea($sdate, $edate);
		$single_count = M('user')->where($map)->count();
		return sprintf('%.2f', $single_count / $total);
	}

	/**
	 * 注册转换率: 时间范围内新增的注册用户数/第一次启动应用、web访问的用户数
	 */
	static function regConvertRate($date = null, $end = null)
	{
	}

	/**
	 * 充值转换率: 时间范围内新注册且第一次充值用户数/新增的注册用户数
	 */
	static function rechargeConvertRate($date = null, $end = null)
	{
		$newUserCount = self::newUserCount($date, $end);
		if ($newUserCount < 1)
			return 0;

		$newUserAndRechargeUserCount = self::newUserAndRechargeUserCount($date, $end);
		return sprintf('%.2f', $newUserAndRechargeUserCount / $newUserCount);
	}

	/**
	 * 投标转换率:时间范围内新注册且第一次投标的用户数/时间范围内新注册且第一次充值的用户数
	 */
	static function bidConvertRate($date = null, $end = null)
	{
		$newUserAndRechargeUserCount = self::newUserAndRechargeUserCount($date, $end);
		if ($newUserAndRechargeUserCount < 1)
			return 0;

		$newUserAndBidUserCount = self::newUserAndBidUserCount($date, $end);
		return sprintf('%.2f', $newUserAndBidUserCount / $newUserAndRechargeUserCount);
	}

	/**
	 * 投标活跃率: 时间范围内投标用户数/累计注册用户数
	 */
	static function bidLivelyRate($date = null, $end = null)
	{
		$newUserCount = self::newUserCount($date, $end);
		if ($newUserCount < 1)
			return 0;

		$bidUserCount = self::bidUserCount($date, $end);
		return sprintf('%.2f', $bidUserCount / $newUserCount);
	}

	static function areas()
	{
		$list = M('user')->distinct(true)->field('province')->select();
		return self::getValuesOfListByField($list, 'province');
	}

	/**
	 * 按时间区域获取标信息、数量、已完成、进行中、已流标、耗时等
	 */
	static function loan($date = null, $end = null, $condition = null)
	{
		$map['status'] = self::status('loan');
		$map['addtime'] = self::whereOfTimeArea($date, $end);

		if (is_array($condition)) {
			list($min, $max) = $condition['area'];
			$where = ['between', [$min, $max]];
			$map[$condition['field']] = $where;
		}

		$list = M('loan')->where($map)->select();

		$count = $ok_count = $doing_count = $flow_count = 0;
		$loan_tender_time = $tender_count = 0;

		$count = count($list);
		foreach ($list as $loan) {
			if ($loan['endtime'])
				$loan_tender_time += $loan['endtime'] - $loan['begintime'];
			$tender_count += $loan['tender_count'];
			switch ($loan['status']) {
				case Hao_Status::$loan['招标中']:
				case Hao_Status::$loan['满标待审']:
				case Hao_Status::$loan['还款中']:
					$doing_count++;
					break;
				case Hao_Status::$loan['流标中']:
				case Hao_Status::$loan['已流标']:
					$flow_count++;
					break;
				default:
					$ok_count++;
					break;
			}
		}
		$tender_avgtime = 0;
		if ($count)
			$tender_avgtime = $loan_tender_time / $count;
		return [
			'count'	=>	$count,
			'ok_count'	=>	$ok_count,
			'doing_count'	=>	$doing_count,
			'flow_count'	=>	$flow_count,
			'tender_avgtime'	=>	$tender_avgtime,
			'tender_count'	=>	$tender_count
		];
	}

}
