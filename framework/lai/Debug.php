<?php
namespace lai;
/**
 * 
 */
class Debug{
    /**
     * 错误信息
     */
    public static $debug=array();
    /**
     * 显示信息
     */
    public static function msg($msg,$isbool=true){
        //开启调试模式
        if(APP_DEBUG){
            $isstr = $isbool ? '成功 ' : '失败';
            
            $msgs = '<span>';
            $msgs .= '这个 '.$msg.' 载入'.$isstr.' !';
            $msgs .= '</span>';
            
            self::$debug[] = $msgs;
        }
        
    }
    /**
     * 显示调试信息
     */
    public static function show(){
        //开启调试模式
        if(APP_DEBUG){
            self::$debug[] = '运行时间:'.(microtime(true) - START_TIME).'秒';//运行时间
            echo '<div style="border:solid 2px #dcdcdc;width:600px;padding:10px;">';
            echo '<ul style="list-style:none;padding:0px;margin:0px;">';
            foreach (self::$debug as $v){
                echo '<li>',$v,'</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }
}