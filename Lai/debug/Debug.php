<?php
namespace library\debug;

/**
 * 调试类
 */
class Debug{
    
    /**
     * 错误信息
     */
    public static $debug = array();
    
    /**
     * 显示错误
     */
    public static function show(){
        
        //加载的文件的信息
        self::$debug = \Loadfile::$fileinfo;
        
        //运行时间
        self::$debug[] = microtime(true) - RUN_START_TIME;
        
        echo '<div style="boder:solid 2px $dcdcdc;">';
        
        foreach (self::$debug as $av){
            echo $av,'<br />';
        }
        
        echo '</div>';
    }
    
}