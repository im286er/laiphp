<?php
//设置字符集
header('Content-Type:text/html;charset=utf-8');
//设置时区
date_default_timezone_set('PRC');
//开启session
//session_start();

/**
 * 应用目录
 */
//define('APP_PATH', dirname(__DIR__).'/app/');

//引入框架
require dirname(__DIR__).'/library/start.php';