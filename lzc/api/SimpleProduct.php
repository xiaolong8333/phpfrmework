<?php

namespace api;

class SimpleProduct extends BaseApi
{
	public function show()
	{
		global $db;
        $this->display('home/simple-product');
	}
	public function register()
	{
		global $db;
        $this->display('home/pay');
	}
    public function setToken()
    {
         $uuid = md5(microtime(true));
		 return $uuid;
    }
}