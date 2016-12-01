<?php
/**
 * 项目处理类
 */
class App{
    public static $moeule;//模块
    public static $control;//控制器
    public static $aciton;//动作方法
    
    
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
                
            }
            
            //运行加载文件
            Loadfile::runLoad($str);
            
        }
        
    }
}