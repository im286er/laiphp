<?php
namespace library\hand;
/**
 * 处理时间
 */
class Dates{

    /**
     * 取得某个时间段有几个周 上限100个周
     * @param string $year_start 起始日期 2016-09-01
     * @param string $year_end   束结日期 2016-12-31
     * @return array
     */
    public static function section_week($year_start,$year_end) {
        $startday = strtotime("this week", strtotime($year_start));	//第一周的起始日期时间戳
        $year_mondy = date("Y-m-d", $startday);						//第一周的起始日期
        $endday = strtotime($year_end);										//束结时间戳
    
        $week_array = array();												//存入每周的起始日期和结束时间
    
        for ($i = 1; $i <= 100; $i++) {
            $j = $i-1;
    
            $startweet = strtotime("$year_mondy $j week");				//当前周的起始日期时间戳
            $start_day = date("Y-m-d",$startweet);					//当前周的起始日期
            $start_day_ymd = date("Ymd",$startweet);
    
            $endweet = strtotime("$start_day +6 day");					//当前周的束结日期时间戳
            $end_day = date("Y-m-d",$endweet);						//当前周的束结日期
            $end_day_ymd = date("Ymd",$endweet);

            //存入
            $week_array[] = array(
                'start'=>$start_day,
                'end'=>$end_day,
                'start_ymd'=>$start_day_ymd,
                'end_ymd'=>$end_day_ymd,
                'key'=>$i
            );
    
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
	
}