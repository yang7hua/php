<?php

class Adm_Action_Bi extends Adm_Action
{
	/**
	 * 默认搜索条件
	 */
	private function defaultSearchCondition($key = null)
	{
		$today = date('Y-m-d');
		$last7days = date('Y-m-d', strtotime(date('Y-m-d') . ' -7day'));
		$conditions = [
			'base'	=>	['sdate' =>	$last7days, 'edate'	=>	$today],
			'total'	=>	['edate' =>	$today],
			'rate'	=>	['sdate' =>	$today],
			'recharge'	=>	['sdate' =>	$last7days, 'edate' => $today],
			'behavior_newuser'	=>	['sdate' =>	$last7days, 'edate'	=> $today],
			'behavior_lively'	=>	['sdate' => $today],
			'behavior_recharge_type'	=>	['sdate' =>	$last7days, 'edate'	=> $today],
		];
		return ($key and array_key_exists($key, $conditions)) ? $conditions[$key] : $conditions;
	}

	function _initialize()
	{
		if (!$this->isAjax())
			$this->assign($this->defaultSearchCondition());
	}

	function index()
	{
		$this->base();
	}

	private function checkDate($action = null)
	{
		$params = $_POST;
		$sdate = $params['sdate'];
		$edate = $params['edate'];

		is_null($action) and $action = ACTION_NAME;
		$action == 'index' and $action = 'base';

		empty($sdate) and empty($edate) and list($sdate, $edate) = $this->defaultSearchCondition($action);
		$sdate and $edate and $sdate >= $edate and $this->error('起始日期必须小于截止日期');

		$dates = [];
		if (!$edate) {
			$dates[] = $sdate;
		} else {
			$diff_days = ceil((strtotime($edate) - strtotime($sdate)) / 86400);
			for ($i=$diff_days; $i>0; $i--) {
				if (count($dates) >= 15)
					$this->error('最多连续查询15天的数据');
				$dates[] = date('Y-m-d', strtotime($sdate . ' +' . $i . 'day'));
			}
		}
		return [$sdate, $edate, $dates];
	}

	/**
	 * 基本数据
	 */
	function base()
	{
		list($sdate, $edate, $dates) = $this->checkDate();	
		$data = [];
		$total = ['date'=>'合计', 'arpu'=>'-', 'recharge_arpu'=>'-', 'reg_bid_arpu'=>'-'];
		foreach ($dates as $date) {
			$row = [
				'date'	=>	$date,
				'newuser_count'	=>	Hao_Bi::newUserCount($date),
				'login_count'	=>	Hao_Bi::loginUserCount($date),
				'recharge_count'	=>	Hao_Bi::rechargeUserCount($date),
				'recharge_amount'	=>	Hao_Bi::rechargeAmount($date),
				'bid_count'	=>	Hao_Bi::bidUserCount($date),
				'bid_amount'	=>	Hao_Bi::bidAmount($date),
				'drawcash_count'	=>	Hao_Bi::drawcashUserCount($date),
				'drawcash_amount'	=>	Hao_Bi::drawcashAmount($date),
				'arpu'	=>	Hao_Bi::arpu($date),
				'recharge_arpu'	=>	Hao_Bi::arpuOfRecharge($date),
				'reg_bid_arpu'	=>	Hao_Bi::arpuOfUserBid($date),
			];
			$total['newuser_count'] += $row['newuser_count'];
			$total['login_count'] += $row['login_count'];
			$total['recharge_count'] += $row['recharge_count'];
			$total['recharge_amount'] += $row['recharge_amount'];
			$total['bid_count'] += $row['bid_count'];
			$total['bid_amount'] += $row['bid_amount'];
			$total['drawcash_count'] += $row['drawcash_count'];
			$total['drawcash_amount'] += $row['drawcash_amount'];
			$data[] = $row;
		}
		$data[] = $total;
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}

