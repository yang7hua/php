<?php

class Adm_Action_Bi extends Adm_Action
{
	function index()
	{
		/*
		echo Hao_Bi::newUserCount(),'<br/>';
		echo Hao_Bi::loginUserCount(),'<br/>';
		echo Hao_Bi::rechargeUserCount(),'<br/>';
		echo Hao_Bi::rechargeAmount(),'<br/>';
		echo Hao_Bi::bidUserCount(),'<br/>';
		echo Hao_Bi::bidAmount(),'<br/>';
		 */
		/*
		echo Hao_Bi::arpu(),'<br/>';
		echo Hao_Bi::daysOfOnline(),'<br/>';
		echo Hao_Bi::singleUserCount(),'<br/>';
		echo Hao_Bi::rechargeConvertRate(20141010),'<br/>';
		 */
		//echo Hao_Bi::bidConvertRate(),'<br/>';
		//echo Hao_Bi::bidLivelyRate('-3year'),'<br/>';
		//print_r(Hao_Bi::firstRechargeUserAmount(20141010));
		//print_r(Hao_Bi::firstBidUserAmount(20141012));
		//echo Hao_Bi::newUserAndBidUserBidRate(20150128);
		//echo Hao_Bi::rechargeRate(20150428);
		//print_r(Hao_Bi::newUserBidRate(20150229));
		$this->base();
	}

	private function checkDate()
	{
		$params = $_POST;
		$sdate = $params['sdate'];
		$edate = $params['edate'];
		empty($sdate) and empty($edate) and $this->error('请输入查询日期');
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
		if ($this->isAjax()) {
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
			$this->output([
				'data'	=>	$data
			]);
			exit();
		}

		$this->assign([
			//默认展示近7天的数据
			'base'	=>	[
				'sdate'	=>	date('Y-m-d', strtotime(date('Y-m-d') . ' -7day')),
				'edate'	=>	date('Y-m-d')
			]
		]);
		$this->display('index');
	}

	function total()
	{
		$data = [
				'user_count'	=>	Hao_Bi::newUserCount(),
				'online_days'	=>	Hao_Bi::daysOfOnline(),
				'single_user_count'	=>	Hao_Bi::singleUserCount(),
				'recharge_user_count'	=>	Hao_Bi::rechargeUserCount(),
				'recharge_amount'	=>	Hao_Bi::rechargeAmount(),
				'bid_user_count'	=>	Hao_Bi::bidUserCount(),
				'bid_amount'	=>	Hao_Bi::bidAmount(),
				'bid_arpu'	=>	Hao_Bi::arpuOfBid(),
				'drawcash_count'	=>	Hao_Bi::drawcashUserCount(),
				'drawcash_amount'	=>	Hao_Bi::drawcashAmount(),
		];
		if ($this->isAjax()) {
			$this->output([
				'data'	=>	[$data]
			]);
		}
		$this->assign([
			'data'	=>	$data
		]);
		$this->display();
	}

}
