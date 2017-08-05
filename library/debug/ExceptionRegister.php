<?php
namespace library\debug;

/**
 * 错误和异常类
 */
class ExceptionRegister
{
    /**
     * @var array HTTP返回码
     */
    private static $httpCode = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

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
        print_r($e);
    }

    /**
     * 错误处理函数
     * @param integer $errno 错误的级别
     * @param string $errstr 错误的信息
     * @param string $errfile 发生错误的文件名
     * @param integer $errline 错误发生的行号
     * @return null|boolean 是否继续执行默认的错误处理
     * @throws \ErrorException 抛出一个错误异常
     */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        print_r(error_reporting());
        throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
    }

    /**
     * 脚本执行结束后调用的错误处理函数
     */
    public function shutdownHandler()
    {
        //获取最后发生的错误
        print_r(error_get_last());
    }

}
