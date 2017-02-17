<?php

define('CHAR', 'UTF-8');
mb_internal_encoding(CHAR);

$config = array(
    'webroot_dir' => $_SERVER['DOCUMENT_ROOT'] . '/systembookrental',
    'debug' => false,
);

define('LIB_DIR', $config['webroot_dir'] . '/lib');
define('TPL_DIR', $config['webroot_dir'] . '/tpl');
define('CTL_DIR', $config['webroot_dir'] . '/controller');
define('MDL_DIR', $config['webroot_dir'] . '/model');
define('CACHE_DIR', $config['webroot_dir'] . '/twig_cache');
define('VENDOR_DIR', $config['webroot_dir'] . '/vendor');
define('DEBUG', $config['debug']);


$db_info = array(
    'host' =>'localhost',
    'db_name' => 'system_book_rental',
    'user_name' => 'root',
    'password' => 'tariton12',
    'table_name' => 'book_list',
);

/*
$db_info = array(
    'host' =>'localhost',
    'db_name' => 'system_book_rental',
    'user_name' => 'rentaladmin',
    'password' => 'ay3gDe7f4Re',
    'table_name' => 'book_list',
);
*/
define('DB_HOST', $db_info['host']);
define('DB_NAME', $db_info['db_name']);
define('DB_USER_NAME', $db_info['user_name']);
define('DB_PASSWORD', $db_info['password']);
define('DB_TABLE_NAME', $db_info['table_name']);
