<?php
header("Content-Type: text/html;charset=utf-8");
//跨域请求
/*header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, Accept,APPID,TOKEN');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Credentials:true');*/
session_start();

date_default_timezone_set("Asia/Shanghai");

define('__ROOT__',__DIR__);
define('__HOSTNAME__','http://192.168.31.151');
define('__ASSET__','/web/');
include_once __DIR__.'/cli/AutoLoad.php';

spl_autoload_register('cli\AutoLoad::load');
cli\ZPHP::run();