<?php
namespace Caches;
/**
 * 缓存处理类
 */
class Cache{
    protected static $_ce = null;       //缓存类对象
    protected static $_ceerr = false;   //缓存类型是否错误(或是否已实例化)
    
    public static $errarr = [];         //存放错误信息
    
    
    /**
     * 缓存类型
     */
    protected static function connect(){
        if(self::$_ceerr){
            return true;
        }
        
        //获取配置文件的信息，返回对象
        $config = \Yaf\Registry::get('config');
        $type = $config->datacache->type;
        
        switch ($type){
            case 'File':
                
                self::$_ce = Filece::getme();
                //缓存类型是否错误
                self::$_ceerr = true;
                
                break;
            case 'Memcache':
                
                self::$_ce = Memcachece::getme();
                //缓存类型是否错误
                self::$_ceerr = true;
                
                break;
            case 'Memcached':
                
                self::$_ce = Memcachedce::getme();
                //缓存类型是否错误
                self::$_ceerr = true;
                
                break;
            default:
                
                //缓存类型是否错误
                self::$_ceerr = false;
                //存放错误信息
                self::$errarr['type'] = '缓存类型不正确:'.$type;
                
                break;
        }
        
        return self::$_ceerr;
    }
    
    /**
     * 取值
     */
    public static function get($name){
        if(self::connect()){
            return self::$_ce->get($name);
        }else{
            return self::$_ceerr;
        }
    }
    /**
     * 赋值
     */
    public static function set($name,$value='',$times=-1){
        if(self::connect()){
            return self::$_ce->set($name,$value,$times);
        }else{
            return self::$_ceerr;
        }
    }
    /**
     * 删除
     */
    public static function del($name){
        if(self::connect()){
            return self::$_ce->del($name);
        }else{
            return self::$_ceerr;
        }
    }
    
    /**
     * 清空所有
     */
    public static function flushdata(){
        if(self::connect()){
            return self::$_ce->flushdata();
        }else{
            return self::$_ceerr;
        }
    }
    
    /**
     * 返回错误信息
     */
    public static function geterr(){
        if(self::connect()){
            return self::$_ce->error;
        }else{
            return self::$_ceerr;
        }
    }
    
}