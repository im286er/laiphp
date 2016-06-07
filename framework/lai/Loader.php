<?php
namespace lai;
/**
 * 加载
 */
class Loader{
    /**
     * 保存载入的文件
     */
    protected static $fileArr = array();
    
    /**
     * 自动加载
     */
    public static function autoload($classname){
        
        //分割 \ 为数组
        $classarr = explode('\\', $classname);
        
        //判断是否来自应用的命名空间
        if($classarr[0] == APP_NAMESPACE){
            if($classarr[2] == 'model'){
                //判断是否为模型
                
                //组合加载的路径
                $classfile = APP_PATH.$classarr[1].DS.$classarr[2].DS.$classarr[3].'.php';
            }elseif($classarr[2] == 'controller'){
                
                //判断是否为控制器
                return false;
            }
            
        }else{
            //组合加载的路径
            $classfile = FK_PATH.$classname.'.php';
        }
        
        //加载文件
        self::loadfile($classfile);
    }
    /**
     * 加载文件
     */
    public static function loadfile($classfile=''){
        if(empty($classfile)){
            return self::$fileArr;
        }
        
        $filepate = realpath($classfile);//返回规范化的绝对路径名
        
        $md5file = sha1($filepate);
        
        //判断是否已经加载过了
        if(isset(self::$fileArr[$md5file])){
            return self::$fileArr[$md5file];
        }
        
        //判断是否有这个文件
        if(!is_file($filepate)){
            //错误处理
            Errorset::error('文件'.$classfile.'不存在');
        }
        
        require $filepate;
        self::$fileArr[$md5file] = true;    //进行标记
        
        return true;
        
    }
    /**
     * 注册自动加载机制
     */
    public static function register($autoload = '')
    {
        //注册系统自动加载
        spl_autoload_register($autoload ? $autoload : __NAMESPACE__.'\\Loader::autoload');
    }
}