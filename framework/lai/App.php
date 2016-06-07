<?php
namespace lai;
/**
 * 应用管理
 */
class App{
    protected static $result = array();   //实例化对象或执行方法的存入
    protected static $_control = array(); //实例化对象或执行方法的存入
    
    protected static $module = '';  //模块
    protected static $control = ''; //控制器
    protected static $action = '';  //动作
    protected static $controllerdir = 'controller';//控制器目录名
    
    
    /**
     * 运行
     */
    public static function run(){
                
        //初始化配置
        self::init();
       
        //日志写入
        Errlog::save();
    }
    /**
     * 初始化配置
     */
    protected static function init(){
        //文件配置
        self::config();
        
        if(function_exists('date_default_timezone_set')){
            //设置时区
            date_default_timezone_set(Config::load('default_timezone'));
        }
        
        //解析URL
        Route::parseUrl();
        
        $module_var = Config::load('default_module_var');           //默认模块变量
        $controller_var = Config::load('default_controller_var');   //默认控制器变量
        $action_var = Config::load('default_action_var');           //默认操作变量
        
        self::$module = (isset($_GET[$module_var]) && !empty($_GET[$module_var])) ? $_GET[$module_var] : Route::$module_var;                            //获得模块
        self::$control = (isset($_GET[$controller_var]) && !empty($_GET[$controller_var])) ? ucfirst($_GET[$controller_var]) : Route::$controller_var;  //获得控制器
        self::$action = (isset($_GET[$action_var]) && !empty($_GET[$action_var])) ? $_GET[$action_var] : Route::$action_var;                            //获得动作
        
        $actions = self::$action;
        
        
        //实例化控制器
        $controls = self::controls();
        if(!$controls){
            //错误处理
            Errorset::error('没有这个类'.self::$module.'/'.self::$control.'方法');
        }
        //判断是否有这个方法
        if(!method_exists($controls, $actions)){
            //错误处理
            Errorset::error('非法调用'.self::$module.'/'.self::$control.'/'.$actions.'方法');
        }
        
        $controls->$actions();  
        
    }
    /**
     * 初始化文件配置
     */
    protected static function config(){
        $msg = '';
        
        //加载框架的配置
        $fkconfig =  FK_PATH.'config.php';
        if(is_file($fkconfig)){
            $fkconfigarr = require $fkconfig;
            if(is_array($fkconfigarr)){
                Config::load($fkconfigarr);
            }
        }
        
        //加载应用的配置
        $appcnfig = APP_PATH.'config.php';
        if(is_file($appcnfig)){
            $appcnfigarr = require $appcnfig;
            if(is_array($appcnfigarr)){
                Config::load($appcnfigarr);
            }
        }
        
        //加载应用数据库的配置
        $appdatabase = APP_PATH.'database.php';
        if(is_file($appdatabase)){
            $appdatabasearr = require $appdatabase;
            if(is_array($appdatabasearr)){
                Config::load($appdatabasearr);
            }
        }
        
    }
    /**
     * 实例化控制器
     */
    public static function controls($control = ''){
        //判断是否传入模块和控制器
        if(strpos($control,'.')){
            $arr = explode('.', $control);
            $module = $arr[0];
            $control = $arr[1];
        }else{
            $module = self::$module;
            if(empty($control)){
                $control = self::$control;
            }
        }
        
        $md5name = sha1($module.$control);
        
        if(isset(self::$_control[$md5name])){
            return self::$_control[$md5name];
        }
        //应用组合的控制器文件
        $control_file = APP_PATH.$module.DS.self::$controllerdir.DS.$control.'.php';
        
        //手动加载文件 应用控制器文件
        Loader::loadfile($control_file);
        
        //组合应用的控制器路径
        $control = '\\'.APP_NAMESPACE.'\\'.self::$module.'\\'.self::$controllerdir.'\\'.self::$control;
        
        //判断是否有这个类
        if(class_exists($control)){
            self::$_control[$md5name] = new $control();
            
            return self::$_control[$md5name];
        }else{
            return false;
        }
        
        
    }
    /**
     * 实例化对象或执行方法
     * @param string $classname 类名
     * @param string $methodname 方法名
     * @param array $atgs 参数
     */
    public static function newobj($classname,$methodname=NULL,$atgs=array()){
        
        $md5name = empty($atgs) ? $classname.$methodname : $classname.$methodname.sha1($atgs);
        //判断是否已经执行过的
        if(!isset(self::$result[$md5name])){
            
            //判断是否有这个类
            if(class_exists($classname)){
                $obj = new $classname();
            }else{
                
                return false;
            }
            
            //判断是否要方法
            if(!is_null($methodname)){
                //判断是否有这个方法
                if(method_exists($obj, $methodname)){
                    if(empty($atgs)){
                        self::$result[$md5name] = $obj->$methodname();
                    }else{
                        //调用回调函数，并把一个数组参数作为回调函数的参数
                        self::$result[$md5name] = call_user_func_array(array(&$obj,$methodname), $atgs);
                    }
                }else{
                    
                    return false;
                }
                
            }else{
                self::$result[$md5name] = $obj;
            }
        }
        return self::$result[$md5name];
    }
}