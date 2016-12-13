<?php
namespace app\index\controller;

class Index{
    public function index(){
        
        echo 'index index index ',__CLASS__,'<br />';
        
        $db = \library\sql\Sqldb::getdb();
        
        $aa = $db->fetch_One('select * from newfenboo2015.tbl_user_info where fld_userid=200285');
        print_r($aa);
        
        
        $dbs = \library\sql\Sqldb::getdb();
        print_r($dbs->error);
    }
}
