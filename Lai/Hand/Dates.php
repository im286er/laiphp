<?php
namespace library\hand;
/**
 * 处理时间
 */
class Dates{
    /**
     * 将时间转换成字符串(获取最近时间)
     * @static
     * @access public
     * @param int $time 时间数
     * @return string
     */
    public static function getTime($time) {
        $rtime = date("m-d H:i",$time);
        $rtime2 = date("Y-m-d H:i",$time);
        $htime = date("H:i",$time);
        $time = time() - $time;
        if ($time < 60) {
            $str = '刚刚';
        }elseif ($time < 60 * 60) {
            $min = floor($time/60);
            $str = $min.' 分钟前';
        }elseif ($time < 60 * 60 * 24) {
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }elseif ($time < 60 * 60 * 24 * 3){
            $d = floor($time/(60*60*24));
            if($d==1){
                $str = '昨天 '.$htime;
            }else{
                $str = '前天 '.$htime;
            }
        }elseif ($time < 60 * 60 * 24 * 7){
            $d = floor($time/(60*60*24));
            $str = $d.' 天前 '.$htime;
        }elseif ($time < 60 * 60 * 24 * 30){
            $str = $rtime;
        }else {
            $str = $rtime2;
        }
        return $str;
    }
    /**
     * 将分钟数转换成字符串
     * @param int $minute 分钟数
     * @return string
     */
    public static function jsminute($minute){
        //转换时间
        $fldtime = intval($minute);
        if($fldtime < 0){
            $str = '刚刚';
        }
        if($fldtime == 0){
            $str = '刚刚';
        }elseif($fldtime < 60){
            $str = $fldtime.'分钟前';
        }elseif($fldtime < 1140){
            $str = intval($fldtime/60).'个小时前';
        }elseif($fldtime < 525600){
            $str = intval($fldtime/1140).'天前';
        }else{
            $str = intval($fldtime/525600).'年前';
        }
        return $str;
    }
    /**
     * 日期数字转中文
     * 用于日和月、周
     * @static
     * @access public
     * @param integer $number 日期数字
     * @return string
     */
    public static function  numberToCh($number) {
        $number = intval($number);
        $array  = array('一','二','三','四','五','六','七','八','九','十');
        $str = '';
        if($number  ==0)  { $str .= "十" ;}
        if($number  <  10){
            $str .= $array[$number-1] ;
        }
        elseif($number  <  20  ){
            $str .= "十".$array[$number-11];
        }
        elseif($number  <  30  ){
            $str .= "二十".$array[$number-21];
        }
        else{
            $str .= "三十".$array[$number-31];
        }
        return $str;
    }
    /**
     * 年份数字转中文
     * @static
     * @access public
     * @param integer $yearStr 年份数字
     * @param boolean $flag 是否显示公元
     * @return string
     */
    public static function  yearToCh( $yearStr ,$flag=false ) {
        $array = array('零','一','二','三','四','五','六','七','八','九');
        $str = $flag? '公元' : '';
        for($i=0;$i<4;$i++){
            $str .= $array[substr($yearStr,$i,1)];
        }
        return $str;
    }
    /**
     *  判断日期 所属 干支 生肖 星座
     *  type 参数：XZ 星座 GZ 干支 SX 生肖
     *
     * @static
     * @access public
     * @param string $type  获取信息类型
     * @return string
     */
    public static function magicInfo($type,$year,$month=0,$day=0) {
        $result = '';
        $m      =   $month;
        $y      =   $year;
        $d      =   $day;
    
        switch ($type) {
            case 'XZ'://星座
                $XZDict = array('摩羯','宝瓶','双鱼','白羊','金牛','双子','巨蟹','狮子','处女','天秤','天蝎','射手');
                $Zone   = array(1222,122,222,321,421,522,622,722,822,922,1022,1122,1222);
                if((100*$m+$d)>=$Zone[0]||(100*$m+$d)<$Zone[1])
                    $i=0;
                    else
                        for($i=1;$i<12;$i++){
                            if((100*$m+$d)>=$Zone[$i]&&(100*$m+$d)<$Zone[$i+1])
                                break;
                    }
                    $result = $XZDict[$i].'座';
                    break;
    
            case 'GZ'://干支
                $GZDict = array(
                array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸'),
                array('子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥')
                );
                $i= $y -1900+36 ;
                $result = $GZDict[0][$i%10].$GZDict[1][$i%12];
                break;
    
            case 'SX'://生肖
                $SXDict = array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');
                $result = $SXDict[($y-4)%12];
                break;
    
        }
        return $result;
    }
	
