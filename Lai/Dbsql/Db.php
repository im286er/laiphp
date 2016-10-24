<?php
namespace Lai\Dbsql;
/**
 * 数据库处理类
 */
class Db{
    protected static $_db = null;       //数据库类对象
    protected static $_dberr = false;   //数据库类型是否错误(或是否已实例化)
    
    public static $errarr = [];         //存放错误信息
    
    /**
     * 数据库类型
     */
    protected static function connect(){
        if(self::$_dberr){
            return true;
        }
        
        $driver = \Lai\Sundry\Config::load('type');       //数据库类型
        
        switch ($driver){
            case 'mysql':
                
                //Mysql数据库
                self::$_db = Mysqldb::getdb();
                //数据库类型是否错误
                self::$_dberr = true;
                
                break;
            default:
                
                //数据库类型是否错误
                self::$_dberr = false;
                //存放错误信息
                self::$errarr['type'] = '数据库类型不正确:'.$driver;
                
                break;
        }
        
        return self::$_dberr;
    }
    
    /**
     * 发送执行
     * @access public
     * @param string $sql	sql语句
     * @param array $arr	用于预处理(一\二维的关联数组)
     * @param bool $insid	用于是否要有'最后插入ID'(默认false)
     * @return int	返回执行成功后的影响行数
     */
    public static function query($sql,$arr=array(),$insid=false){
        if(self::connect()){
            
            $data = self::$_db->_query($sql,$arr,$insid);

            if(empty(self::$_db->error)){
            
                return $data;
            }else{
            
                self::geterr();
            }
        }else{
            self::geterr();
        }
    }
    /**
     * 获取一行数据
     * @access public
     * @param string $sql	sql语句
     * @param array $arr	用于预处理(一维的关联数组)
     * @param bool $fetch	用于返回结果的方式 true为关联数组(默认) false为索引数组
     * @return array/bool
     */
    public static function fetch($sql,$arr=array(),$fetch=true){
        if(self::connect()){
            
            $data = self::$_db->_fetch($sql,$arr,$fetch);
            
            if(empty(self::$_db->error)){
                
                return $data;
            }else{
                
                self::geterr();
            }
        }else{
            self::geterr();
        }
    }
    
    /**
     * 获取多行数据
     * @access public
     * @param string $sql	sql语句
     * @param array $arr	用于预处理(一维的关联数组)
     * @param bool $fetch	用于返回结果的方式 true为关联数组(默认) false为索引数组
     * @return array/bool
     */
    public static function fetchAll($sql,$arr=array(),$fetch=true){
        if(self::connect()){
            
            $data = self::$_db->_fetchAll($sql,$arr,$fetch);
            
            if(empty(self::$_db->error)){
            
                return $data;
            }else{
            
                self::geterr();
            }
        }else{
            self::geterr();
        }
    }
    
    /**
     * 最后插入的自增ID
     */
    public static function insert_id(){
        if(self::connect()){
            
            return self::$_db->insert_id();
        }else{
            self::geterr();
        }
    }
    
    /**
     * 返回错误信息
     */
    public static function geterr(){
        if(self::connect()){
            
            echo '<pre>';
            print_r(array_merge(self::$errarr,self::$_db->error));
        }else{
            
            echo '<pre>';
            print_r(self::$errarr);
        }
        exit;
    }
}