<?php

namespace cli;

use \cli\Route;
use \cli\Config;
use \phplib\Database;
class ZPHP
{
    private static $is_mysql;
    private static $debug;
	static function run()
	{
		self::init();
		//获取数据库连接
		if(self::$is_mysql)
		{
			global $db;
			$db = Database::getInstance();
		}
		//设置错误提示
		if(self::$debug){
			ini_set("display_errors", "On"); 
			error_reporting(E_ALL | E_STRICT);
		}
		else{
			ini_set("display_errors", "Off"); 
			error_reporting(0);
		}
		$request = new Route();
		$ctrlFile = __ROOT__.'/api/'.$request->ctrl.'.php';
		//检测类是否存在
		if(!is_file(str_replace('\\', '/', $ctrlFile))){
            throw new  \Exception('\\api\\'.$request->ctrl.'类没有找到');
            exit();
		}
		$ctrlName = '\\api\\'.$request->ctrl;
		$ctrl = new $ctrlName();
		$method = $request->action;
		$ctrl -> $method();
	}
	/**
	*初始化配置文件
	*/
	protected static function init()
	{
		$confArr = new config(__ROOT__.'/conf');
		global $conf;
		$conf = $confArr['conf'];
		self::$is_mysql = $conf['is_mysql'];
		self::$debug = $conf['debug'];
	}

}
