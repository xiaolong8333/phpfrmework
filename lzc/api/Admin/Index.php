<?php

namespace api\Admin;

class Index extends BaseAdmin
{
	public function show()
	{
		$this->display('admin/index');
    }
}