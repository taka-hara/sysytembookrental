<?php
require_once 'lib/config.php';
require_once 'controller/appController.php';

//セッション開始
session_start();

$app = new appController();
$app->dispatch();
