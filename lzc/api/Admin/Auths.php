<?php

namespace api\Admin;

use \phplib\AdminPage;

class Auths extends BaseAdmin
{
	public function list()
	{   global $db;
				//分页
		//总条数
		$authcount = $db->__call('x_get_auths_count')[0]['count'];
		$AdminPage = new AdminPage();
		//每页显示条数
        $limitcount = $db->__call('x_listone_confs',['authslist'])[0]['valuename'];
        $data['pag'] = $AdminPage->getPage($limitcount,$authcount);
		$data['result'] = $db->__call('x_list_auths',[$data['pag']['beginlimit'],$limitcount]);
		$data['mes'] = $_GET['mes']??'';
		$artcount = $db->__call('x_get_auths_count');
		$this->display('admin/authslist',$data);
	}
	public function add()
	{   global $db;
            if(isset($_POST)){
               $result = $db->__call('x_add_auths',$_POST);
               if($result){
                  $data['msg'] = '添加成功！';
               }
               else{
                  $data['msg'] = '添加失败！';
               }
            }
            $data['auth'] = $db->__call('x_listpid_auths',[0]);
	    $this->display('admin/authsadd',$data);
	}
        public function update(){
                echo $_GET['post'];
        }
}