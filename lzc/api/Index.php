<?php

namespace api;

use phplib\FileUpload;
use phplib\IpLocation;
class Index extends BaseApi
{
	public function testapi()
	{

				global $db;
		$commfunc = new \phplib\CommFuc();
		$url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$commfunc->GetIP();
        $json=json_decode($commfunc::http_request($url));
		if(isset($json->code) && $json->code==0){
			$data = [$commfunc->GetIP(),$json->data->country,
			$json->data->area,
			$json->data->city];
		}
		else{
			$data = [$commfunc->GetIP(),'未知地区',
			'未知地区',
			'未知地区'];
		}
		return $this->success()->json($data);
	}
	public function hello()
	{
		global $db;
		self::addvisist($db);
        $this->display('home/index');
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
    //获取访问信息
    private function addvisist($db)
    {
		global $db;
		$commfunc = new \phplib\CommFuc();
		$url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$commfunc->GetIP();
        $json=json_decode($commfunc::http_request($url));
		if(isset($json->code) && $json->code==0){
			$data = [$commfunc->GetIP(),$json->data->country,
			$json->data->area,
			$json->data->city];
		}
		else{
			$data = [$commfunc->GetIP(),'未知地区',
			'未知地区',
			'未知地区'];
		}
		return $db->__call('x_add_visit_record',$data);
    }
}