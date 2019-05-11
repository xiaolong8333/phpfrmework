<?php

namespace api;

class BaseApi
{
    static $json;
    public $APPID;
    public $TOKEN;
    public function __construct()
    {
        global $conf;
/*        if(!in_array($_SERVER['REQUEST_URI'],$conf['novalidate'])){
            global $db;
            $this->APPID = $_SERVER['HTTP_APPID']??'';
            $this->TOKEN = $_SERVER['HTTP_TOKEN']??'';
            $result = $db->__call('l_users_validate',[$this->APPID,$this->TOKEN]);
            if(!$result){
                echo  $this->error(201,'用户信息无效')->json();
                die;
            }
        }*/

    }
    public function display(string $viewName,array $data=[])
    {
    	$data = $data;
    	$viewName = __ROOT__.'/web/'.$viewName.'.html';
    	if(!is_file($viewName))
    	{
    		throw new  \Exception($viewName.'模板不存在');
    		exit;
    	}
    	require_once $viewName;
    }
    public function error($code = 201,string $message='error')
    {
        self::$json['code'] = $code;
        self::$json['status'] = false;
        self::$json['message'] = urlencode($message);
        return $this;
    }
    public function success(string $message='success')
    {
        self::$json['code'] = '200';
        self::$json['status'] = true;
        self::$json['message'] = urlencode($message);
        return $this;
    }
    public function json($data = [])
    {   
        self::$json['data'] = $data;
        echo  json_encode(self::$json,JSON_UNESCAPED_UNICODE);
    }
}