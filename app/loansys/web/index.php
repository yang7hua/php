<?php

define('WEB_PATH', __DIR__);
define('ROOT_PATH', realpath(WEB_PATH . '/../'));
define('PUBLIC_PATH', WEB_PATH . '/public');

define('APP_NAME', 'loansys');
define('APP_PATH', ROOT_PATH . '/app/' . APP_NAME);
define('APP_DEBUG', true);

include ROOT_PATH . '/index.php';
