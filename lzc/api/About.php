<?php

namespace api;

class About extends BaseApi
{
	public function show()
	{
		global $db;
        $this->display('home/about');
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