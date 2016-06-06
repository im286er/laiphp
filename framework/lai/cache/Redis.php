<?php
namespace lai\cache;
/**
 * Redis缓存驱动
 */
class Redis{
    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @return mixed
     */
    public function get($name){
    
    }
    
    /**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param int $expire  有效时间 0为永久
     * @return boolean
     */
    public function set($name, $value, $expire = null){
    
    }
    
    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name){
    
    }
    
    /**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear(){
    
    }
}
