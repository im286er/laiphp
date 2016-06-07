<?php
namespace lai;

class Errorset{
    /**
     * 注册异常处理
     * @return void
     */
    public static function register(){
        //注册错误处理函数 //trigger_error('错误');
        set_error_handler(array(__CLASS__, 'appError'));
        //注册异常处理函数 //throw new Exception('异常');
        set_exception_handler(array(__CLASS__, 'appException'));
        //当脚本执行完成或意外死掉导致PHP执行即将关闭时,我们的这个函数将会被调用
        register_shutdown_function(array(__CLASS__, 'appShutdown'));
        
    }

    /**
     * 错误处理 Error Handler
     * @param  integer $errno   错误编号
     * @param  integer $errstr  详细错误信息
     * @param  string  $errfile 出错的文件
     * @param  integer $errline 出错行号
     */
    public static function appError($errno,$errstr,$errfile,$errline){
        switch ($errno){
            case E_ERROR:
            case E_USER_ERROR:
                $errmsg = ':['.$errno.']'.$errstr.' FILE: '.$errfile.'['.$errline.']';
                //错误处理
                self::error($errmsg);
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
            case E_USER_WARNING:
                $errmsg = ':['.$errno.']'.$errstr.' FILE: '.$errfile.'['.$errline.']';
                //提示错误
                self::notice($errmsg);
                break;
        }
        
        
        
        
    }
    /**
     * 错误处理
     */
    public static function error($msg=''){
        //产生一条 PHP 的回溯跟踪(错误信息)
        //$backtrace = debug_backtrace();
        Errlog::set($msg,'error');
        exit();
    }
    /**
     * 提示错误
     */
    public static function notice($msg=''){
        Errlog::set($msg,'notice');
        //exit();
    }
    /**
     * 异常处理 Exception Handler
     */
    public static function appException(){
        
    }
    /**
     * 当脚本执行完成或意外死掉导致PHP执行即将关闭时被调用 Shutdown Handler
     */
    public static function appShutdown(){
        
    }
}
