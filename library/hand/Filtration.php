<?php
namespace library\hand;
/**
 * 处理过滤
 */
class Filtration{
    /**
     * 过滤js
     * @param string $str
     * @return string
     */
    public static function filter_js($str){
        //js
        $js_string = array('/<script(.*)<\/script>/isU');
        $js_clear = array('');
        //onjs
        $js_onstring = array('/(<[^>]*)on[a-za-z]+s*=([^>]*>)/isu');
        $js_onclear = array('');
        //frame
        $frame_string = array('/<frame(.*)>/isU', '/<\/fram(.*)>/isU', '/<iframe(.*)>/isU', '/<\/ifram(.*)>/isU');
        $frame_clear = array('','','','');
    
        $str = trim($str);
    
        //过滤JS
        $str = preg_replace($js_string, $js_clear, $str);
    
        //过滤网页特效的on事件
        $str = preg_replace($js_onstring, $js_onclear, $str);
    
        //过滤ifram框架
        $str = preg_replace($frame_string, $frame_clear, $str);
    
        return $str;
    
    }


    /**
     * 截取内容和过滤html、php标签
     * @param string $conte 内容
     * @param int $len 要截取的长度
     * @param string $str 当内容为空时所使用的默认字符串
     * @return string
     */
    public static function jxstrcon($conte,$len=100,$str=''){

        if(empty($conte)){
            return $str;
        }

        $jx = array('&lt;','p&gt;','/p&gt;','br&gt;','br /&gt;','&amp;','&nbsp;',' ','　');
        $jxconte = str_replace($jx,'',strip_tags(htmlspecialchars_decode($conte)));

        if(strlen($jxconte) < $len){
            return $jxconte;
        }else{
            //处理字符串 - 截取字符串
            return Strings::subJsonEncode($jxconte,0,$len);
        }
    }
	
}