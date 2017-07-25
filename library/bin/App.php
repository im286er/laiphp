<?php
namespace library\bin;

/**
 * 项目处理类
 */
class App{
    /**
     * 标记 实例化对象或执行方法(动态控制器)
     */
    private static $result = array();
    
    
    /**
     * 运行项目()
     */
    public static function run(){
        
        //配置自动加载文件
        spl_autoload_register(array(__CLASS__,'autoload'));
        
        //初始化配置
        self::init();
        
    }
    
    /**
     * 初始化配置
     */
    private static function init(){
        
        //初始化配置文件
        self::config();
        
        //加载公共函数库
        self::common();
        
        
        //判断是否开启路由
        if(!empty(\library\bin\Config::load('url_route_on'))){
            
            //默认配置URL设置
            \library\bin\Url::$urlinfo['moeule'] = \library\bin\Config::load('default_module');
            \library\bin\Url::$urlinfo['controller'] = \library\bin\Config::load('default_controller');
            \library\bin\Url::$urlinfo['action'] = \library\bin\Config::load('default_action');
            \library\bin\Url::$urlinfo['url_id'] = \library\bin\Config::load('url_var_id');
            \library\bin\Url::$urlinfo['htmlsuffix'] = \library\bin\Config::load('url_html_suffix');
            
            //解析URL
            \library\bin\Url::parseUrl();
            
            //取出解析后的URL
            $moeule = \library\bin\Url::$urlinfo['moeule'];
            $control = \library\bin\Url::$urlinfo['controller'];
            $action = \library\bin\Url::$urlinfo['action'];
            
            
            //拼接 控制器 的路径
            $control_file = APP_PATH.$moeule.DS.'controller'.DS.$control.'.php';
            //加载 控制器 的路径
            if(Loadfile::runLoad($control_file)){
                
                //拼接 控制器
                $controlurl = '\\app\\'.$moeule.'\\controller\\'.$control;
                
                //
                self::executeMethod($controlurl,$action);
            
            }
            
        }
        
        
        
        
    }

    /**
     * 加载(初始化)配置文件
     */
    private static function config(){
        
        //加载默认配置项
        if(is_file(LIBRARY_PATH.'config.php')){
            
            //加载默认配置
            \library\bin\Config::load(require LIBRARY_PATH.'config.php');
            
        }
        
        //加载应用配置项
        if(is_file(APP_PATH.'config.php')){

            //加载应用配置
            \library\bin\Config::load(require APP_PATH.'config.php');
            
        }
        
    }
    
    /**
     * 加载公共函数库
     */
    private static function common(){

        //加载默认公共函数库
        if(is_file(LIBRARY_PATH.'common.php')){
        
            //加载默认公共函数库
            \library\bin\Config::load(require LIBRARY_PATH.'common.php');
        
        }
        
        //加载应用函数库
        if(is_file(APP_PATH.'common.php')){
        
            //加载应用函数库
            \library\bin\Config::load(require APP_PATH.'common.php');
        
        }
        
    }
    
    /**
     * 配置自动加载文件
     */
    private static function autoload($classname){
        
        //判断是否有路径
        if(!empty($classname)){
            $classExplode = explode('\\', $classname);
            
            if ($classExplode[0] == 'extend'){
                
                $str = ROOT_PATH.implode(DS,$classExplode).'.php';
                
            }elseif ($classExplode[0] == 'app'){
                
                array_shift($classExplode);//移出第一个
                $str = APP_PATH.implode(DS,$classExplode).'.php';
                
            }
            
            //运行加载文件
            Loadfile::runLoad($str);
            
        }
        
    }
    
    /**
     * 实例化对象或执行方法(动态控制器)
     * @param string $class  类名
     * @param string $method 方法名
     */
    public static function executeMethod($class,$method=''){
        
        $name = md5($class.$method);
        
        //判断是否已经使用过
        if(empty(self::$result[$name])){
            
            //判断是否有这个类
            if(class_exists($class)){
                
                //实例化(动态类)
                $obj = new $class();
                
                
            }else{
                exit('没有这个类：new '.$class.'()');
            }
            
            //没有方法
            if(empty($method)){
                
                //标记
                self::$result[$name] = true;
                return $obj;
                
            }
            
            //判断是否有这个方法
            if(method_exists($obj, $method)){
                 
                //调用(动态方法)
                $obj->$method();
                
                //标记
                self::$result[$name] = true;
                
            }else{
                exit('没有这个方法：new '.$class.'()->'.$method.'()');
            }
            
        }
        
        return true;
        
    }
    
    
    
}