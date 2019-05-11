<?php

namespace api\Admin;

class Admins extends BaseAdmin
{
	public function login()
	{
		global $db;
		if(!$_POST)
			return $this->display('admin/login');
		$data['username'] = $_POST['username']??'';
		$data['password'] = $_POST['password']??'';
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
        $result = $db->__call('x_admins_login',$data);
        if($result)
            header("Location: ".__HOSTNAME__."/admin/Main/show");
        return $this->display('admin/login',['用户名或密码错误']);

	}
	public function getVerifiy()
	{
		$code= new Verifiy(100,32,'png',4,1);
		$_SESSION['Verifiy'] = $code->__get($code);
		$code->show();
	}
	public function validate()
	{ 
	  if($_SESSION['Verifiy'] != $_POST['code'] ){
	  	    echo  1;
	  	 	die;
	  }
	
	  	global $db;
	    unset($_POST['code']);
	  	$result = $db->__call('validate_pass',$_POST);
		if($result){
            echo  0;
            die;
		}
		else{
		    echo  2;
		    die;
		}	
	}
	public function getToken()
	{
		 $uuid = md5(microtime(true));
		 return $uuid;
	}
}