    /**
     * 取得某个时间段有几个周 上限100个周
     * @param string $year_start 起始日期 2016-09-01
     * @param string $year_end   束结日期 2016-12-31
     * @return array
     */
    public static function section_week($year_start,$year_end) {
        $startday = strtotime("this week", strtotime($year_start));			//第一周的起始日期时间戳
        $year_mondy = date("Y-m-d", $startday);								//第一周的起始日期
        $endday = strtotime($year_end);										//束结时间戳
    
        $week_array = array();												//存入每周的起始日期和结束时间
    
        for ($i = 1; $i <= 100; $i++) {
            $j = $i-1;
    
            $startweet = strtotime("$year_mondy $j week");					//当前周的起始日期时间戳
            $start_day = date("Y-m-d",$startweet);							//当前周的起始日期
            $start_day_ymd = date("Ymd",$startweet);
    
            $endweet = strtotime("$start_day +6 day");						//当前周的束结日期时间戳
            $end_day = date("Y-m-d",$endweet);								//当前周的束结日期
            $end_day_ymd = date("Ymd",$endweet);
            //存入
            $week_array[] = array('start'=>$start_day,'end'=>$end_day,'start_ymd'=>$start_day_ymd,'end_ymd'=>$end_day_ymd,'key'=>$i);
    
            if($endweet >= $endday){
                break;
            }
        }
        return $week_array;
    }
    /**
     * 取得某个年的月分 上限12个月
     * @param string $year 年份 2016
     * @param string $year_month 月份(默认为空) 取出已过去的月份
     * @return array
     */
    public static function year_month($year,$year_month=''){
        $montharr = array();
        if(empty($year_month)){
            for($i=1;$i<=12;$i++){
                if($i>=10){
                    $j=$year.'-'.$i.'-01';
                }else{
                    $j = $year.'-0'.$i.'-01';
                }
                $startmonth = date("Y-m-d", strtotime("this month", strtotime($j)));
                $endmonth = date('Y-m-d', strtotime($j.' +1 month -1 day'));
                $montharr[]=array('start'=>$startmonth,'end'=>$endmonth,'key'=>$i);
            }
        }else{
            if($year_month > 0 || $year_month < 12){
                for($i=1;$i<=12;$i++){
                    if($year_month >= 10){
                        $j=$year.'-'.$year_month.'-01';
                    }else{
                        $j = $year.'-0'.$year_month.'-01';
                    }
                    
                    $startmonth = date("Y-m-d", strtotime("this month", strtotime($j)));
                    $endmonth = date('Y-m-d', strtotime($j.' +1 month -1 day'));
                    $coutmonth = array('start'=>$startmonth,'end'=>$endmonth,'key'=>$year_month);
                    
                    $montharr[]=$coutmonth;
                    
                    //当前月份自减
                    $year_month--;
                    //当月份小于0时恢复12并年份自减
                    if($year_month <= 0){
                        $year_month = 12;
                        $year--;
                    }
                }
            }
        }
    
        return $montharr;
    }
    /**
     * 取得某个年的月分 上限12个月(是否按照学期)
     * @param string $year 年份 2016
     * @param string $year_month 月份(默认为空) 起始 9 取出已过去的月份
     * @param bool $isxq 是否按照学期
     * @return array
     */
    public static function year_months($year,$year_month='',$isxq=FALSE){
        $montharr = array();
        if(empty($year_month)){
            for($i=1;$i<=12;$i++){
                if($i>=10){
                    $j=$year.'-'.$i.'-01';
                }else{
                    $j = $year.'-0'.$i.'-01';
                }
                $startmonth = date("Y-m-d", strtotime("this month", strtotime($j)));
                $endmonth = date('Y-m-d', strtotime($j.' +1 month -1 day'));
                $montharr[]=array('start'=>$startmonth,'end'=>$endmonth,'key'=>$i);
            }
        }else{
            if($year_month > 0 || $year_month < 12){
                for($i=1;$i<=12;$i++){
                    if($year_month >= 10){
                        $j=$year.'-'.$year_month.'-01';
                    }else{
                        $j = $year.'-0'.$year_month.'-01';
                    }
                    $startmonth = date("Y-m-d", strtotime("this month", strtotime($j)));
                    $endmonth = date('Y-m-d', strtotime($j.' +1 month -1 day'));
                    $coutmonth = array('start'=>$startmonth,'end'=>$endmonth,'key'=>$year_month);
    
                    //是否按照学期
                    if($isxq){
                        array_unshift($montharr,$coutmonth);
                    }else{
                        $montharr[]=$coutmonth;
                    }
    
                    //是否按照学期
                    if($isxq){
                        if($year_month == 9){
                            break;
                        }
                    }
                    //当前月份自减
                    $year_month--;
                    //当月份小于0时恢复12并年份自减
                    if($year_month <= 0){
                        $year_month = 12;
                        $year--;
                    }
                }
            }
        }
    
        return $montharr;
    }
	
}