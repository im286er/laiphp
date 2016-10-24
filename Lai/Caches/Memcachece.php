<?php
namespace Caches;
/**
 * 缓存Memcache处理类
 */
class Memcachece{
    private $_hostname = '127.0.0.1';    //默认地址
    private $_ports = 11211;             //默认端口
    private $_times = 60;                //默认时间60秒
    
    private $_m = null;                  //存放对象
    
    private static $_ins;		        //单例存放本对象
    
    /**
     * 错误信息
     */
    public $error = [];

    /**
     * 用构造函数初始化的连接信息,并进行私有化和最终
     */
    final protected function __construct(){
        //获取配置文件的信息，返回对象
        $config = \Yaf\Registry::get('config');
        $times = $config->datacache->times;
        $ports = $config->datacache->ports;
        $hostname = $config->datacache->hostname;
        
        //设置默认时间
        if(!is_null($times) || $times != ''){
            $times = intval($times);
            $this->_times = $times < 0 ? 0 : $times;
        }
        
        //设置默认端口
        if(!is_null($ports) || $ports != ''){
            $this->_ports = intval($ports);
        }
        
        //设置默认地址
        if(!empty($hostname)){
            $this->_hostname = $hostname;
        }
        
        //判断是否有这个类
        if(class_exists('Memcache',false)){
            
            try {
                
                //进行实例化
                $this->_m = new \Memcache();
                //向连接池中添加一个memcache服务器(重复)
                $this->_m->addServer($this->_hostname,$this->_ports);
                
            } catch (\Exception $e) {
                
                //写入错误信息
                $this->error[] = 'connect Memcache error：'.$e->getMessage();
                $this->error[] = $this->_hostname.' '.$this->_ports;
                
            }
            
        }else{
            $this->error[] = '没有Memcache类!';
        }
        
    }
    /**
     * 进行单例模式
     */
    public static function getme(){
        //判断自身的单例对象实例是否是自身的实例(单例模式)
        if(!(self::$_ins instanceof self)){
            self::$_ins = new self();
        }
        return self::$_ins;
    }
    /**
     * 防止被克隆,并进行私有化和最终
     */
    final protected function __clone(){
    }
    //拦截器
    public function __set($name,$value){
        return false;
    }
    
    /**
     * 取值
     */
    public function get($name){
        //已经发生错误
        if(!empty($this->error)){
            return false;
        }
        
        if(empty($name)){
            $this->error = 'get：键名不能为空!';
            return false;
        }
        
        return $this->_m->get($name);
    }
    /**
     * 赋值
     */
    public function set($name,$value,$times=-1){
        //已经发生错误
        if(!empty($this->error)){
            return false;
        }
        
        if(empty($name)){
            $this->error = 'set：键名不能为空!';
            return false;
        }
        
        if(is_null($value) || $value == ''){
            $this->error = 'set：值不能为空!';
            return false;
        }
        
        if($times < 0){
            $times = $this->_times;
        }
        
        return $this->_m->set($name,$value,MEMCACHE_COMPRESSED,$times);
    }
    /**
     * 删除
     */
    public function del($name){
        //已经发生错误
        if(!empty($this->error)){
            return false;
        }
        
        if(empty($name)){
            $this->error = 'del：键名不能为空!';
            return false;
        }
        
        return $this->_m->delete($name);
    }
    
    /**
     * 清空所有
     */
    public function flushdata(){
        if(!empty($this->error)){
            return false;
        }
        return $this->_m->flush();
    }
    
}