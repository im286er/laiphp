<?php
//设置字符集
header('Content-Type:text/html;charset=utf-8');
//设置时区
date_default_timezone_set('PRC');
//开启session
session_start();

/**
 * 当前系统目录分隔符
 */
define('DS', DIRECTORY_SEPARATOR);


/**
 * 返回当前 Unix 时间戳和微秒数
 */
define('LAI_START_TIME', microtime(true));
/**
 * 返回分配给 PHP 的内存量
 */
define('LAI_START_MEM', memory_get_usage());


/**
 * 当前库的目录路径
 */
define('LAI_DIR', __DIR__.DS);
/**
 * 根目录路径
 */
define('ROOT_PATH', dirname(LAI_DIR).DS);


/**
 * 当前是 http 还是 https
 */
define('WEB_APP_HTTP', empty($_SERVER['REQUEST_SCHEME'])?'http://':$_SERVER['REQUEST_SCHEME'].'://');
/**
 * 获取当前域名
 */
define('WEB_APP_HOST', empty($_SERVER['HTTP_HOST'])?$_SERVER['SERVER_NAME']:$_SERVER['HTTP_HOST']);
/**
 * 当前完整的域名
 */
define('WEB_APP_URL',WEB_APP_HTTP.WEB_APP_HOST);


//自动加载
spl_autoload_register(function ($class){
    
    //判断是否有路径
    if(!empty($class)){
        $classExplode = explode('\\', $class);
        if($classExplode[0] == 'Lai'){
            require ROOT_PATH.$class.'.php';
        }elseif ($classExplode[0] == 'Extend'){
            require ROOT_PATH.$class.'.php';
        }
    }
    
},true,true);


//加载库的配置项
if(is_file(LAI_DIR.'config.php')){
    
    //加载配置
    \Lai\Sundry\Config::load(require LAI_DIR.'config.php');
    
}

