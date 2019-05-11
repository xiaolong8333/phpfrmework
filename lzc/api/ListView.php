<?php

namespace api;

class ListView extends BaseApi
{
	public function show()
	{
		global $db;
        $this->display('home/list-view');
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