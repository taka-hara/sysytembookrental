<?php
require_once dirname(__FILE__) . '/lib/config.php';
require_once CTL_DIR . '/SystemBookRental.php';

//セッション開始
session_start();

$app = new SystemBookRental();
$app->dispatch();
