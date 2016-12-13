<?php
//设置字符集
//header('Content-Type:text/html;charset=utf-8');
//设置时区
//date_default_timezone_set('PRC');

//引入 框架常量
require __DIR__.'/base.php';

//引入 文件引入类
require LAIPHP_DIR.'bin'.DS.'Loadfile.php';
//引入 项目处理类
require LAIPHP_DIR.'bin'.DS.'App.php';




//开启session
//session_start();




App::run();
