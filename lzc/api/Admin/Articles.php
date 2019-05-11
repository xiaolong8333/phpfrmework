<?php

namespace api\Admin;

use \phplib\FileUpload;

use \phplib\AdminPage;

class Articles extends BaseAdmin
{
	public function list()
	{
		global $db;
		$AdminPage = new AdminPage();
		//分页
		//总条数
		$artcount = $db->__call('x_get_articles_count')[0]['count'];
		//每页显示条数
        $limitcount = $db->__call('x_listone_confs',['adartclelistn'])[0]['valuename'];
        $data['pag'] = $AdminPage->getPage($limitcount,$artcount);
		$data['result'] = $db->__call('x_list_articles',[$data['pag']['beginlimit'],$limitcount]);
		$data['mes'] = $_GET['mes']??'';
		$artcount = $db->__call('x_get_articles_count');
		$this->display('admin/articlelist',$data);
    }
    public function add()
	{
		global $db;
		if(isset($_POST)){
			if($_FILES){
				$FileUpload = new \phplib\FileUpload();
				$FileUpload->upload('titleimg');
				$titleimg = '/public/upload/images/titleimg/'.$FileUpload->getFileName();
		    }
		    else{
		    	$titleimg = '';
		    }
		    $article['author_id'] =  1;
			$article['title'] =  $_POST['title']??'';
	        $article['category'] =  $_POST['catgory']??1;
	        $article['titleimg'] =  $titleimg;
	        $article['iip'] =  $_SERVER['REMOTE_ADDR'];
	        $article['contents'] =  $_POST['editorValue']??'';
	        $article['tags'] =  $_POST['tags']??'';
	        $result = $db->__call('x_add_articles',$article);
	        //插入标签
	        if(isset($_POST['tags']) &&  $_POST['tags']!=''){
	        	$data = array_filter(explode('/',$_POST['tags']));
	        	foreach($data as $v){
	        		$db->__call('x_add_tags',[$article['author_id'],$v]);
	        	}
	        }
	        if($result){
	            $data['msg'] = '添加成功！';
	        }
	        else{
	            $data['msg'] = '添加失败！';
	        }
		}
		$data['result'] = $db->__call('x_list_categorys');
		$this->display('admin/articleadd',$data);
    }
	public function update(){
	    global $db;
	    if(isset($_POST) && !empty($_POST)){
       			if($_FILES['titleimg']['name']!=''){
				$FileUpload = new \phplib\FileUpload();
				$FileUpload->upload('titleimg');
				$titleimg = '/public/upload/images/titleimg/'.$FileUpload->getFileName();
		    }
		    else{
		    	$titleimg = $_POST['deimg'];
		    }
		    $article['post_id'] =  $_POST['post_id']??'';
		    $article['author_id'] =  1;
			$article['title'] =  $_POST['title']??'';
	        $article['category'] =  $_POST['catgory']??1;
	        $article['titleimg'] =  $titleimg;
	        $article['iip'] =  $_SERVER['REMOTE_ADDR'];
	        $article['contents'] =  $_POST['editorValue']??'';
	        $article['tags'] =  $_POST['tags']??'';
	        $result = $db->__call('x_update_articles',$article);
	        //插入标签
	        if(isset($_POST['tags']) &&  $_POST['tags']!=''){
	        	$db->__call('x_delete_tags',[$article['post_id']]);
	        	$data = array_filter(explode('/',$_POST['tags']));
	        	foreach($data as $v){
	        		$db->__call('x_add_tags',[$article['author_id'],$v]);
	        	}
	        }
	        if($result){
	            $data['msg'] = '修改成功！';
	        }
	        else{
	            $data['msg'] = '修改失败！';
	        }
	    }
	    $article = $db->__call('x_listone_articles',[$_GET['post_id']]);
	    $data['result'] = $db->__call('x_list_categorys');
	    $data['article'] = $article[0];
	    $this->display('admin/articleupdate',$data);
	}
	public function delete()
	{
		global $db;
		if($db->__call('x_delete_articles',[$_GET['post_id']])){
		   $data['msg'] = '删除成功！';
		}
		else{
		   $data['msg'] = '删除失败！';
		}
		header("Location: ".__HOSTNAME__."/admin/Articles/list");
	}
}