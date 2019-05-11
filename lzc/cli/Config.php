<?php

namespace cli;

class Config implements \ArrayAccess //该接口使类可以像数组一样使用
{
	protected $path;
	protected $configs = array();
	function __construct($path)
	{
		$this -> path = $path;
	}
	function offsetGet($key)
	{
		if(empty($this->configs[$key])){
			$file_path = $this -> path.'/'.$key.'.php';
			$config = require $file_path;
			$this -> configs[$key] = $config;
		}
		return $this->configs[$key];
	}
	function offsetSet($key,$value)
	{
		throw new \Exception("connat write config file.");
	}
	function offsetExists($key)
	{
		return isset($this->configs[$key]);
	}
	function offsetUnset($key)
	{
		unset($this -> configs[$key]);
	}	
}
