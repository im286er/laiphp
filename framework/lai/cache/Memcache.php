<?php
namespace lai\cache;
/**
 * Memcache缓存驱动
 */
class Memcache{
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
     * @param integer $expire  有效时间（秒）
     * @return bool
     */
    public function set($name, $value, $expire = null){
        
    }

    /**
     * 删除缓存
     * @param
     * @param
     * @return bool
     */
    public function rm(){
        
    }

    /**
     * 清除缓存
     * @access public
     * @return bool
     */
    public function clear(){
        
    }
}
