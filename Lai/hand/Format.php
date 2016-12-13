<?php
namespace library\hand;
/**
 * 常用的验证类
 */
class Format{
    /**
     * 验证邮箱是否规范
     * @param string $mail
     * @return bool
     */
    public static function isMail($mail) {
        if(empty($mail)){
            return false;
        }
        $filter  = '/^([\w\.\-])+\@(([\w\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
        if(preg_match($filter,$mail)){
            return true;
        }else {
            return false;
        }
    }
    /**
     * 匹配中文 数字 字母 下划线(UTF8)
     * @param Str
     * @returns {Boolean}
     */
    public static function isStrZh($str){
        if(empty($str)){
            return false;
        }
        $filter = '/[\x{4e00}-\x{9fa5}\w]+$/u';
        if(preg_match($filter,$str)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 匹配数字 字母 下划线 @ .
     * @param Str
     * @returns {Boolean}
     */
    public static function isStrInt($str){
        if(empty($str)){
            return false;
        }
        $filter = '/^[\w\@\.-]+$/';
        if(preg_match($filter,$str)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 验证密码是否规范
     * @param string $pass
     * @return bool
     */
    public static function isPass($pass){
        if(empty($pass)){
            return false;
        }
        $filter = '/^[\w-!#%&=~@\$\^\*\(\)\+]+$/';
        if(preg_match($filter, $pass)){
            return true;
        }else {
            return false;
        }
    }
    /**
     * 手机号码检测
     * @param mobile
     * @return bool
     */
    public static function isMobile($mobile){
        if(empty($mobile)){
            return false;
        }
        $filter = '/^1[3|4|5|8|7][0-9]\d{8}$/';
        if(preg_match($filter, $mobile)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 电话号码检测
     * @param mobile
     * @returns {Boolean}
     */
    public static function isTelephone($telephone){
        if(empty($telephone)){
            return false;
        }
        $filter = '/^0\d{2,3}-?\d{7,8}$/';
        if(preg_match($filter, $telephone)){
            return true;
        }else{
            return false;
        }
    }
}