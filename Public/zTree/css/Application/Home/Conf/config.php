<?php
return array(
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'zjwdb_6209651', // 数据库名
    'DB_USER'   => 'zjwdb_6209651', // 用户名
    'DB_PWD'    => 'Hh19931216', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
    
    'SHOW_PAGE_TRACE' =>true,//页面trace调试
    'TRACE_PAGE_TABS'=>array(
                            'base'=>'基本',
                            'file'=>'文件',
                            'think'=>'流程',
                            'error'=>'错误',
                            'sql'=>'SQL',
                            'debug'=>'调试'
                        ),
    
);