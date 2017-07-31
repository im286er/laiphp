<?php
namespace library\bin;

/**
 * 项目处理类
 */
class App{

    /**
     * @var array 错误信息
     */
    private static $error = array();

    /**
     * @var array 标记实例化对象或执行方法(动态控制器)
     */
    private static $result = array();

    /**
     * @var Service 服务注册
     */
    public static $service;
    
    
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

        //初始化服务注册
        self::serviceInit();

        //进行路由相关配置
        $isroute = self::setRoute();

        //判断是否开启路由
        if($isroute){

            //取出解析后的URL
            $moeule  = Url::$urlinfo['moeule'];
            $control = Url::$urlinfo['controller'];
            $action  = Url::$urlinfo['action'];
            
            
            //拼接 控制器 的路径
            $control_file = APP_PATH.$moeule.DS.'controller'.DS.$control.'.php';

            //加载 控制器 的路径
            if(Loadfile::runLoad($control_file)){
                
                //拼接 控制器
                $controlurl = '\\app\\'.$moeule.'\\controller\\'.$control;
                
                //实例化对象或执行方法(动态控制器)
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
            Config::load(require LIBRARY_PATH.'config.php');
            
        }
        
        //加载应用配置项
        if(is_file(APP_PATH.'config.php')){

            //加载应用配置
            Config::load(require APP_PATH.'config.php');
            
        }
        
    }
    
    /**
     * 加载公共函数库
     */
    private static function common(){

        //加载默认公共函数库
        if(is_file(LIBRARY_PATH.'common.php')){
        
            //加载默认公共函数库
            Config::load(require LIBRARY_PATH.'common.php');
        
        }
        
        //加载应用函数库
        if(is_file(APP_PATH.'common.php')){
        
            //加载应用函数库
            Config::load(require APP_PATH.'common.php');
        
        }
        
    }

    public static function serviceInit(){
        $serarray = array();

        //加载默认基本的服务注册配置
        if(is_file(LIBRARY_PATH.'service.php')){
            $tmparr = require LIBRARY_PATH.'service.php';
            if(is_array($tmparr)){
                $serarray = $tmparr;
            }

            //加载应用服务注册配置
            if(is_file(APP_PATH.'service.php')){
                $tmparr = require APP_PATH.'service.php';
                if(is_array($tmparr)){
                    $serarray = array_merge($serarray,$tmparr);
                }
            }

        }

        if(!empty($serarray)){
            self::$service = new Service($serarray);
        }
    }

    /**
     * 进行路由相关配置
     */
    private static function setRoute(){
        //判断是否开启路由
        if(!empty(Config::load('url_route_on'))){

            //默认配置URL设置
            Url::$urlinfo['moeule']     = Config::load('default_module');
            Url::$urlinfo['controller'] = Config::load('default_controller');
            Url::$urlinfo['action']     = Config::load('default_action');
            Url::$urlinfo['url_id']     = Config::load('url_var_id');
            Url::$urlinfo['htmlsuffix'] = Config::load('url_html_suffix');

            //解析URL
            Url::parseUrl();

            return true;
        }

        return false;
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
                self::$error[] = '没有这个类：new '.$class.'()';
                return nill;
            }
            
            //没有方法
            if(empty($method)){
                
                //标记
                self::$result[$name] = true;
                //返回当前对象
                return $obj;
                
            }
            
            //判断是否有这个方法
            if(method_exists($obj, $method)){

                //获取当前类的方法的相关信息
                $RNmethod = new \ReflectionMethod($obj, $method);
                //判断当前方法是否是为公开
                if($RNmethod->isPublic()){

                    //调用(动态方法)
                    call_user_func([$obj,$method]);

                    //标记
                    self::$result[$name] = true;
                    //返回当前对象
                    return $obj;

                }else{
                    self::$error[] = '这个类: new '.$class.'()->'.$method.'() 没有这个方法';
                }
                 

                

                
            }else{
                self::$error[] = '没有这个方法：new '.$class.'()->'.$method.'()';
            }
            
        }
        
        return nill;
        
    }


    /**
     * 获取错误信息
     */
    public static function getError(){
        return self::$error;
    }
}