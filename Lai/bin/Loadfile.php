<?php
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
        
        $strmd5 = md5($file);
        if(empty(self::$filearr[$strmd5])){
            
            if(is_file($file)){
                //进行引入文件
                require $file;
                //标记已引入
                self::$filearr[$strmd5] = true;
                //写入信息
                self::$fileinfo[] = $file;
            }else{
                self::$fileinfo[] = $file.' 文件不存在!';
            }
            
        }
        
    }
}