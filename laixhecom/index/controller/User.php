<?php
namespace app\index\controller;
/**
 * 
 */
class User{
    public function add(){
        //echo 'index user add';
        $View = new \lai\View();
        $View->fetch();
    }
    public function del(){
        echo '删除用户';
    }
}