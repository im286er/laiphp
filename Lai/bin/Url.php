<?php
namespace library\bin;

/**
 * 路由处理
 */
class Url{
    /**
     * 保存pathinfo信息
     */
    private static $pathinfo = '';
    
    /**
     * 默认url信息
     */
    public static $urlinfo = array(
        'moeule' => 'index',
        'controller' => 'index',
        'action' => 'index',
        'url_var_id'=>'url_id',
        'htmlsuffix' => 'html'
    );
    
    /**
     * 解析URL
     */
    public static function parseUrl(){
        if(self::pathinfo()){
            //分割
            $infoarr = explode('/', self::$pathinfo);
            //取分割后的个数
            $info_count = count($infoarr);
            
            switch ($info_count){
                case 1:
                    self::$urlinfo['controller'] = $infoarr[0];
                    break;
                    
                case 2:
                    self::$urlinfo['controller'] = $infoarr[0];
                    self::$urlinfo['action'] = $infoarr[2];
                    break;
                    
                case 3:
                    self::$urlinfo['moeule'] = $infoarr[0];
                    self::$urlinfo['controller'] = $infoarr[1];
                    self::$urlinfo['action'] = $infoarr[2];
                    break;
                    
                case 4:
                    self::$urlinfo['moeule'] = $infoarr[0];
                    self::$urlinfo['controller'] = $infoarr[1];
                    self::$urlinfo['action'] = $infoarr[2];
                    
                    //url第四个参数
                    $_GET[self::$urlinfo['url_var_id']] = $infoarr[3];
                    
                    break;
                    
                default:
                    
                    self::$urlinfo['moeule'] = $infoarr[0];
                    array_shift($infoarr);
                    self::$urlinfo['controller'] = $infoarr[1];
                    array_shift($infoarr);
                    self::$urlinfo['action'] = $infoarr[2];
                    array_shift($infoarr);
                    
                    
                    break;
            }
            
        }
    }
    
    /**
     * 解析兼容的pathinfo
     */
    private static function pathinfo(){
        //判断是否有兼容的pathinfo
        if(!empty($_GET['s'])){
            
            $path_info = $_GET['s'];
            unset($_GET['s']);
            
        }else{
            
            return false;
        }
        
        //URL伪静态后缀
        $pathinfo_html = '.'.self::$urlinfo['htmlsuffix'];
        
        //去掉伪静态后缀和两边的 / 
        self::$pathinfo = trim(str_ireplace($pathinfo_html, '', $path_info),'/');
        
        return true;
    }
    
}