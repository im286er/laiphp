<?php
/**
 * 
 */
function error($msg){
    $str = '<div style="border:solid 2px #333;width:500px;height:100px;>"';
    $str .= $msg;
    $str .= '</div>';
    echo $str;
    exit();
}