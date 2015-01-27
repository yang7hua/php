<?php

define('WEB_PATH', __DIR__);
define('ROOT_PATH', realpath(WEB_PATH . '/../'));
define('PUBLIC_PATH', '/public');

define('APP_ONLINE', $_SERVER['HTTP_HOST'] == 'loansys.yiqihao.com');

define('ADM_NAME', 'sysadm');
define('FRONT_NAME', 'loansys');

$URI = explode('/', $_SERVER['REQUEST_URI']);

define('APP_NAME', $URI[1] == ADM_NAME ? ADM_NAME : FRONT_NAME);

define('APP_PATH', ROOT_PATH . '/app/' . APP_NAME);
define('APP_DEBUG', true);

include ROOT_PATH . '/index.php';
