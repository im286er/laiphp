<?php
namespace library\bin;

/**
 * 文件引入类
 */
class Loadfile{
    /**
     * 加载的文件的信息
     */
    public static $fileinfo = array();
    
    /**
     * 存放已加载的文件
     */
    private static $filearr = array();
    
    /**
     * 运行加载文件
     */
    public static function runLoad($file){
        
        //返回规范化的绝对路径名
        $file_real = realpath($file);
        if(empty($file_real)){
            self::$fileinfo[] = $file.' 文件不存在!';
            return false;
        }
        
        //加密为标记的键
        $strmd5 = md5($file_real);
        if(empty(self::$filearr[$strmd5])){
            
            if(is_file($file_real)){
                
                //进行引入文件
                require $file_real;
                
                //标记已引入
                self::$filearr[$strmd5] = true;
                
            }else{
                
                self::$fileinfo[] = $file_real.' 文件不存在!';
                
                return false;
            }
            
        }
        
        return true;
    }
}