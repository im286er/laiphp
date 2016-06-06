<?php
define('XHE_VERSION', '0.1');                                                               //版本号 
define('START_TIME', microtime(true));                                                      //运行开始时间
//define('MEMORY',memory_get_usage());                                                        //内存占用
//define('MEMORY_PEAK',memory_get_peak_usage());                                              //内存峰值

defined('DS') or define('DS', DIRECTORY_SEPARATOR);                                         //目录分隔符，是定义php的内置常量
defined('APP_DEBUG') or define('APP_DEBUG',FALSE);                                          //是否开启调试模式

defined('FK_PATH') or define('FK_PATH', dirname(__FILE__) . DS);                            //框加主目录
define('LAI_PATH', FK_PATH . 'lai' . DS);                                                   //框加核心目录

defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']). DS);        //定义应用目录
defined('APP_NAMESPACE') or define('APP_NAMESPACE', 'app');                                 //应用根命名空间


defined('ROOT_PATH') or define('ROOT_PATH', dirname(APP_PATH) . DS);                        //根目录


defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'runtime'. DS);                //运行时目录，存放应用的相关日志、缓存
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'log' . DS);                       //运行时目录，存放应用的日志
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);                 //运行时目录，存放应用的缓存
defined('TEMP_PATH') or define('TEMP_PATH', RUNTIME_PATH . 'temp' . DS);                    //运行时目录，存放应用的临时



