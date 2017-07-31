<?php
namespace library\bin;

/**
 * 服务注册
 *
 * @method Url router()
 */
class Service{
    /**
     * @var array 服务类实例容器
     */
    private static $instances = [];

    /**
     * @var array 注册的服务
     */
    private static $service = [];

    /**
     * 按需注册服务,服务类可以一样,服务名不能重复
     * @param array $service 服务配置数组
     */
    public function __construct($service)
    {
        self::$service = $service;
    }

    /**
     * 根据服务名返回注册的服务
     * @param string $name 服务名
     * @return Service 返回所实例化的服务类
     */
    public function createService($name){

        if (isset(self::$instances[$name])){
            //已存在就返回
            return self::$instances[$name];
        }else if (isset(self::$service[$name]) && class_exists(self::$service[$name])){
            //进行注册服务，并返回
            self::$instances[$name] = new self::$service[$name]();
            return self::$instances[$name];
        }else{

        }

    }

    /**
     * 魔术方法,返回方法对应的服务类
     * @param string $name 方法名
     * @param array $arguments 方法参数
     * @return Service 返回方法对应的服务类
     */
    public function __call($name, $arguments){
        return $this->createService($name);
    }
}