<?php
namespace app\index\controller;
/**
 *
 */
class Index{
    public function index(){
        //trigger_error('错误');
        //echo 'index index index';
        $user = new \app\index\model\User();
        
        $user->add();
    }
    
}