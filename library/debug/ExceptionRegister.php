<?php
namespace library\debug;

/**
 * 错误和异常类
 */
class ExceptionRegister
{

    /**
     * 注册错误/异常处理函数
     */
    public function register()
    {
        //注册异常处理函数
        set_exception_handler([$this, 'exceptionHandler']);
        //注册错误处理函数
        set_error_handler([$this, 'errorHandler']);
        //定义PHP程序执行完成后执行的函数(当脚本执行完成或意外死掉导致PHP执行即将关闭时)
        register_shutdown_function([$this, 'shutdownHandler']);
    }

    /**
     * 卸载错误/异常处理函数
     */
    public function unregister()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * 异常处理函数
     * @param \Exception|\Error|\ErrorException $e 未被捕获的异常
     */
    public function exceptionHandler($e)
    {
    }

    /**
     * 错误处理函数
     * @param integer $errno 错误的级别
     * @param string $errstr 错误的信息
     * @param string $errfile 发生错误的文件名
     * @param integer $errline 错误发生的行号
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
    }

    /**
     * 脚本执行结束后调用的错误处理函数
     */
    public function shutdownHandler()
    {
    }

}
