<?php

define('WEB_PATH', __DIR__);
define('ROOT_PATH', realpath(WEB_PATH . '/../'));
define('PUBLIC_PATH', WEB_PATH . '/public');

define('ADM_NAME', 'adm');

$URI = explode('/', $_SERVER['REQUEST_URI']);

define('APP_NAME', $URI[1] == ADM_NAME ? ADM_NAME : 'loansys');

define('APP_PATH', ROOT_PATH . '/app/' . APP_NAME);
define('APP_DEBUG', true);

include ROOT_PATH . '/index.php';
