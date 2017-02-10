<?php

$config = array(
    'webroot_dir' => 'C:\xampp\htdocs\systembookrental',
    'lib_dir' => 'C:\xampp\htdocs\systembookrental\lib',
    'admin_mail' => 'hara@un-t.com',
    'debug' => true,
);

define('TPL_DIR', $config['webroot_dir'] . '\tpl');
define('CACHE_DIR', $config['webroot_dir'] . 'twig_cache');
define('VENDOR_DIR', $config['webroot_dir'] . '\vendor');
define('DEBUG', $config['debug']);
