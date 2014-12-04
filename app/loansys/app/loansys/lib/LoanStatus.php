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
		return $status >= $status_face and $status < $status_checked and $status != $status_visit;
	}

	/**
	 * 是否需要车评
	 */
	static function needCarAssess($status)
	{
		$status_car = self::getStatusCarAssess();
		$status_checked = self::getStatusChecked();
		$status_face = self::getStatusFace();
		return $status >= $status_face and $status < $status_checked and $status != $status_car;
	}

	/**
	 * 是否需要复审
	 */
	static function needReface($status)
	{
		$status_checked = self::getStatusChecked();
		return $status == $status_checked;
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

	static function getStatus($text)
	{
		$status = \App\Config\Loan::status();
		return \Func\getArrayKey($status, $text);
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
}
