<?php

namespace Apps;

class Compute
{
	/**
        计算总利息
        还款方式:
            m-按月等额本息,i-按月付息,到期还本,e-到期还本息
     */
    static function computeInterest($loan, $money = null)
    {
        if ($money !== null)
            $loan['amount'] = $money;
        switch ($loan['repay_method']) {
            case 'm':
                return self::getInterestByMonth($loan);
            case 'i':
                return self::getInterestByInterest($loan);
            case 'e':
                return self::getInterestByEnd($loan);
            default:
                return false;
        }
    }
    
    /*
        计算应还本息
        还款方式:
            m-按月分期,i-按月付息,到期还本,e-到期还本息
    */
    static function computeAmount($loan, $money = null)
    {
        if ($money !== null)
            $loan['amount'] = $money;
        return $loan['amount'] + self::computeInterest($loan);
    }
    
    /*
        计算第几期利息
        还款方式:
            m-按月分期,i-按月付息,到期还本,e-到期还本息
     */
    static function computeNoInterest($no, $loan, $money = null)
    {
        if ($money !== null)
            $loan['amount'] = $money;
        switch ($loan['repay_method']) {
            case 'm':
                return self::getNoInterestByMonth($no, $loan);
            case 'i':
                return self::getNoInterestByInterest($no, $loan);
            case 'e':
                return self::getNoInterestByEnd($no, $loan);
			case 'o':
				return self::getNoInterestByEqu($no, $loan);
			case 'g':
				if ($no <= 3) {
					return self::getNoInterestByInterest($no, $loan);
				} else{
					return self::getNoInterestByEqu($no, $loan, 9);
				}
            default:
                return false;
        }
    }
    
    /*
        计算第几期本息
        还款方式:
            m-按月分期,i-按月付息,到期还本,e-到期还本息
     */
    static function computeNoAmount($no, $loan, $money = null)
    {
        if ($money !== null)
            $loan['amount'] = $money;
        switch ($loan['repay_method']) {
            case 'm':
                $amount = ($loan['amount'] + self::getInterestByMonth($loan)) / $loan['deadline'];
                break;
            case 'i':
                $amount = self::getNoInterestByInterest($no, $loan);
                if ($loan['deadline'] == $no)
                    $amount += $loan['amount'];
                break;
            case 'e':
                $amount = 0;
                if ($no == $loan['deadline'])
                    $amount = self::getNoInterestByEnd($no, $loan) + $loan['amount'];
                break;
			case 'o':
				$amount = self::getNoInterestByEqu($no, $loan) + self::computeNoCapital($no, $loan);
				break;
			case 'g':
				/**
				 * 前3个月按月付息、到期还本，后9个月等本等息
				 * 原本3个月的到期还本, 后因无法偿还本金, 所以加了9个月的等本等息
				 */
				if ($no <= 3) {
					$amount = self::getNoInterestByInterest($no, $loan);
				} else{
					$amount = self::getNoInterestByEqu($no, $loan, 9) + self::computeNoCapital($no, $loan);
				}
				break;
            default:
                return false;
        }
        return sprintf('%0.2f', $amount);
    }
    
    /*
        计算第几期本金
        还款方式:
            m-按月分期,i-按月付息,到期还本,e-到期还本息
     */
    static function computeNoCapital($no, $loan, $money = null)
    {
        if ($money !== null)
            $loan['amount'] = $money;
        switch ($loan['repay_method']) {
            case 'i':
            case 'e':
                $capital = $no == $loan['deadline'] ? $loan['amount'] : 0;
                break;
            case 'm':
                $amount = ($loan['amount'] + self::getInterestByMonth($loan)) / $loan['deadline'];
                $capital = $amount - self::getNoInterestByMonth($no, $loan);
                break;
			case 'g':
			case 'o':
				$capital = $loan['amount'] / $loan['deadline'];
				break;
            default:
                return false;
        }
        return sprintf('%0.2f', $capital);
    }
    


    /*
        计算 按月分期付款(m) 利息
    */ 
    static function getInterestByMonth($loan)
    {
        $money = $loan['amount'];
        $month_num = $loan['deadline'];
        $month_apr = self::getMonthApr($loan);
        $i = pow((1+$month_apr), $month_num);
        $repayment = $money * $month_apr * $i / ($i-1);
        $total_interest = $repayment * $month_num - $money;
        return sprintf('%0.2f', $total_interest);
    }

    /*
        计算 到期还款，按月付息(i) 利息
    */ 
    static function getInterestByInterest($loan)
    {
        $interest = self::getMonthApr($loan)*$loan['amount']*$loan['deadline'];
        return sprintf('%0.2f', $interest);
    }

    /*
        计算 到期还本息(e) 利息
    */ 
    static function getInterestByEnd($loan)
    {
        $interest = self::getMonthApr($loan)*$loan['amount']*$loan['deadline'];
        return sprintf('%0.2f', $interest);
    }


     /*
        计算 按月分期付款(m) 第几期利息
    */ 
    static function getNoInterestByMonth($no, $loan)
    {
        $no --;
        $money = $loan['amount'];
        $month_num = $loan['deadline'];
        $month_apr = self::getMonthApr($loan);
        $i = pow((1+$month_apr), $month_num);
        $repayment = $money * $month_apr * ($i/($i-1));
        if ($no == 0) {
            $interest = $money * $month_apr;
        } else {
            $i = pow((1+$month_apr), $no);
            $interest = $repayment + ($money*$month_apr - $repayment)*$i;
        }
        return sprintf('%0.2f', $interest);
    }

    /*
        计算 到期还款，按月付息(i) 第几期利息
    */ 
    static function getNoInterestByInterest($no, $loan)
    {
        $interest = self::getMonthApr($loan)*$loan['amount'];
        return sprintf('%0.2f', $interest);
    }

    /*
        计算 到期还本息(e) 第几期利息
    */ 
    static function getNoInterestByEnd($no, $loan)
    {
        if ($no < $loan['deadline'])
            return '0.00';
        $interest = self::getMonthApr($loan)*$loan['amount'];
        return sprintf('%0.2f', $interest*$loan['deadline']);
    }

	/**
	 * 计算 等本等息(o) 第几期利息
	 */
	static function getNoInterestByEqu($no, $loan, $deadline = null)
	{
		$interest = self::getMonthApr($loan) * $loan['amount'];
		return sprintf('%0.2f', $interest);

		$deadline or $deadline = $loan['deadline'];
		return sprintf('%0.2f', ($loan['amount'] / $deadline) + $interest);
	}
    
    static function getMonthApr($loan)
    {
        $apr = $loan['apr'];
		return $apr/100;
        if (!empty($loan['reward_apr']))
            $apr += $loan['reward_apr'];
        if (!empty($loan['days']))
            $apr = sprintf('%0.2f', $loan['days']/30.0*$apr);
        return $apr/1200.0;
    } 

}
