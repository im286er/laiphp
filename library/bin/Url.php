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
        'moeule'     => 'index',
        'controller' => 'index',
        'action'     => 'index',
        'url_var_id' => 'url_id',
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
                    
                    //只有控制器
                    self::$urlinfo['controller'] = $infoarr[0];
                    break;
                    
                case 2:
                    
                    //只有控制器和方法
                    self::$urlinfo['controller'] = $infoarr[0];
                    self::$urlinfo['action'] = $infoarr[1];
                    break;
                    
                case 3:
                    
                    //判断第三个参数是否有下 _ 线,有赋给url第四个参数
                    $tmpstr = trim($infoarr[2],'_');
                    if(strpos($tmpstr,'_')){
                        
                        self::$urlinfo['controller'] = $infoarr[0];
                        self::$urlinfo['action'] = $infoarr[1];

                        //url第四个参数
                        $_GET[self::$urlinfo['url_var_id']] = $infoarr[2];
                        
                    }else{
                        
                        //只有模块、控制器、方法
                        self::$urlinfo['moeule'] = $infoarr[0];
                        self::$urlinfo['controller'] = $infoarr[1];
                        self::$urlinfo['action'] = $infoarr[2];
                        
                    }
                    
                    break;
                    
                case 4:
                    
                    //只有模块、控制器、方法、第四个参数
                    self::$urlinfo['moeule'] = $infoarr[0];
                    self::$urlinfo['controller'] = $infoarr[1];
                    self::$urlinfo['action'] = $infoarr[2];
                    
                    //url第四个参数
                    $_GET[self::$urlinfo['url_var_id']] = $infoarr[3];
                    
                    break;
                    
                default:
                    
                    //先取出 模块、控制器、方法 并移出
                    self::$urlinfo['moeule'] = $infoarr[0];
                    array_shift($infoarr);
                    self::$urlinfo['controller'] = $infoarr[0];
                    array_shift($infoarr);
                    self::$urlinfo['action'] = $infoarr[0];
                    array_shift($infoarr);
                    
                    //取剩余个数
                    $info_count = count($infoarr);
                    if($info_count%2 != 0){
                        //将数组最后一个单元弹出
                        $_GET[self::$urlinfo['url_var_id']] = array_pop($infoarr);
                        
                        $info_count -= 1;
                    }
                    
                    //每两个取出
                    for ($i=0;$i<$info_count;$i+=2){
                        $_GET[$infoarr[$i]] = $infoarr[$i+1];
                    }
                    
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
