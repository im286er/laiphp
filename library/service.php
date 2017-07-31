<?php
//基本的服务注册配置
return array(
    //数据库组件
    'db'        => 'library\db\Sqldb',
    //异常组件
    'exception' => 'library\bin\Exception',
    //路由组件
    'router'    => 'library\bin\Url'
);