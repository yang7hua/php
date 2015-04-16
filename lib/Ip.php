<?php

class Ip 
{

    private $_dbfile = null;
    private $_dbfp = null;
    private $startIp;
    private $endIp;
    private $firstIpPos;
    private $endIpPos;
    public $country = '';
    public $local = '';

    public function __construct($dbfile)
    {
        $this->_dbfile = $dbfile;
    }

    public function getStartIp($no)
    {
        $offset = $this->firstIpPos + $no * 7;
        fseek($this->_dbfp, $offset, SEEK_SET);
        $buf = fread($this->_dbfp, 7);
        $this->startIp  = $this->buf2int(substr($buf, 0, 4));
        $this->endIpPos = $this->buf2int(substr($buf, 4));
        return $this->startIp;
    }

    public function getEndIp()
    {
        fseek($this->_dbfp, $this->endIpPos, SEEK_SET);
        $buf = fread($this->_dbfp, 5);
        $this->endIp = $this->buf2int(substr($buf, 0, 4));
        $this->countryFlag = ord($buf[4]);
        return $this->endIp;
    }
    
    public function getCountry()
    {
        $this->country = $this->getData($this->endIpPos + 4);
        if ($this->countryFlag == 1) {
            $this->local =  '';
        } else if ($this->countryFlag == 2) {
            $this->local = $this->getData($this->endIpPos + 8);
        } else {
            $this->local = $this->getData(ftell($this->_dbfp));
        }

        if (!empty($this->country)) {
            $this->country = iconv('GBK', 'UTF-8', $this->country);
            $this->country = str_replace(array('CZ88.NET','纯真网络'), array('',''), $this->country);
        }

        if (!empty($this->local)) {
            $this->local = iconv('GBK', 'UTF-8', $this->local);
            $this->local = str_replace(array('CZ88.NET','纯真网络'), array('',''), $this->local);
        }
    }

    public function query($ip)
    {
        if (preg_match("/[.0-9^]/", $ip) > 0) {
            $ip = gethostbyname($ip);
        }

        if (substr($ip, 0, 4) == '127.') {
            return '本地';
        }
        if (substr($ip, 0, 4) == '192.') {
            return '局域网';
        }
        $ip = ip2long($ip);

        $this->_dbfp = fopen($this->_dbfile, 'rb');
        if (!$this->_dbfp) {
            return '数据加载失败';
        }

        $head = fread($this->_dbfp, 8);
        $this->firstIpPos = $this->buf2int(substr($head, 0, 4));
        $this->lastIpPos = $this->buf2int(substr($head, 4));
        $total = intval(($this->lastIpPos - $this->firstIpPos)/7);
        if ($total < 2) {
            fclose($this->_dbfp);
            return '数据出错';
        }

        $start = 0;
        $end = $total;
        while ($start + 1 < $end) {
            $no = intval(($start + $end)/2);
            if ($ip == $this->getStartIp($no)) {
                $start = $no;
                break;
            }
            if ($ip > $this->startIp) {
                $start = $no;
            } else {
                $end = $no;
            }
        }
        $this->getStartIp($start);
        $this->getEndIp();

        if ($this->startIp <= $ip && $this->endIp >= $ip) {
            $this->getCountry();

        } else {
            $this->country = '未知';
            $this->local = '';
        }

        fclose($this->_dbfp);
        
        return $this->country.' '.$this->local;
    }
    
    public function getData($offset)
    {
        while (true) {
            fseek($this->_dbfp, $offset, SEEK_SET);
            $flag = ord(fgetc($this->_dbfp));
            if ($flag != 1 && $flag != 2) {
                break;
            }
            $buf = fread($this->_dbfp, 3);
            if ($flag == 2) {
                $this->countryFlag = 2;
                $this->endIpPos = $offset - 4;
            }
            $offset = $this->buf2int(substr($buf, 0, 3));
        }

        if ($offset < 12) {
            return '';
        }

        fseek($this->_dbfp, $offset, SEEK_SET);
        
        $str = '';
        while (!feof($this->_dbfp)) {
            $c = fgetc($this->_dbfp);
            if (ord($c) == 0) {
                break;
            }
            $str .= $c;
        }

        return $str;
    }

    public function buf2int($buf)
    {
        $value = ord($buf[0]);
        for ($i = 1; $i < strlen($buf) && $i < 8; $i ++) {
            $value += ord($buf[$i]) << (8*$i);
        }
        return $value;
    }

}

