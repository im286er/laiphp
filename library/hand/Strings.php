<?php
namespace library\hand;
/**
 * 处理字符串
 */
class Strings {

    /**
     * 截取字符串
     * @param string $str 字符串
     * @param int $start 开始位置
     * @param int $length 截取长度(字节)中文三个字节
     * @return string
     */
    public static function subJsonEncode($str,$start=0,$length=10){
        $data = substr($str, $start,$length);
        
        if(json_encode($data) == false){
            $data = self::subJsonEncode($str, $start,$length+1);
        }
        
        return $data;
    }
	
	/**
	 * 分割字符串为数组(一维数组)
	 * @param string $str 要分割字符串
	 * @param string $delimiter 分隔字符
	 * @param bool $isint 返回的类型-整型true\字符串false
	 * @return array|bool
	 */
	public static function expstr($str,$delimiter=',',$isint=true){
		if(empty($str) || !is_string($str)){
			return FALSE;
		}
		$str = trim($str,$delimiter);
		if(strpos($str,$delimiter)){
			$tmparr = explode($delimiter, $str);
			$arrtmp = array();
			foreach($tmparr as $v){
				if(!empty($v)){
					if($isint && intval($v) > 0){
						$arrtmp[] = intval($v);
					}else{
						$arrtmp[] = $v;
					}
				}else{
					if(!$isint && $v == '0'){
						$arrtmp[] = $v;
					}
				}
			}
			return $arrtmp;
		}else{
			if($isint){
				if(intval($str) <= 0){
					return FALSE;
				}
				return array(intval($str));
			}else{
				return array($str);
			}
		}
	}
	
	/**
	 * 分割字符串并判断是否包含在内
	 * @param string $str 要分割字符串
	 * @param string|int $isstr 找查是否包含的字符串或整数
	 * @param string $delimiter 分隔字符
	 * @param bool $isint 返回的类型-整型true\字符串false
	 * @return bool
	 */
    public static function isexpstr($str,$isstr,$delimiter=',',$isint=true){
	    if(empty($str)){
	        return false;
	    }
	    //分割字符串为数组(一维数组)
	    $tmparr = self::expstr($str,$delimiter,$isint);
	    if($tmparr){
	        return in_array($isstr,$tmparr);
	    }else{
	        return false;
	    }
	
	}



}