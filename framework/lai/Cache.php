<?php
namespace lai;
/**
 * 缓存
 */
class Cache{
    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存标识
     * @return mixed
     */
    public static function get($name){
        
    }

    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存标识
     * @param mixed $value  存储数据
     * @param int|null $expire  有效时间 0为永久
     * @return boolean
     */
    public static function set($name, $value, $expire = null){
        
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存标识
     * @return boolean
     */
    public static function rm($name){
        
    }

    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public static function clear(){
        
    }

}
