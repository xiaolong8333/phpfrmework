<?php

namespace phplib;

class Database
{
	private $mysqli;
	private $name;
	static public $instance;
	public  function __construct()
	{
		global $conf;
		$mysqlMes = $conf['mysql'];
		$this->mysqli = new \mysqli($mysqlMes['db_host'], $mysqlMes['db_user'], $mysqlMes['db_pwd'], $mysqlMes['db_name']);
		if(mysqli_connect_error()){
		   exit("连接数据库失败！");
		}
		$this->mysqli->set_charset("utf8");//或者 $mysqli->query("set names 'utf8'")
	} 
	/**
	*单例模式
	*/
	static public function getInstance()
	{//声明一个getinstance()静态方法，用于检测是否有实例对象

		if(!self::$instance) self::$instance = new self();

		return self::$instance;

	}
	/**
	*@desc执行sql语句
	*/
	public function querySql(string $sql)
	{
        $result = $this->mysqli->query($sql);
        if(is_bool($result))
        { 
        	return $result;
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        //移动指针到下一条sql  
        $this->mysqli->next_result();
        return $data;
	}
	public function __call(string $name,array $args=[])
	{
		$commfunc = new \phplib\CommFuc();
		if($args==[]){
			$sql = "call {$name} ()";
		}
		else{
	        $args = implode(',',array_map(array($this,'escape'), $args));
            $sql = "call {$name} ({$args})";		
		}

        return $this->querySql($sql);
	}
	private function __close()
	{
		$this->mysqli->close();
	}
	public function escape(string $value){
		return "'".(string)$value."'";
	}

}