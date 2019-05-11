<?php

namespace api;
use \phplib\HomePage;
class Articles extends BaseApi
{
	public function list()
	{
		global $db;
		$HomePage = new HomePage();
		//分页
		//总条数
		$artcount = $db->__call('x_get_articles_count')[0]['count'];
		//每页显示条数
        $limitcount = $db->__call('x_listone_confs',['hoarticlelist'])[0]['valuename'];
        $data['pag'] = $HomePage->getPage($limitcount,$artcount);
		$data['result'] = $db->__call('x_list_articles',[$data['pag']['beginlimit'],$limitcount]);
		$data['mes'] = $_GET['mes']??'';
		$artcount = $db->__call('x_get_articles_count');
        $this->display('home/articlelist',$data);
	}
	public function listOne()
	{
		global $db;
		$post_id = $_GET['post'];
		$data['article'] = $db->__call('x_listone_articles',[$post_id])[0];

        $this->display('home/articlelistOne',$data);
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