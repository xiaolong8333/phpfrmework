<?php
return [
    'is_mysql'=>true,
    'debug'=>true,
    'mysql'=>[
    	'db_host'=>'192.168.31.110',
        'db_user'=>'root',
        'db_pwd'=>'',
        'db_port'=>'3306',
        'db_name'=>'blog',
    ],
    'send'=>[
     
    ],
    'html_static'=>false,
	'index'=>'index/index',
    'novalidate'=>['/Download/index','/Download/do','/AliyunApi/Sbsfz','/Index/register','/Send/Sendmes','/Send/validateSend','/Pay/callback','/Pay/showPay'],
    'novalidateAdmin'=>['/Admin/Admins/login'],
];