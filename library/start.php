<?php
//引入 框架常量
require __DIR__.'/base.php';

//引入自动加载
require ROOT_PATH.'/vendor/autoload.php';


//运行项目
\library\bin\App::run();


//print_r(\library\bin\Config::load());
