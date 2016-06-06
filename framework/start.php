<?php
namespace lai;

//加载基础文件
require __DIR__ . '/base.php';
require LAI_PATH . 'Loader.php';

//开启调试模式
if(APP_DEBUG){
    //报告所有 PHP 错误
    error_reporting(E_ALL);
}else{
    //ini_set('display_errors', 'Off');
    //关闭所有PHP错误报告
    error_reporting(0);
}

//注册自动加载
Loader::register();

//注册异常处理
Errorset::register();

//自动运行
App::run();