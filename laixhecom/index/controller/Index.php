<?php
namespace app\index\controller;
/**
 *
 */
class Index{
    public function index(){
        //trigger_error('错误',E_USER_NOTICE);
        //echo 'index index index';
        $user = new \app\index\model\User();
        //throw new \Exception('异常');
        $user->add();
        
        $View = new \lai\View();
        $View->assign('name','laiki');
        
        $View->fetch();
    }
    
}