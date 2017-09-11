<?php
namespace library\db;

use PDO;
use PDOException;

use library\bin\Config;

/**
 * 数据库操作处理
 */
class Sqldb{
    
    // 用于单例存放本对象
    private static $_ins;
    // 用于存放数据库的联接资源
    private $_db = null;
    // sql操作
    private $_operate = null;

    /**
     * 错误信息
     */
    private static $error = array();

    /**
     * 最后插入ID
     */
    public $insertid = 0;

    /**
     * 用构造函数初始化数据库的连接信息,并进行私有化和最终
     */
    final protected function __construct(){
        
        // 获取数据库的配置
        $default_db = Config::get('default_db');
        if(empty($default_db)){
            self::$error[] = '请配置数据库相关信息!';
            return;
        }

        $type     = empty($default_db['type']) ? '' : $default_db['type'];          //数据库类型
        $hostname = empty($default_db['hostname']) ? '' : $default_db['hostname'];  //服务器地址
        $database = empty($default_db['database']) ? '' : $default_db['database'];  //数据库名
        $hostport = empty($default_db['hostport']) ? '' : $default_db['hostport'];  //数据库连接端口
        $charset  = empty($default_db['charset']) ? '' : $default_db['charset'];    //数据库编码
        $username = empty($default_db['username']) ? '' : $default_db['username'];  //数据库用户名
        $password = empty($default_db['password']) ? '' : $default_db['password'];  //数据库密码

        
        // 用于连接mysql数据库
        try {

            switch ($type){
                case 'mysql':

				    //mysql:host=127.0.0.1;dbname=test;port=3306;charset=utf8
                    // 组合连接 数据库类型 数据库地址 数据库名称 数据库端口 数据库通信字符集
                    $hsdb = "mysql:host={$hostname};dbname={$database};port={$hostport};charset={$charset}";

                    //进行实例化
                    $this->_db = new PDO($hsdb, $username, $password);
                    break;

                case 'sqlite':

				    // 组合连接 数据库类型 数据库地址
                    $hsdb = 'sqlite:'.$hostname;
                    // 用于连接sqlite数据库
                    $this->_db = new PDO(hsdb);

                    self::$error[] = 'connect sqlite:'.$hostname;
                    break;

                default:
                    self::$error[] = '请配置数据库正确的类型：mysql、sqlite';
                    break;
            }

            if(!is_null($this->_db)){
                // 设置错误报告为抛出异常模式
                $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

        } catch (PDOException $e) {
            
            // 写入错误信息
            self::$error[] = 'connect sql error：' . $e->getMessage();
            self::$error[] = $hsdb;
        }
    }

    /**
     * 进行单例模式
     */
    public static function getDb(){
        // 判断自身的单例对象实例是否是自身的实例(单例模式)
        if (! (self::$_ins instanceof self)) {
            self::$_ins = new self();
        }
        return self::$_ins;
    }

    /**
     * 防止被克隆,并进行私有化和最终
     */
    final protected function __clone(){}
    // 拦截器
    public function __set($name, $value){
        return false;
    }

    /**
     * 发送执行
     *
     * @access public
     * @param string $sql sql语句
     * @param array $arr  用于预处理(一\二维的关联数组)
     * @param bool $insid 用于是否要有'最后插入ID'(默认false)
     * @return int        返回执行成功后的影响行数
     */
    public function query($sql, $arr = array(), $insid = false){
        try {
            // 进行预处理的准备查询语句
            $this->_operate = $this->_db->prepare($sql);
            // 判断有没有预处理数据
            if (empty($arr)) {
                $this->_operate->execute();
            } else {
                if (isset($arr[0]) && is_array($arr[0])) {
                    foreach ($arr as $v) {
                        $this->_operate->execute($v);
                    }
                } else {
                    $this->_operate->execute($arr);
                }
            }
            
            // 最后插入ID
            if ($insid) {
                return $this->insertid = $this->_db->lastInsertId();
            }
            
            // 返回执行成功后的影响行数
            return $this->_operate->rowCount();
        } catch (PDOException $e) {
            
            // 写入错误
            self::$error[] = 'exec sql error：' . $e->getMessage();
            self::$error[] = $sql;
        }
    }

    /**
     * 获取一行数据
     *
     * @access public
     * @param string $sql sql语句
     * @param array $arr  用于预处理(一维的关联数组)
     * @param bool $fetch 用于返回结果的方式 true为关联数组(默认) false为索引数组
     * @return array/bool
     */
    public function fetch($sql, $arr = array(), $fetch = true){
        try {
            // 进行预处理的准备查询语句
            $this->_operate = $this->_db->prepare($sql);
            // 判断有没有预处理数据
            if (empty($arr)) {
                $this->_operate->execute();
            } else {
                $this->_operate->execute($arr);
            }
            // 判断返回数据的方法
            if ($fetch) {
                return $this->_operate->fetch(PDO::FETCH_ASSOC);
            } else {
                return $this->_operate->fetch(PDO::FETCH_NUM);
            }
        } catch (PDOException $e) {
            
            // 写入错误
            self::$error[] = 'fetch sql error：' . $e->getMessage();
            self::$error[] = $sql;
        }
    }

    /**
     * 获取多行数据
     *
     * @access public
     * @param string $sql sql语句
     * @param array $arr  用于预处理(一维的关联数组)
     * @param bool $fetch 用于返回结果的方式 true为关联数组(默认) false为索引数组
     * @return array/bool
     */
    public function fetchAll($sql, $arr = array(), $fetch = true){
        try {
            // 进行预处理的准备查询语句
            $this->_operate = $this->_db->prepare($sql);
            // 判断有没有预处理数据
            if (empty($arr)) {
                $this->_operate->execute();
            } else {
                $this->_operate->execute($arr);
            }
            
            // 判断返回数据的方法
            if ($fetch) {
                return $this->_operate->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $this->_operate->fetchAll(PDO::FETCH_NUM);
            }
        } catch (PDOException $e) {
            
            // 写入错误
            self::$error[] = 'fetchAll sql error：' . $e->getMessage();
            // 记录sql语句
            self::$error[] = $sql;
        }
    }

    /**
     * 最后插入的自增ID
     */
    public function insertId(){
        return $this->_db->lastInsertId();
    }

    /**
     * 获取错误信息
     */
    public static function getError(){
        return self::$error;
    }

    /**
     * 析构方法用于释放数据库连接资源和sql操作
     */
    public function __destruct(){
        $this->_operate = null;
        $this->_db = null;
        self::$error = array();
    }
}
