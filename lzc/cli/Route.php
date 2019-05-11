<?php

namespace cli;

class Route 
{
/**
*@desc 路由类
*/
	public $ctrl;
    public $action;
    public $path;
    public $route;
	public function __construct()
	{
		$route =  $_SERVER['REQUEST_URI'];
        global $conf;
        //伪静态设置
        if($conf['html_static']){
            if(substr($route,-(strlen($conf['html_static']))) != $conf['html_static'])
            {
                throw new \Exception($route."路径不存在");
            }
            $route = substr($route,0,-(strlen($conf['html_static'])+1));
        }
        if($route == '/' ){
			$c_Route =  explode('/',trim($conf['index'],'/'));
        	$this->ctrl = 'Index';
        	$this->action = 'hello';
        }
        else{
            $path = explode('/',trim($route,'/'));
            if(count($path) <2)
            {
            	throw new \Exception($route."路径不存在");
            }
            else
            {
                if(ucfirst($path[0])=='Admin') {
                    $this->ctrl = ucfirst($path[0]).'\\'.ucfirst($path[1]);
                    $this->action = $path[2];
                    unset($path[0]);
                    unset($path[1]);
                    unset($path[2]);
                    $get_b = 3;
                }
                else{
                    $this->ctrl = ucfirst($path[0]);
                    $this->action = $path[1];
                    unset($path[0]);
                    unset($path[1]);
                    $get_b = 2;
                }
            }
            //获取GET参数
            if(!empty($path))
            {
                for($i=$get_b;$i<count($path)+$get_b;$i+=2)
                {
                    $_GET[$path[$i]] = htmlspecialchars($path[$i+1]);
                }
            }
        }
        $_SERVER['REQUEST_URI'] = '/'.$this->ctrl.'/'.$this->action;
        $this->clean();
	}
    //数据过滤
    private function clean()
    {
        $commfunc = new \phplib\CommFuc();
        $_GET = array_map(array($commfunc,'escape'), $_GET);
        $_POST = !empty($_POST)?$_POST:json_decode(file_get_contents("php://input"),true);
        if(!empty($_POST))
        $_POST = array_map(array($commfunc,'escape'),$_POST);
        $_REQUEST = array_map(array($commfunc,'escape'), $_REQUEST);
    }
}