		$this->assign($data);
		$this->display();
	}

	/**
	 * 累计数据
	 */
	function total()
	{
		$edate = $_REQUEST['edate'];
		$data = [
				'user_count'	=>	Hao_Bi::newUserCount(null, $edate),
				'online_days'	=>	Hao_Bi::daysOfOnline($edate),
				'single_user_count'	=>	Hao_Bi::singleUserCount(null, $edate),
				'recharge_user_count'	=>	Hao_Bi::rechargeUserCount(null, $edate),
				'recharge_amount'	=>	Hao_Bi::rechargeAmount(null, $edate),
				'bid_user_count'	=>	Hao_Bi::bidUserCount(null, $edate),
				'bid_amount'	=>	Hao_Bi::bidAmount(null, $edate),
				'bid_arpu'	=>	Hao_Bi::arpuOfBid(null, $edate),
				'drawcash_user_count'	=>	Hao_Bi::drawcashUserCount(null, $edate),
				'drawcash_amount'	=>	Hao_Bi::drawcashAmount(null, $edate),
		];
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}
		$this->assign($data);
		$this->display();
	}

	/**
	 * 转换率
	 */
	function rate()
	{
		list($sdate) = $this->checkDate();
		$dates['当天'] = [$sdate, null];
		$dates['前1天'] = ['yesterday', $sdate];
		$dates['近7天'] = ['-7day', $sdate];
		$dates['近1月'] = ['-1month', $sdate];

		$data = [];
		foreach ($dates as $key=>$date) {
			$data[] = [
				'date'	=>	$key,
				'reg_convert_rate'	=>	Hao_Bi::regConvertRate($date[0], $date[1]),
				'recharge_convert_rate'	=>	Hao_Bi::rechargeConvertRate($date[0], $date[1]),
				'bid_convert_rate'	=>	Hao_Bi::bidConvertRate($date[0], $date[1]),
				'bid_lively_rate'	=>	Hao_Bi::bidLivelyRate($date[0], $date[1]),
			];
		}
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}
		$this->assign($data);
		$this->display();
	}

	/**
	 * 充值细分数据
	 */
	function recharge()
	{
		list($sdate, $edate, $dates) = $this->checkDate();
		$data = [];
		$total = ['date'=>'合计'];
		foreach ($dates as $date) {
			$new_user_recharge = Hao_Bi::newRecharge($date);
			$row = [
				'date'	=>	$date,
				'new_recharge_user_count'	=>	count($new_user_recharge['new_uids']),
				'new_recharge_amount'	=>	$new_user_recharge['new_amount'],
				'recharge_user_count'	=>	count($new_user_recharge['uids']),
				'recharge_amount'	=>	$new_user_recharge['amount'],
			];
			$row['new_recharge_user_rate']	=	$row['recharge_user_count'] < 1 
												? 0
												: sprintf('%.2f', $row['new_recharge_user_count'] / $row['recharge_user_count']);
			$row['new_recharge_amount_rate']	=	$row['recharge_amount'] < 1
												? 0
												: sprintf('%.2f', $row['new_recharge_amount'] / $row['recharge_amount']);
			$row['recharge_convert_rate']	=	Hao_Bi::rechargeConvertRate($date);
			$total['new_recharge_user_count'] += $row['new_recharge_user_count'];
			$total['new_recharge_amount'] += $row['new_recharge_amount'];
			$total['recharge_user_count'] += $row['recharge_user_count'];
			$total['recharge_amount'] += $row['recharge_amount'];
			$total['new_recharge_user_rate'] += $row['new_recharge_user_rate'];
			$total['new_recharge_amount_rate'] += $row['new_recharge_amount_rate'];
			$total['recharge_convert_rate'] += $row['recharge_convert_rate'];
			$data[] = $row;
		}
		$data[] = $total;
		$this->output([
			'data'	=>	$data
		]);
		$this->assign($data);
		$this->display();
	}

	/**
	 * 行为数据 - 新增用户
	 */
	function behavior_newuser()
	{
		list($sdate, $edate, $dates) = $this->checkDate();
		$data = [];
		$total = [
			'date'	=>	'合计'
		];
		foreach ($dates as $date) {
			$new_recharge = Hao_Bi::newRecharge($date);
			$new_and_recharge = Hao_Bi::newUserAndRechargeUser($date);
			$new_bid = Hao_Bi::newBid($date);
			$new_and_bid = Hao_Bi::newUserAndBidUser($date);
			$row = [
				'date'	=>	$date,
				'new_reg_user_count'	=>	Hao_Bi::newUserCount($date),
				'new_recharge_user_count'	=>	count($new_recharge['new_uids']),	
				'new_recharge_amount'	=>	$new_recharge['new_amount'],
				'new_bid_user_count'	=>	count($new_bid['uids']),
				'new_bid_amount'	=>	$new_bid['amount'],
				'new_reg_recharge_rate'	=>	empty($new_and_recharge['new_uids']) 
											? 0 
											: sprintf('%.4f', count($new_and_recharge['new_recharge_uids']) / count($new_and_recharge['new_uids'])),
				'new_reg_bid_rate'	=>	empty($new_and_bid['new_uids'])
										? 0
										: sprintf('%.4f', count($new_and_bid['new_bid_uids']) / count($new_and_bid['new_uids'])),
				'new_recharge_arpu'	=>	empty($new_recharge['new_uids'])
										? 0
										: sprintf('%.4f', $new_recharge['new_amount'] / count($new_recharge['new_uids'])),
				'new_bid_arpu'	=>	empty($new_bid['uids'])
										? 0
										: sprintf('%.4f', $new_bid['amount'] / count($new_bid['uids'])),
			];
			$total['new_reg_user_count'] += $row['new_reg_user_count'];
			$total['new_recharge_user_count'] += $row['new_recharge_user_count'];
			$total['new_recharge_amount'] += $row['new_recharge_amount'];
			$total['new_bid_user_count'] += $row['new_bid_user_count'];
			$total['new_bid_amount'] += $row['new_bid_amount'];
			$total['new_reg_recharge_rate'] = $total['new_reg_bid_rate'] = $total['new_recharge_arpu'] = $total['new_bid_arpu'] = '-';
			$data[] = $row;
		}
		$data[] = $total;
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}
		$this->assign($data);
		$this->display();
	}

	/**
	 * 行为分析 - 活跃数据
	 */
	function behavior_lively()
	{
		list($sdate) = $this->checkDate();

		$user_count = Hao_Bi::newUserCount();
		$data[] = [
			'type'	=>	'DAU',
			'login'	=>	Hao_Bi::loginUserCount($sdate) / $user_count,
			'recharge'	=>	Hao_Bi::rechargeUserCount($sdate) / $user_count,	
			'bid'	=>	Hao_Bi::bidUserCount($sdate) / $user_count
		];
		$data[] = [
			'type'	=>	'WAU',
			'login'	=>	Hao_Bi::loginUserCount('this week', $sdate) / $user_count,
			'recharge'	=>	Hao_Bi::rechargeUserCount('this week', $sdate) / $user_count,	
			'bid'	=>	Hao_Bi::bidUserCount('this week', $sdate) / $user_count
		];
		$data[] = [
			'type'	=>	'MAU',
			'login'	=>	Hao_Bi::loginUserCount('this month', $sdate) / $user_count,
			'recharge'	=>	Hao_Bi::rechargeUserCount('this month', $sdate) / $user_count,	
			'bid'	=>	Hao_Bi::bidUserCount('this month', $sdate) / $user_count
		];
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}
		$this->assign($data);
		$this->display();
	}

	/**
	 * 行为分析 - 充值渠道
	 */
	function behavior_recharge_type()
	{
		list($sdate, $edate) = $this->checkDate();
		$rechargeTypes = Hao_Bi::rechargeTypes();

		$data = [];
		$total = ['type'=>'合计'];
		foreach ($rechargeTypes as $rtype) {
			$recharge = Hao_Bi::rechargeByRtype($rtype, $sdate, $edate);
			$row = [
				'type'	=>	$rtype,
				'recharge_user_count'	=>	count($recharge['uids']),
				'new_recharge_user_count'	=>	$recharge['first_user_count'],
				'recharge_amount'	=>	$recharge['amount'],
				'recharge_count'	=>	$recharge['count'],
				'recharge_ok_count'	=>	$recharge['ok'],
			];
			$row['recharge_ok_rate'] = $row['recharge_count'] ? $row['recharge_ok_count'] / $row['recharge_count'] : 0;
			$total['recharge_user_count'] += $row['recharge_user_count'];
			$total['new_recharge_user_count'] += $row['new_recharge_user_count'];
			$total['recharge_amount'] += $row['recharge_amount'];
			$total['recharge_count'] += $row['recharge_count'];
			$total['recharge_ok_count'] += $row['recharge_user_count'];
			$total['recharge_ok_rate'] += $row['recharge_ok_rate'];
			$data[] = $row;
		}
		$data[] = $total;
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	$data
			]);
		}
		$this->assign($data);
		$this->display();
	}

}
