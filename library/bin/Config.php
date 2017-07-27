<?php
namespace library\bin;

/**
 * 配置参数类
 */
class Config{
    //配置参数
    private static $config = [];
    
    /**
     * 用于初始化配置项的
     * @param $name string/array 用于配置项名或者是组数
     * @param $value string/array 用于配置项名的值
     * @return string/array 用于返回数据
     */
    public static function load($name = null, $value = null) {
        
        //用于存放配置项的数据
        static $info = array();
        
        //判断配置名是否为空,为空就返回配置项所有数据
        if (empty($name)) {
            return self::$config;
        }
        
        //判断配置名是否为数组,,为数组就合并数据
        if (is_array($name)) {
            self::$config = array_merge(self::$config, $name);
        }
        
        //判断配置名是否为字符串
        if (is_string($name)) {
            //判断配置项名的值是否为null,,为null就是取值,,不为null就是赋值
            if (is_null($value)) {
                return isset(self::$config[$name]) ? self::$config[$name] : false;
            } else {
                self::$config[$name] = $value;
            }
        }
        
    }

    /**
     * 获取某个配置
     */
    public static function get($name){
        if(empty($name) || !is_string($name)){
            return '';
        }

        return isset(self::$config[$name]) ? self::$config[$name] : '';
    }

    /**
     * 设置某个配置
     */
    public static function set($name, $value = null){
        if(empty($name) || !is_string($name) || is_null($value)){
            return false;
        }

        self::$config[$name] = $value;

        return true;
    }
     
    /**
     * 重置配置参数
     */
    public static function reset(){
        self::$config = [];
    }
}