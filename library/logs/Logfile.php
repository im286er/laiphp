<?php
namespace library\Logs;

/**
 * 写日志
 */
class Logfile {
    protected $logconif = [
        'logpath'=>'',
        'logname'=>'weblog.log',
    ];

    // 写日志的
    public function write($cont) {
        $cont .= "\r\n";
        
        // 判断是否备份
        $log = $this->isBak(); // 计算出日志文件的地址
        
        $fh = fopen($log,'ab');
        fwrite($fh,$cont);
        fclose($fh); 
    }

    // 备份日志
    public function bak() {
        // 就是把原来的日志文件,改个名,存储起来
        // 改成 年-月-日.bak这种形式

        //文件完整的路径
        $log = $this->logconif['logpath'].$this->logconif['logname'];
        //备份文件完整的路径
        $bak = $this->logconif['logpath'].date('Y-m-d-') . mt_rand(10000,99999) . '.bak';
        
        return rename($log,$bak);
    }

    // 读取并判断日志的大小
    public function isBak() {
        //文件完整的路径
        $log = $this->logconif['logpath'].$this->logconif['logname'];
        
        if(!file_exists($log)) { //如果文件不存在,则创建该文件
            touch($log);    // touch在linux也有此命令,是快速的建立一个文件
            return $log;
        }

        // 要是存在,则判断大小
        // 清除缓存
        clearstatcache(true,$log);
        $size = filesize($log);
        if($size <= 1024 * 1024) { //大于1M
            return $log;
        }
        
        // 走到这一行,说明>1M
        if(!$this->Bak()) {
            return $log;
        } else {
            touch($log);
            return $log;
        }
    }
}