<?php
namespace lai;

class Errorset{
    /**
     * 注册异常处理
     * @return void
     */
    public static function register(){
        
        //trigger_error('错误',E_USER_ERROR);//用于手动抛出错误
        
        //注册错误处理函数
        set_error_handler(array(__CLASS__, 'appError'));
        //注册异常处理函数
        //set_exception_handler(array(__CLASS__, 'appException'));
        //
        //register_shutdown_function(array(__CLASS__, 'appShutdown'));
        
    }

    /**
     * Error Handler
     * @param  integer $errno   错误编号
     * @param  integer $errstr  详细错误信息
     * @param  string  $errfile 出错的文件
     * @param  integer $errline 出错行号
     */
    public static function appError($errno,$errstr,$errfile,$errline){
        switch ($errno){
            //错误
            case E_ERROR:
            case E_USER_ERROR:
                $errmsg = 'ERROR:['.$errno.'] <strong>'.$errstr.'</strong> ';
                $errmsg .= 'File:'.$errfile.'['.$errline.']';
                
                //错误处理
                self::error($errmsg);
                break;
            //提示错误
            case E_NOTICE:
            case E_USER_NOTICE:
            case E_USER_WARNING:
            default:
                $errmsg = 'NOTICE:['.$errno.'] <strong>'.$errstr.'</strong> ';
                $errmsg .= 'File:'.$errfile.'['.$errline.']';
                
                //提示错误
                self::notice($errmsg);
                break;
        }
        echo $errmsg; 
    }
    /**
     * 错误处理
     */
    public static function error($msg){
        //开启调试模式
        if(APP_DEBUG){
            $err = array();
            if(is_array($msg)){
                $err = $msg;
            }else{
                $backtrace = debug_backtrace();//产生一条 PHP 的回溯跟踪(错误信息)
                $err['message'] = $msg;
                $info = '';
                foreach ($backtrace as $v){
                    $file = isset($v['file'])?$v['file']:'';
                    $line = isset($v['line'])?'['.$v['line'].']':'';
                    $class = isset($v['class'])?$v['class']:'';
                    $type = isset($v['type'])?$v['type']:'';
                    $function = isset($v['function'])?$v['function'].'()':'';
                    $info .= $file.$line.$class.$type.$function.'<br />';
                }
                $err['info'] = $info;
            }
            
        }else{
            $err['message'] = Config::load('error_message');
        }
        include Config::load('exception_tmpl');
        exit();
    }
    /**
     * 提示错误
     */
    public static function notice($msg){
        //开启调试模式
        if(APP_DEBUG){
            $err = array();
            if(is_array($msg)){
                $err = $msg;
            }else{
                $backtrace = debug_backtrace();//产生一条 PHP 的回溯跟踪(错误信息)
                $err['message'] = $msg;
                $info = '';
                foreach ($backtrace as $v){
                    $file = isset($v['file'])?$v['file']:'';
                    $line = isset($v['line'])?'['.$v['line'].']':'';
                    $class = isset($v['class'])?$v['class']:'';
                    $type = isset($v['type'])?$v['type']:'';
                    $function = isset($v['function'])?$v['function'].'()':'';
                    $info .= $file.$line.$class.$type.$function.'<br />';
                }
                $err['info'] = $info;
            }
            
        }else{
            $err['message'] = Config::load('error_message');
        }
        include Config::load('exception_tmpl');
        exit();
    }
    /**
     * Exception Handler
     */
    public static function appException(){
        
    }
}
