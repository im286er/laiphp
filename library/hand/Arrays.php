<?php
namespace library\hand;
/**
 * 处理数组
 */
class Arrays{
    /**
     * 筛选数据
     * @param array $atotal	筛选数据的条件(一维索引数组)
     * @param array $only	要筛选的数据(一维关联数组)
     * @param array $divide 筛选后要被排除的数据(一维索引数组)
     * @return array
     */
    public static function seekget($atotal,$only,$divide=array()){
        if(empty($atotal) || empty($only)){
            return false;
        }
        $arrget = array();
        //筛选出数据的条件中有的数据
        foreach ($atotal as $v){
            if(isset($only[$v])){
                $arrget[$v] = $only[$v];
            }
        }
        if(empty($divide)){
            return $arrget;
        }
        //排除
        foreach($divide as $j){
            if(isset($arrget[$j])){
                unset($arrget[$j]);
            }
        }
        return $arrget;
    }
}