<?php

namespace cli;

class AutoLoad
{
/**
*@desc 注册自动加载类
*/
	static function Load(string $class)
	{
		$fileName =  __ROOT__.'/'.str_replace('\\', '/', $class).'.php';
		if(is_file($fileName)){
			include_once $fileName;
		}
		else{
	    	throw  new \Exception($class.'没有找到');
	    }
	}
}