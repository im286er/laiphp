<?php
namespace pnet;
/**
 * Http 工具
 */
class Http {
    /**
	 * 是否为一个异步的请求，此验证需要jQuery支持
	 * @return boolean
	 */
	public static function isAjax() {
		if (isset ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest')
			return true;
		return false;
	}
	/**
	 * 响应头
	 * @param $type
	 */
	public static function setReponseHead($type = '') {
	    switch ($type) {
	        case 'json' :
	            header ( 'Content-Type:application/json;charset=utf-8' );
	            header ( 'Pragma: no-cache' );
	            header ( 'Cache-Control: no-cache, no-store, max-age=0' );
	            header ( 'Expires: 1L' );
	            break;
	        default :
	            header ( 'Content-type:text/html;charset=utf-8' );
	            break;
	    }
	}
	/**
	 * 客户端ip
	 * @return String
	 */
	public static function clientIp(){
	    $ipaddress = '0.0.0.0';
	    if (array_key_exists ( 'HTTP_CLIENT_IP', $_SERVER )){
	        $ipaddress = $_SERVER ['HTTP_CLIENT_IP'];
	    }else if (array_key_exists ( 'HTTP_X_FORWARDED_FOR', $_SERVER )){
	        $ipaddress = $_SERVER ['HTTP_X_FORWARDED_FOR'];
	    }else if (array_key_exists ( 'HTTP_X_FORWARDED', $_SERVER )){
	        $ipaddress = $_SERVER ['HTTP_X_FORWARDED'];
	    }else if (array_key_exists ( 'HTTP_FORWARDED', $_SERVER )){
	        $ipaddress = $_SERVER ['HTTP_FORWARDED'];
	    }else if (array_key_exists ( 'REMOTE_ADDR', $_SERVER )){
            $ipaddress = $_SERVER ['REMOTE_ADDR'];
            if (! preg_match ( '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $ipaddress )) {
                $ipaddress = '0.0.0.0';
            }
	    }
	    return trim ( $ipaddress );
	}
	/**
	 * 获得真实IP地址
	 * @return string
	 */
	public static function realIp() {
		static $realip = NULL;
		if ($realip !== NULL) return $realip;
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($arr AS $ip) {
					$ip = trim($ip);
					if ($ip != 'unknown') {
						$realip = $ip;
						break;
					}
				}
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['REMOTE_ADDR'])) {
					$realip = $_SERVER['REMOTE_ADDR'];
				} else {
					$realip = '0.0.0.0';
				}
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('HTTP_CLIENT_IP')) {
				$realip = getenv('HTTP_CLIENT_IP');
			} else {
				$realip = getenv('REMOTE_ADDR');
			}
		}
		preg_match('/[\d\.]{7,15}/', $realip, $onlineip);
		$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
		return $realip;
	}
	/**
	 * 下载文件
	 * @param string $file_path 绝对路径
	 */
	public static function downFile($file_path) {
	    //判断文件是否存在
	    $file_path = iconv('utf-8', 'gb2312', $file_path); //对可能出现的中文名称进行转码
	    if (!file_exists($file_path)) {
	        exit('文件不存在！');
	    }
	    $file_name = basename($file_path); //获取文件名称
	    $file_size = filesize($file_path); //获取文件大小
	    $fp = fopen($file_path, 'r'); //以只读的方式打开文件
	    header("Content-type: application/octet-stream");
	    header("Accept-Ranges: bytes");
	    header("Accept-Length: {$file_size}");
	    header("Content-Disposition: attachment;filename={$file_name}");
	    $buffer = 1024;
	    $file_count = 0;
	    //判断文件是否结束
	    while (!feof($fp) && ($file_size-$file_count>0)) {
	        $file_data = fread($fp, $buffer);
	        $file_count += $buffer;
	        echo $file_data;
	    }
	    fclose($fp); //关闭文件
	}
	/**
	 * 解析URL
	 * @param $url 需要解析的URL
	 * @param $field 需要获取的字段
	 */
	public static function parseUrl($url, $field = null) {
	    $urlInfo = parse_url ( $url );
	    $urlInfo ['args'] = array ();
	    if (! empty ( $urlInfo ['query'] )) {
	        $string = $urlInfo ['query'];
	        $arr1 = explode ( '&', $string );
	
	        if (is_array ( $arr1 )) {
	            foreach ( $arr1 as $v ) {
	                $arr2 = explode ( '=', $v );
	                if (is_array ( $arr2 ) && count ( $arr2 ) == 2) {
	                    $urlInfo ['args'] [trim ( $arr2 [0] )] = trim ( $arr2 [1] );
	                }
	            }
	        }
	    }
	    return is_null ( $field ) ? $urlInfo : $urlInfo [$field];
	}
    /**
     * HTTP Protocol defined status codes
     * @param int $num
     */
	public static function sendHttpStatus($code) {
		static $_status = array(
			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',

			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',

			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',  // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',

			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',

			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded'
		);
		if(isset($_status[$code])) {
			header('HTTP/1.1 '.$code.' '.$_status[$code]);
		}
	}
}