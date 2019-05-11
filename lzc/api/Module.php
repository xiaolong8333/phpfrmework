<?php

namespace api;
class Module extends BaseApi
{
	public function header()
	{
		global $db;
		$data['navs'] = $db->__call('x_get_navs');
        $this->display('home/module/header',$data);
	}
	public function aside()
	{
		global $db;
		$data['categorys'] = $db->__call('x_list_categorys');
		$data['tags'] = $db->__call('x_list_tags',[7]);
		print_r($data);
        $this->display('home/module/aside',$data);
	}
	public function whole2()
	{
		global $db;
        $this->display('home/module/whole2');
	}
	public function footer()
	{
		global $db;
		$data['connections'] = $db->__call('x_show_connections');
        $this->display('home/module/footer',$data);
	}
}