<?php

class Hao_Pay_Nepay
{

	public $bankCode = array(
		'boc'	=>	'bocsh',
		'bocom'	=>	'comm',
		'psbc'	=>	'postgc',
		'cncb'	=>	'citic',
		'hxb'	=>	'hxbc',
		'bos'	=>	'shb',
		'bccb'	=>	'bob',
		'cbhb'	=>	'bohb',
	);

    public $config = array(
        //'id'=>'123456',
        //'key'=>'e10adc3949ba59abbe56e057f20f883e',
    );

    public $params = array(
        'Merno'=>'', /*商户号*/
        'Signtype'	=>	'M', /*加密类型*/
        'Prdordno'	=>	'', /*商户订单号*/
		'bizType'	=>	10,	//业务类型
        'Prdordnam'	=>	'', /*商品名称*/
        'Ordamt'	=>	'', /*订单金额，以分为单位*/
		'Orddate'	=>	'', //下单日期 YYYYmmdd
		'TranType'	=>	2201, //交易类型
		'Paytype'	=>	'01',	//支付方式
		'bankCode'	=>	'', //银行编码

        'Return_url'=>'', /*页面返回url*/
        'Notify_url'=>'', /*异步通知url*/

		'inMsg'	=>	'', //签名数据
    ); 
    
    public $return = array(
        'Merno'	=>	'', /*商户号*/
        'Prdordno'	=>	'', /*商户订单号*/
		'settleDate'	=>	'', //下单日期
		'ordStatus'	=>	'', //订单状态, 1：扣款成功2：扣款失败
		'payOrdNo'	=>	'', //订单流水号
		'Ordamt'	=>	'', //金额
		'signType'	=>	'M',
		'signature'	=>	'', //签名
		'Paychannel'	=>	'XFZF'
    );

    public function __construct($config=array())
    {
        $this->init($config);
    }

    public function init($config)
    {
        $this->config = array_merge($this->config, $config);
        $params = array();
        $params['Merno'] = $this->config['id'];
        $params['Return_url'] = $this->config['return_url'];
        $params['Notify_url'] = $this->config['notify_url'];

        if (!empty($this->config['bankid'])) {
            $params['bankCode'] = $this->getBankId($this->config['bankid'], false);
        }

        $this->params = array_merge($this->params, $params);
    }
    
    public function getSubmit($order)
    {
        if (!isset($order['no']) || !isset($order['amount']))
            return false;
        $config = $this->config;
        $params = $this->params;

        $params['Ordamt'] = sprintf('%0.0f', $order['amount']*100);
        $params['Prdordno'] = $order['no'];
        $params['Orddate'] = date('YmdHis');

        extract($params);
        $MARK = '|';
        $Md5key = $this->config['key'];
		$signInfo = md5($Merno.'&'.$Signtype.'&'.$Prdordo.'&'.$Prdordnam.'&'.$Ordamt.'&'.$Orddate.'&'.$TranType.'&'.$Paytype.'&'.$Notify_url.'&'.$Md5key);
        $params['inMsg'] = $signInfo;

        $submit = array();
        $submit['url'] = $config['url'];
        $submit['query'] = $params;
        return $submit;
    }

    public function check($params)
    {
        if (empty($params['MemberID']) || $params['MemberID'] != $this->config['id'])
            return '商户号不匹配';

        $newParams = array();
        foreach ($this->return as $key=>$val) {
            $newParams[$key] = isset($params[$key]) ? $params[$key] : '';
        }

        $params = $newParams;
        
        if ($params['Result'] !== '1') {
            $errorMap = array(
                '0000'=>'支付失败',
                '0001'=>'系统错误',
                '0002'=>'订单超时',
                '0011'=>'系统维护',
                '0012'=>'无效商户',
                '0013'=>'余额不足',
                '0014'=>'超过支付限额',
                '0015'=>'卡号或卡密错误',
                '0016'=>'不合法的IP地址',
                '0017'=>'重复订单金额不符',
                '0018'=>'卡密已被使用',
                '0019'=>'订单金额错误',
                '0020'=>'支付的类型错误',
                '0021'=>'卡类型有误',
                '0022'=>'卡信息不完整',
                '0023'=>'卡号，卡密，金额不正确',
                '0024'=>'不能用此卡继续做交易',
                '0025'=>'订单无效',
            );
            $errno = $params['ResultDesc'];
            $error = isset($errorMap[$errno]) ? $errorMap[$errno] : '未知错误';
            return '支付失败，原因是：'.$error;
        } 

        extract($params);
        $MARK = '~|~';
        $Md5key = $this->config['key'];
        $signInfo = md5('MemberID='.$MemberID.$MARK.'TerminalID='.$TerminalID.$MARK.'TransID='.$TransID.$MARK.'Result='.$Result.$MARK.'ResultDesc='.$ResultDesc.$MARK.'FactMoney='.$FactMoney.$MARK.'AdditionalInfo='.$AdditionalInfo.$MARK.'SuccTime='.$SuccTime.$MARK.'Md5Sign='.$Md5key);

        if ($signInfo != $Md5Sign)
            return '验证数据签名失败';

        $order = array();
        $order['no'] = $TransID;
        $order['amount'] = sprintf('%0.2f', $FactMoney/100);
        $order['trade_no'] = '';
        $order['type'] = $this->config['type'];

        return $order;
    }

    public function getRemark($params)
    {
        return isset($params['AdditionalInfo']) ? $params['AdditionalInfo'] : '';
    }
    
    public function getUid($params)
    {
        return true;
    }

    public function notify($res, $params)
    {
        if (!is_string($res))
            return 'OK';
        return 'ERROR';
    }

    protected function getBankId($code, $flag=true)
    {
        if ($flag) {
            $map = $this->bankCode;
            if (isset($map[$code]))
                $code = $map[$code];
            return strtoupper($code);
        } else {
            $map = array_flip($this->bankCode);
            if (isset($map[$code]))
                $code = $map[$code];
            return strtolower($code);
        }
    }
    
    protected function getBankName($code)
    {
        $code = $this->getBankId($code, false);
        $bankname = Hao_Config_Recharge::$allbanklist;
        return isset($bankname[$code]) ? $bankname[$code] : '';
    }
}

