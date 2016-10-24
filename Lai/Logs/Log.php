<?php
namespace Logs;
/**
 * 日志处理类
 */
class Log{
    
    protected static $_lg = null;       //日志类对象
    protected static $_lgerr = false;   //日志类型是否错误(或是否已实例化)
    
    public static $errarr = [];         //存放错误信息
    
    
    /**
     * 日志类型
     */
    protected static function connect(){
        if(self::$_lgerr){
            return true;
        }
        
        
    }
    
    
    
}