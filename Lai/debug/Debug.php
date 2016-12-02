<?php
namespace library\debug;

/**
 * 调试类
 */
class Debug{
    
    /**
     * 错误信息
     */
    public static $debug = array(
        'sql'=>array(),
        'log'=>array(),
    );
    
    /**
     * 显示错误
     * @param int $tyid 显示类型:1=打印js,2=返回array
     */
    public static function show($tyid=1){
        
        //存放信息
        $info_all = array();
        
        //返回被 include 和 require 文件名的 array
        $file_info = get_included_files();
        
        //运行时间
        $runtime = number_format(microtime(true) - RUN_START_TIME, 10);
        //吞吐率
        $reqs    = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
        //内存消耗
        $mem     = number_format((memory_get_usage() - RUN_START_MEM) / 1024, 2);
        
        //请求信息
        $uri = $_SERVER['SERVER_PROTOCOL'].' '.$_SERVER['REQUEST_METHOD'].' : '.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        
        
        $info_all['1请求信息'] = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']).' '.$uri;
        $info_all['2运行时间'] = number_format($runtime, 6).'s [ 吞吐率：'.$reqs.'req/s ]';
        $info_all['3内存消耗'] = $mem.'kb';
        $info_all['4文件个数'] = count($file_info);
        $info_all['5文件加载'] = $file_info;
        $info_all['6没有加载'] = \Loadfile::$fileinfo;
        $info_all['7语句sql'] = self::$debug['sql'];
        $info_all['8调试日志'] = self::$debug['log'];
        
        switch ($tyid){
            case 1:
                
                echo '<script type="text/javascript">';
                echo 'console.log(',json_encode($info_all),')';
                echo '</script>';
                
                break;
            case 2:
                
                return $info_all;
            default:
                
                return $info_all;
        }
        
    }
    
}