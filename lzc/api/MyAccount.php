<?php

namespace api;

class MyAccount extends BaseApi
{
	public function show()
	{
		global $db;
        $this->display('home/my.account');
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