<?php
//当前的url地址
//echo $url = $_SERVER['REQUEST_URI'];
// 目录分隔符，是定义php的内置常量
define('DS', DIRECTORY_SEPARATOR);
// 定义应用目录
define('APP_PATH', dirname(__DIR__) . DS . 'laixhecom' . DS);
// 开启调试模式
define('APP_DEBUG', true);
// 加载框架引导文件
require dirname(__DIR__) . '/framework/start.php';