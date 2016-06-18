<?php
namespace lai;
/**
 * 错误日志-本地化调试输出到文件
 */
class Errlog{
    /**
     * 存放错误信息
     */
    protected static $logarr = array();
    /**
     * 储存日志到文件
     */
    protected static $config = array(
        'file_size'   => 2097152,
        'path'        => LOG_PATH,
    );
    
    /**
     * 记录日志内容
     * @param string $message
     * @param string $type ('sql','notice','error')
     */
    public static function set($message,$type='notice'){
        //是否开启日志
        if(empty(Config::load('log_start'))){
            return false;
        }
        
        //日志处理类型
        if(in_array($type, Config::load('log_type'))){
            $date= date('Y-m-d H:i:s');
            //
            self::$logarr[] = array(
                'type'=>$type,
                'msg'=>$message.'['.$date.']'."\r\n"
            );
            
            if($type == 'error'){
                //日志写入
                self::save();
            }
            
        }
    }
    

    /**
     * 日志写入
     * @access public
     * @param array $log 日志信息
     * @return bool
     */
    public static function save(){
        //是否开启日志
        if(empty(Config::load('log_start'))){
            return false;
        }
        
        //
        if(count(self::$logarr) == 0){
            return false;
        }
        
        //以ISO 8601 格式的日期
        $now = date('Y-m-d H:i:s');
        
        //保存的路径
        $destination = self::$config['path'] . date('Y-m-d') . '.log';
        
        //保存的目录是否存在
        !is_dir(self::$config['path']) && mkdir(self::$config['path'], 0755, true);

        //检测日志文件大小，超过配置大小则备份日志文件重新生成
        if (is_file($destination) && floor(self::$config['file_size']) <= filesize($destination)) {
            rename($destination, dirname($destination) . DS . time() . '-' . basename($destination));
        }

        // 获取基本信息
        if (isset($_SERVER['HTTP_HOST'])) {
            $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $current_uri = "cmd:" . implode(' ', $_SERVER['argv']);
        }
        $runtime    = microtime(true) - START_TIME;
        $reqs       = number_format(1 / number_format($runtime, 8), 2);
        $runtime    = number_format($runtime, 6);
        $time_str   = " [运行时间：{$runtime}s] [吞吐率：{$reqs}req/s]";
        $memory_use = number_format((memory_get_usage() - START_MEM) / 1024, 2);
        $memory_str = " [内存消耗：{$memory_use}kb]";
        $file_load  = " [文件加载：" . count(get_included_files()) . "]";

        self::$logarr[] = array(
            'type' => 'log',
            'msg'  => $current_uri . $time_str . $memory_str . $file_load,
        );

        $info = '';
        foreach (self::$logarr as $line) {
            $info .= '[' . $line['type'] . '] ' . $line['msg'] . "\r\n";
        }

        $server = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '0.0.0.0';
        $remote = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
        $uri    = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        return error_log("[{$now}] {$server} {$remote} {$method} {$uri}\r\n{$info}\r\n", 3, $destination);
    }
    
}
