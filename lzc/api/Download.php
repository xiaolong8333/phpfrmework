<?php

namespace api;

class Download extends BaseApi
{
    public function index()
    {
    	global $db;
    	if(isset($_GET['code']) && $_GET['code']!=''){
	    	$data['code'] = $_GET['code'];
	        $data['ip'] =  $_SERVER['REMOTE_ADDR'];
	    	$db->__call('l_visit_ip_add',$data);
        }
    	$this->display('home/download');
    }
}