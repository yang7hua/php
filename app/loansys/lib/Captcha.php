<?php
namespace Util;

class Captcha {
    
    public static function make($width=85, $height=35, $color=null, $type='png', $force=0, $captchaName='verify', $length=4, $fontface='')
    {
        if ($width > 200 || $width < 40) $width = 85;
        if ($height < 20 || $height > 200) $height = 35;
        if ($height > $width) $height = $width;
        
        if ($force == 1 || $force == -1) {
            $code = ''.mt_rand(1000, 9999);
            $captchaName .= '_num';
            if ($force == 1)
                $force = 0;
        } else {
            $code = self::getCode($length);
        }

        if (!empty($captchaName)) {
			global $di;
			$session = $di->get('session');
            $session->set($captchaName, md5(strtolower($code)));
            $session->set($captchaName . '_time', time());
        }

        $im = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($im, 255, 255, 255);
        if ($type == 'tpng') {
            imagecolortransparent($im, $bgColor);
        }
        
        //imagefilledrectangle($im, 0, 0, $width, $height, $bgColor); 
        imagefill($im, 0, 0, $bgColor);

        if (empty($fontface)) {
            $fontface = dirname(__FILE__).'/fonts/abc.ttf';
        } elseif (!is_file($fontface)) {
            $fontface = dirname(__FILE__) . "/fonts/".$fontface;
        }

        if (!empty($color) && is_string($color)) {
            $color = self::parseColor($color);
        }
        if (is_array($color)) {
            $color = imagecolorallocate($im, $color[0], $color[1], $color[2]);
        }
        
        $zRate = $width > 60 ? 0.8 : 0.9;
        $zWidth  = intval($width * $zRate);
        $zHeight = intval($height * $zRate);
        $fontWidth = intval(($zWidth)/$length);
        $fontHeight = $zHeight;
        $fontsize = min($fontWidth, $fontHeight) - 5;
        if ($force > 10) {
            $fontsize = min($force, $fontsize);
            $force = 0;
        } else if ($force == 0 && $fontsize > 12) {
            $fontsize = mt_rand(12, $fontsize);
        }

        $yMin = intval($fontsize*1.2);
        $yMax = $zHeight;
        if ($yMin > $yMax) $yMin = $yMax;
        $xMin = intval($width * (1-$zRate));
        $xMax = intval($width - $fontsize * $length - $width * (1-$zRate) / 2 );
        if ($xMin >= $xMax) $xMin = $xMax;
        $x = mt_rand($xMin, $xMax);
        if ($force == 0)
            $rate = mt_rand(-15, 15);
        else
            $rate = $force;
        for ($i = 0; $i < $length; $i ++) {
            $fontcolor = $color !== null ? $color : imagecolorallocate($im, mt_rand(50, 150), mt_rand(50, 150), mt_rand(50, 150));
            imagettftext($im, $fontsize, $rate, $x+$i*$fontsize, mt_rand($yMin, $yMax), $fontcolor, $fontface, $code[$i]);
        }

        self::render($im, $type);

        return $code;
    }

    public static function getCode($length)
    {
        static $chars='ABCEFGHIJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $len = strlen($chars);
        $code = '';
        for ($i = 0, $m = 255; $i < $length; ) {
            $c = substr($chars, mt_rand(0,$len-1), 1);
            if ($m > 0 && stristr($code, $c)) {
                $m --;
                continue;
            }
            $code .= $c;
            ++ $i;
        }
        return $code;
    }

    public static function render($im, $type='png')
    {
        $type = self::parseType($type);

        header("Content-Type: image/$type");

        $imgFunc = 'image'.$type;
        $imgFunc($im);
        imagedestroy($im);
    }
    
    public static function parseType($type)
    {
        static $types = array('jpeg','png','gif');
        $type = strtolower($type);
        if ($type == 'jpg') {
            $type = 'jpeg';
        } else if (empty($type) || !in_array($type, $types)) {
            return 'png';
        }
        return $type;
    }

    public static function parseColor($str)
    {
        static $mapColor = array(
			'orange'	=>	'#ff6e00',
            'red'=>'#ff0000',
            'green'=>'#00ff00',
            'blue'=>'#0000ff',
            'black'=>'#000000'
        );

        $str = strtolower(trim($str, '#'));
        if (isset($mapColor[$str])) {
            $str = trim($mapColor[$str], '#');
        } else if (preg_match("/[^0-9a-f]/", $str)) {
            return null;
        }

        $len = strlen($str); 
        if ($len == 3) {
            $newstr = '';
            for ($i = 0; $i < 3; $i ++) {
                $newstr .= $str[$i].$str[$i];
            }
            $str = $newstr;
        } else if ($len != 6) {
            return null;
        }

        $color = array();
        $j = 0;
        for ($i = 0; $i < 6; $i += 2) {
            $color[$j++] = intval(base_convert($str[$i].$str[$i+1], 16, 10));
        }
        return $color;
    }
}

