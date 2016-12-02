<?php
namespace app\index\controller;

class User{
    public function index(){
        
        echo 'index user index <br />',$_SERVER['REQUEST_URI'];
    }
}
