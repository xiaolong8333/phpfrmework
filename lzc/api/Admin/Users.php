<?php

namespace api\Admin;


class Users extends BaseAdmin
{
	public function list()
	{
		global $db;
		$result  =  $db->__call('l_users_list',$_POST);
		return $this->success()->json($result); 
	}
	public function userMes()
	{
		global $db;
		$data['uid'] = $_POST['uid'];
        $data['level'] = $_POST['level'];
		$result  =  $db->__call('l_yzmes',$data);
		return $this->success()->json($result); 
	}
	public function byyz()
	{
		global $db;
		$data['phone'] = $_POST['phone'];

		$data['level'] = $_POST['status']==1?2:3;
		$result  =  $db->__call('l_users_yztg',[$_POST['user_id'],$_POST['status']]);
		if($result){
		    $this->curlPost($data,'http://47.92.198.207/Send/Sendmes');
		    return $this->success()->json();
	    }
	    else{
            return $this->error(901,'通过验证失败')->json();
	    }
	}

	public function curlPost($post_data, $url)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }
}