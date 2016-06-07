<?php
namespace lai;
/**
 * 路由功能
 */
final class Route{
    public static $requesturi = '';             //存入过滤后url
    public static $module_var = '';             //默认模块变量
    public static $controller_var = '';         //默认控制器变量
    public static $action_var = '';             //默认操作变量
    /**
     * 解析URL
     */
    public static function parseUrl() {
        self::$module_var = Config::load('default_module');             //默认模块变量
        self::$controller_var = Config::load('default_controller');     //默认控制器变量
        self::$action_var = Config::load('default_action');             //默认操作变量
        
        //解析REQUEST_URI
        if(self::requestUrl()){
            $requesturi = self::$requesturi;
            
            //判断是否有 /
            if(strpos($requesturi,'/')){
                //
                $urlarr = explode('/', $requesturi);
                
                if(count($urlarr) > 3){
                    self::$module_var = $urlarr[0];
                    array_shift($urlarr);
                    self::$controller_var = $urlarr[1];
                    array_shift($urlarr);
                    self::$action_var = $urlarr[2];
                    array_shift($urlarr);
                    
                    $count = count($urlarr);
                    $tmparr = array();
                    for($i=0;$i<$count;$i+=2){
                        if(isset($urlarr[$i+1])){
                            $tmparr[$urlarr[$i]] = $urlarr[$i+1];
                        }else{
                            $tmparr[$urlarr[$i]] = '';
                        }
                    }
                    
                    $_GET = array_merge($_GET,$tmparr);
                    
                }else{
                    if(count($urlarr) == 3){
                        self::$module_var = $urlarr[0];
                        self::$controller_var = $urlarr[1];
                        self::$action_var = $urlarr[2];
                    }else{
                        self::$module_var = $urlarr[0];
                        self::$controller_var = $urlarr[1];
                    }
                }
            }else{
                self::$module_var = $requesturi;
            }
        }else{
            return false;
        }
    }
    /**
     * 解析REQUEST_URI
     */
    public static function requestUrl() {
        //URL伪静态后缀并去除两边的点
        $url_html_suffix = '.'.trim(Config::load('url_html_suffix'),'.');
        
        $requesturi = $_SERVER['REQUEST_URI'];
        
        //去除两边的 /
        $requesturi = trim($requesturi,'/');
        
        if(empty($requesturi)){
            return false;
        }
        
        //去除URL伪静态
        $requesturi = str_ireplace($url_html_suffix, '', $requesturi);
        
        //有字符串并第一个是 ?
        if($requesturi[0] == '?'){
            return false;
        }
        
        //如果 ? 就取 ? 前的字符串
        if(strpos($requesturi,'?')){
            $requesturi = strstr($requesturi, '?',true);
        }
        
        //去除类似index.php
        if(strpos($requesturi,'.php/')){
            $requesturi = trim(strstr($requesturi, '.php/'),'.php/');
        }
        
        if(empty($requesturi)){
            return false;
        }else{
            self::$requesturi = $requesturi;
            return true;
        }
    }
    /**
     * 返回mvc
     */
    public static function urlvar(){
        return array(
            'module_var'=>self::$module_var,
            'controller_var'=>self::$controller_var,
            'action_var'=>self::$action_var
        );
    }
}