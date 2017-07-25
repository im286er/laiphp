<?php
namespace library\db;

use PDO;
use PDOException;

/**
 * 数据库操作处理
 */
class Sqldb{
    
    // 用于单例存放本对象
    private static $_ins;
    // 用于存放数据库的联接资源
    private $_db;
    // sql操作
    private $_operate;

    /**
     * 错误信息
     */
    public $error = array();

    /**
     * 最后插入ID
     */
    public $insertid;

    /**
     * 用构造函数初始化数据库的连接信息,并进行私有化和最终
     */
    final protected function __construct(){
        
        // 获取数据库的配置
        $default_db = \library\bin\Config::load('default_db');
        
        // 组合连接 数据库类型 数据库地址 数据库名称 数据库端口 数据库通信字符集
        $hsdb = "{$default_db['type']}:host={$default_db['hostname']};dbname={$default_db['database']};port={$default_db['hostport']};charset={$default_db['charset']}";
        
        // 用于连接mysql数据库
        try {
            $this->_db = new PDO($hsdb, $default_db['username'], $default_db['password']);
            
            // 设置错误报告为抛出异常模式
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            
            // 写入错误信息
            $this->error[] = 'connect sql error：' . $e->getMessage();
            $this->error[] = $hsdb;
        }
    }

    /**
     * 进行单例模式
     */
    public static function getdb(){
        // 判断自身的单例对象实例是否是自身的实例(单例模式)
        if (! (self::$_ins instanceof self)) {
            self::$_ins = new self();
        }
        return self::$_ins;
    }

    /**
     * 防止被克隆,并进行私有化和最终
     */
    final protected function __clone(){
        
    }
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
    public function query_sql($sql, $arr = array(), $insid = false){
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
            $this->error[] = 'query sql error：' . $e->getMessage();
            $this->error[] = $sql;
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
    public function fetch_One($sql, $arr = array(), $fetch = true){
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
            $this->error[] = 'fetch sql error：' . $e->getMessage();
            $this->error[] = $sql;
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
    public function fetch_All($sql, $arr = array(), $fetch = true){
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
            $this->error[] = 'fetchAll sql error：' . $e->getMessage();
            // 记录sql语句
            $this->error[] = $sql;
        }
    }

    /**
     * 最后插入的自增ID
     */
    public function insert_id(){
        return $this->_db->lastInsertId();
    }

    /**
     * 析构方法用于释放数据库连接资源和sql操作
     */
    public function __destruct(){
        $this->_operate = null;
        $this->_db = null;
        $this->error = array();
    }
}