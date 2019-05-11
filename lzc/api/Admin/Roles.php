<?php

namespace api\Admin;

use \phplib\AdminPage;

class Roles extends BaseAdmin
{
	public function list()
	{   global $db;
				//分页
		//总条数
		$authcount = $db->__call('x_get_roles_count')[0]['count'];
		$AdminPage = new AdminPage();
		//每页显示条数
        $limitcount = $db->__call('x_listone_confs',['roleslist'])[0]['valuename'];
        $data['pag'] = $AdminPage->getPage($limitcount,$authcount);
		$data['result'] = $db->__call('x_list_roles',[$data['pag']['beginlimit'],$limitcount]);
		$data['mes'] = $_GET['mes']??'';
		$artcount = $db->__call('x_get_roles_count');
		$this->display('admin/roleslist',$data);
	}
}