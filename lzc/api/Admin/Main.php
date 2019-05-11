<?php

namespace api\Admin;

class Main extends BaseAdmin
{
	public function show()
	{

       $this->display('admin/main');
	}
	public function top()
	{

    $this->display('admin/top');
	}
	public function left()
	{

       $this->display('admin/left');
	}
}