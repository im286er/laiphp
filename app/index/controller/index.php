<?php
namespace app\index\controller;

class Index{
    public function index(){
        
        echo __METHOD__;

        $a = \library\db\Sqldb::getdb();
        $getdata = $a->fetch_One('SELECT * FROM user');

        $b = \library\db\Sqldb::getError();
        print_r($b);
        print_r($getdata);
    }
}
