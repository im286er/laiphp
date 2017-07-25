<?php
/**
 * 框架常量
 */


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


/**
 * 返回当前 Unix 时间戳和微秒数
 */
define('RUN_START_TIME', microtime(true));
/**
 * 返回分配给 PHP 的内存量
 */
define('RUN_START_MEM', memory_get_usage());



/**
 * 当前系统目录分隔符
 */
define('DS', DIRECTORY_SEPARATOR);


/**
 * 框架目录路径
 */
define('LIBRARY_PATH', __DIR__.DS);
/**
 * 根目录路径
 */
define('ROOT_PATH', dirname(LIBRARY_PATH).DS);


//判断是否定义应用目录路径
if(!defined('APP_PATH')){
    /**
     * 项目 目录路径
     */
    define('APP_PATH', ROOT_PATH.'app'.DS);
}


//判断是否定义临时目录路径
if(!defined('TEMP_PATH')){
    /**
     * 临时目录
     */
    define('TEMP_PATH',ROOT_PATH.'runtime'.DS);
}




