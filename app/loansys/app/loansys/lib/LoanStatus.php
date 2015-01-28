<?php

namespace App;

class LoanStatus 
{
	/**
	 * 是否需要初审
	 */
	static function needFace($status)
	{
		$status_face = self::getStatusFace();
		return $status < $status_face;
	}

	/**
	 * 是否需要外访
	 */
	static function needVisit($status)
	{
		$status_face = self::getStatusFace();
		$status_checked = self::getStatusChecked();
		$status_visit = self::getStatusVisit();
		$status_reface = self::getStatusReface();
		//return $status >= $status_face and $status < $status_checked and $status != $status_visit;
		return $status >= $status_face and $status < $status_checked;
	}

	/**
	 * 是否需要车评
	 */
	static function needCarAssess($status)
	{
		$status_car = self::getStatusCarAssess();
		$status_checked = self::getStatusChecked();
		$status_face = self::getStatusFace();
		$status_reface = self::getStatusReface();
		//return $status >= $status_face and $status < $status_checked and $status != $status_car;
		return $status >= $status_face and $status < $status_checked;
	}

	static function needRunConfirm($status)
	{
		$status_rcagree = self::getStatusRcAgree();
		$status_runconfirm = self::getStatusRunConfirm();
		return $status >= $status_rcagree and $status < $status_runconfirm;
	}

	/**
	 * 是否需要复审
	 */
	static function needReface($status)
	{
		$status_checked = self::getStatusChecked();
		$status_reface = self::getStatusReface();
		return $status == $status_checked;
	}

	static function needRc($status)
	{
		$status_reface = self::getStatusRc();
		return $status == $status_reface;
	}

	/**
	 * 已实地外访
	 */
	static function hasVisit($status)
	{
		return $status == self::getStatusVisit();
	}

	/**
	 * 已车评
	 */
	static function hasCarAssess($status)
	{
		return $status == self::getStatusCarAssess();
	}

	/**
	 * 是否是一个案件
	 */
	static function isCase($status)
	{
		return $status == self::getStatusRc();
	}

	static function getStatus($text)
	{
		$status = \App\Config\Loan::status();
		return \Func\getArrayKey($status, $text);
	}

	static function getStatusText($_status)
	{
		static  $status = null;
		!$status and ($status = \App\Config\Loan::status());
		return \Func\getArrayValue($status, $_status);
	}

	static function getStatusSketch()
	{
		return self::getStatus('草稿');
	}

	static function getStatusFace()
	{
		return self::getStatus('初审');
	}

	static function getStatusVisit()
	{
		return self::getStatus('实地外访');
	}

	static function getStatusCarAssess()
	{
		return self::getStatus('车评');
	}

	/**
	 * 核查完毕，包括 实地外访、车评
	 */
	static function getStatusChecked()
	{
		return self::getStatus('核查完毕');
	}

	static function getStatusReface()
	{
		return self::getStatus('复审');
	}

	//推送到全国风控中心的案子
	static function getStatusRc()
	{
		return self::getStatusReface();
	}

	//全国风控中心已处理
	static function getStatusRcAgree()
	{
		return self::getStatus('审核通过');
	}

	//全国风控中心已处理-拒绝
	static function getStatusRcRefuse()
	{
		return self::getStatus('拒绝');
	}

	//同意放款
	static function getStatusRunConfirm()
	{
		return self::getStatus('同意放款');
	}

	//还款中
	static function getStatusRepay()
	{
		return self::getStatus('还款中');
	}

}
