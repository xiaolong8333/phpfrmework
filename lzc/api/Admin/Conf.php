<?php

namespace api\Admin;

class Conf extends BaseAdmin
{
	public function confList()
	{
		global $db;
		$result = $db->__call('conflist');
		$this->display('admin/confList');

	}
	public function confAdd()
	{
		global $db;
		$result = $db->__call('validate_pass',$_POST);
		if($result){
			header("Location: /admin/User/index");   
		}
	    else{
			$this->display('admin/login',['message'=>'用户名或密码错误！']);
		}
	}
	public function confUpdate()
	{
		$this->display('admin/index');
	}
	public function confDelete()
	{
		$this->display('admin/index');
	}
}