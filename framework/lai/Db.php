<?php
namespace lai;
use PDO;
use PDOException;
/**
 * 用于Mysql数据库
 */
class Db{
	
	private static $_ins;		//用于单例存放本对象
	private $_db;				//用于存放数据库的联接资源
	private $_operate;			//sql操作
	
	/**
	 * 用构造函数初始化数据库的连接信息,并进行私有化和最终
	 */
	final protected function __construct(){
	    
	    $hostname = Config::load('hostname');   //服务器地址
	    $port = Config::load('hostport');       //端口
	    $database = Config::load('database');   //数据库名
	    $username = Config::load('username');   //用户名
	    $password = Config::load('password');   //密码
	    $charset = Config::load('charset');     //数据库编码默认采用utf8
	    
		$dsn = "mysql:host=$hostname;dbname=$database";
		
		//联接mysql数据库
		try{
            $this->_db = new PDO($dsn,$username,$password);
            //设置错误报告为抛出异常模式
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            //设置通信字符集
            $this->_db->exec('SET NAMES '.$charset);
        }catch(PDOException $e){
            die('connect mysql error：'.$e->getMessage());
        }
	}
	
	/**
	 * 进行单例模式
	 */
	public static function getdb(){
		//判断自身的单例对象实例是否是自身的实例(单例模式)
		if(!(self::$_ins instanceof self)){
			self::$_ins = new self();
		}
		return self::$_ins;
	}
	
	/**
	 * 发送执行
	 * @access public
	 * @param string $sql	sql语句
	 * @param array $arr	用于预处理(一\二维的关联数组)
	 * @param bool $insid	用于是否要有'最后插入ID'(默认false)
	 * @return int	返回执行成功后的影响行数
	 */
	public function query($sql,$arr=array(),$insid=false){
		try{
			//进行预处理的准备查询语句
			$this->_operate = $this->_db->prepare($sql);
			//判断有没有预处理数据
			if(empty($arr)){
				$this->_operate->execute();
			}else{
			    if(isset($arr[0]) && is_array($arr[0])){
			        foreach ($arr as $v){
			            $this->_operate->execute($v);
			        }
			    }else{
			        $this->_operate->execute($arr);
			    }
			}
			
			//最后插入ID
			if($insid){
				return $this->insertid = $this->_db->lastInsertId();
			}
			
			//返回执行成功后的影响行数
			return $this->_operate->rowCount();
			
		}catch(PDOException $e){
			die('query mysql error：'.$e->getMessage());
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
	public function fetch($sql,$arr=array(),$fetch=true){
		try{
			//进行预处理的准备查询语句
			$this->_operate = $this->_db->prepare($sql);
			//判断有没有预处理数据
			if(empty($arr)){
				$this->_operate->execute();
			}else{
				$this->_operate->execute($arr);
			}
			//判断返回数据的方法
			if($fetch){
				return $this->_operate->fetch(PDO::FETCH_ASSOC);
			}else{
				return $this->_operate->fetch(PDO::FETCH_NUM);
			}
			
		}catch(PDOException $e){
			die('fetch mysql error：'.$e->getMessage());
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
	public function fetchAll($sql,$arr=array(),$fetch=true){
		try{
			//进行预处理的准备查询语句
			$this->_operate = $this->_db->prepare($sql);
			//判断有没有预处理数据
			if(empty($arr)){
				$this->_operate->execute();
			}else{
				$this->_operate->execute($arr);
			}
			
			//判断返回数据的方法
			if($fetch){
				return $this->_operate->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return $this->_operate->fetchAll(PDO::FETCH_NUM);
			}
			
		}catch(PDOException $e){
			die('fetchAll mysql error：'.$e->getMessage());
		}
	}
	
	
	/**
	 * 析构方法用于释放数据库连接资源和sql操作
	 */
	public function __destruct(){
		$this->_operate = null;
		$this->_db = null;
	}
}