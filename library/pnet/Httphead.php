<?php
namespace library\pnet;

/**
 * Http 工具
 */
class Httphead {
    /**
	 * 是否为一个异步的请求，此验证需要jQuery支持
	 * @return boolean
	 */
	public static function isAjax() {
		if (isset( $_SERVER ['HTTP_X_REQUESTED_WITH'] )){
            if(strtolower( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest'){
                return true;
            }
        }
		return false;
	}

	/**
	 * 获得真实IP地址
	 * @return string
	 */
	public static function realIp() {
		static $realip = NULL;
		if ($realip !== NULL){
		    return $realip;
		}

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
}