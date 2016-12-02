<?php
//设置字符集
header('Content-Type:text/html;charset=utf-8');
//设置时区
date_default_timezone_set('PRC');

/**
 * 应用目录
 */
//define('APP_PATH', dirname(__DIR__).'/app/');

//引框架
require dirname(__DIR__).'/Lai/start.php';


echo '<pre>';

\library\debug\Debug::show();
echo 'get <br />';
print_r($_GET);