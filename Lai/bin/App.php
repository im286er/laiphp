<?php
/**
 * 项目处理类
 */
class App{
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
        
        //初始化配置文件处理
        self::config();
        
        
        //判断是否开启路由
        if(!empty(\library\bin\Config::load('url_route_on'))){
            
            //默认URL设置
            \library\bin\Url::$urlinfo['moeule'] = \library\bin\Config::load('default_module');
            \library\bin\Url::$urlinfo['controller'] = \library\bin\Config::load('default_controller');
            \library\bin\Url::$urlinfo['action'] = \library\bin\Config::load('default_action');
            \library\bin\Url::$urlinfo['url_id'] = \library\bin\Config::load('url_var_id');
            \library\bin\Url::$urlinfo['htmlsuffix'] = \library\bin\Config::load('url_html_suffix');
            
            //解析URL
            \library\bin\Url::parseUrl();
            
            $moeule = \library\bin\Url::$urlinfo['moeule'];
            $control = \library\bin\Url::$urlinfo['controller'];
            $action = \library\bin\Url::$urlinfo['action'];
            
            
            //拼接 控制器 的路径
            $control_file = APP_PATH.DS.$moeule.DS.'controller'.DS.$control.'.php';
            //加载 控制器 的路径
            if(Loadfile::runLoad($control_file)){
            
                $controlurl = '\\app\\'.$moeule.'\\controller\\'.$control;
                $control = new $controlurl();
                $control->$action();
            
            }
            
        }
        
        
        
        
    }
    
    
    
    /**
     * 初始化配置文件处理
     */
    private static function config(){
        
        //加载库的配置项
        if(is_file(LAIPHP_DIR.'config.php')){
        
            //加载配置
            \library\bin\Config::load(require LAIPHP_DIR.'config.php');
        
        }
        
    }
    
    /**
     * 配置自动加载文件
     */
    private static function autoload($classname){
        
        //判断是否有路径
        if(!empty($classname)){
            $classExplode = explode('\\', $classname);
            
            if($classExplode[0] == 'library'){
                
                array_shift($classExplode);//移出第一个
                $str = LAIPHP_DIR.implode(DS,$classExplode).'.php';
                
            }elseif ($classExplode[0] == 'extend'){
                
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
     * 实例化对象或执行方法
     * @param string $class  类名
     * @param string $method 方法名
     * @param array $args    参数
     */
    private static function executeMethod($class,$method='',$args=array()){
        
        $name = empty($args) ? md5($class.$method) : md5($class.$method.serialize($args));
        
        //判断是否已经使用过
        if(empty(self::$result[$name])){
            
            //实例化
            $obj = new $class();
            
            //判断是否有这个方法
            if(!empty($method) && method_exists($obj, $method)){
                
                //判断是否有参数
                if(!empty($args)){
                    
                    call_user_func_array(array(&$obj,$method), array($args));
                    self::$result[$name] = true;
                    
                }else{
                    
                    $obj->$method();
                    self::$result[$name] = true;
                    
                }
                
            }else{
                
                self::$result[$name] = $obj;
                
            }//判断是否有这个方法
            
            
        }
        
        return self::$result[$name];
    }
    
    
    
}