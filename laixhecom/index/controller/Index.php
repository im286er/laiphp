<?php
namespace app\index\controller;
/**
 * 首页
 */
class Index{
    public function index(){
        
        //实例化视图
        $View = new \lai\View();
        //获取模板内容
        $View->fetch();
    }
    
}