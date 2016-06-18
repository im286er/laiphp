/**
 * 存入相关数据
 */
var webpublic = {
		/**
		 * 静态的目录
		 */
		public_directory:"/static/",
		/**
		 * 网站开放路径
		 */
		//web_jspublic:"/index/jspublic/",
		/**
		 * 网站开放路径
		 */
		//web_jsget:"/index/jsget/",
		/**
		 * 随机数
		 */
		str_random:Math.random(),
		/**
		 * 正在加载的中
		 */
		void_html_img:'<div style="text-align: center;padding-top: 50px;"><div style="margin-bottom: 10px;"><img src="/static/images/loading.gif"></div></div>',
		/**
		 * 没有内容时显示
		 */
		void_html_str:'<div style="text-align: center;padding-top: 50px;"><div style="margin-bottom: 10px;"><img src="/static/images/gth.png"></div>咦？暂时没有内容哦~~</div>'
};
/**
 * 存入相关数据(空)
 */
var webvoid = {};
/**
 * 获取字符长度，中文按2个字符计算
 */
function getStrActualLen(sChars) {
    sChars = $.trim(sChars);
    var len = 0;
    for(i=0; i<sChars.length; i++){
        iCode = sChars.charCodeAt(i);
        if((iCode >= 0 && iCode <= 255)||(iCode >= 0xff61 && iCode <= 0xff9f)){
            len += 1;
        }else{
            len += 2;
        }
    }
    return len;
}
/**
 * 匹配中文 数字 字母 下划线 
 * @param Str
 * @returns {Boolean}
 */
function CheckString(Str){
	var re = /^[\w\u4e00-\u9fa5]+$/gi;
	if(re.test(Str)){
		 return true;
    }else{
        return false;
    }
}
/**
 * 手机号码检测
 * @param mobile
 * @returns {Boolean}
 */
function CheckMobile(mobile){
	var re = /^1[3|4|5|8|7][0-9]\d{8}$/;
    if(re.test(mobile)){
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
function CheckTelephone(telephone){
    var re = /^0\d{2,3}-?\d{7,8}$/;
    if(re.test(telephone)){
        return true;
    }else{
        return false;
    }
}
/**
 * 密码检测
 * @param Pass
 * @returns {Boolean}
 */
function checkPass(Pass){
    var re	= /^[\w\!\@\#\$\%\^\&\*\(\)\+\-\=\~]{6,20}$/;
    if(re.test(Pass)){
        return true;
    }else{
        return false;
    }
}
/**
 * 邮箱检测
 * @param Email
 * @returns {Boolean}
 */
function checkEmail(Email){
    var re	= /^([\w\.\-])+\@(([\w\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(re.test(Email)){
        return true;
    }else{
        return false;
    }
}
