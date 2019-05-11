<?php

namespace api\Admin;

class BaseAdmin
{
    static $json;
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

}