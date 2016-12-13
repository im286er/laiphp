<?php
namespace library\caches;
/**
 * 缓存文件操作类
 */
class Filece{
    
    private $_times = 60;         //默认时间60秒
    private $_cedir = '';         //缓存存放的目录 
    
    private static $_ins;		  //单例存放本对象
    
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
        
        //设置默认时间
        if(!is_null($times) || $times != ''){
            $times = intval($times);
            $this->_times = $times < 0 ? 0 : $times;
        }
        
        //缓存目录
        $cedir = APPLICATION_PATH.'/comruntime/cache/';
        
        //判断(创建)缓存目录
        is_dir($cedir) || mkdir($cedir,0777,true);
        
        if(!is_dir($cedir)){
            $this->error[] = '缓存目录不存在:'.$cedir;
        }
        
        $this->_cedir = $cedir;
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
            $this->error[] = 'get：键名不能为空!';
            return false;
        }
        
        $name = sha1($name);
        
        $cedir = $this->_cedir.$name.'.php';
        
        if(!is_file($cedir)){
            $this->error[] = 'get：缓存文件不存在! ('.$cedir.')';
            return false;
        }
        
        
        try {
            
            $value = file_get_contents($cedir);
            
            $data = json_decode($value,true);
            
            if(isset($data['times']) && isset($data['data'])){
                //判断是否是永久数据
                if($data['times'] == 0){
                    return $data['data'];
                }
                
                //取得文件修改时间
                $fme = filemtime($cedir);
                
                //判断修改时间是否大于限定的时间
                if((time() - $fme) > $data['times']){
                    //删除文件缓存
                    unlink($cedir);
                    return false;
                }
                
                return $data['data'];
                
            }else{
                
                //删除文件缓存
                unlink($cedir);
                
                //写入错误信息
                $this->error[] = 'get error：缓存数据掉失';
                return false;
            }
            
            
        } catch (\Exception $e) {
            
            //写入错误信息
            $this->error[] = 'get error：'.$e->getMessage();
            return false;
        }
        
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
            $this->error[] = 'set：键名不能为空!';
            return false;
        }

        if(is_null($value) || $value == ''){
            $this->error[] = 'set：值不能为空!';
            return false;
        }
        
        if($times < 0){
            $times = $this->_times;
        }
        
        $name = sha1($name);
        
        //组合数据
        $data = [
            'times'=>$times,
            'data'=>$value
        ];
        
        $value = json_encode($data);
        
        $cedir = $this->_cedir.$name.'.php';
        
        return file_put_contents($cedir, $value);
        
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
            $this->error[] = 'del：键名不能为空!';
            return false;
        }
        
        $name = sha1($name);
        
        $cedir = $this->_cedir.$name.'.php';
        
        //删除文件缓存
        return unlink($cedir);
        
    }
    
    
    /**
     * 清空所有
     */
    public function flushdata(){
        //已经发生错误
        if(!empty($this->error)){
            return false;
        }
        
    }
    
}