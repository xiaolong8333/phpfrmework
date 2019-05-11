<?php

namespace phplib;

class AdminPage
{
	//数据过滤
	public function getPage($limitcount,$count)
	{
        if(isset($_GET['pag']) && !empty($_GET['pag'])){
        	$beginlimit = $_GET['pag']*$limitcount-$limitcount;
        	if($beginlimit>=$count){
        		$beginlimit=$beginlimit-$limitcount;
        		$_GET['pag']=ceil($count/$limitcount);
        	}
        }
        else{
        	$beginlimit=0;
        	$_GET['pag']=1;
        }
        $data = ['b'=>$count,
        'pag'=>$_GET['pag'],
        'beginlimit'=>$beginlimit,
        'paglimit'=>$limitcount];
        return $data;
	}

	//显示分页
	public static function showPage($biglimit,$pagelimit,$page,$url)
	{
	  $bigp = ceil($biglimit/$pagelimit);
      if($bigp<=5){
            for($i=1;$i<=$bigp;$i++){
            echo '<li class="paginItem"><a href="'.$url.$i.'">'.$i.'</a></li>';
        }
      }
      else{
        $more = $page+4;
        $max = $page+4>=$bigp?$bigp:$page+4;
        $max = $page<5?5:$max;
        for($i=$max-4;$i<=$max;$i++){
            echo '<li class="paginItem"><a href="'.$url.$i.'">'.$i.'</a></li>';
        }
         echo '<li class="paginItem more">
            <a href="'.$url.$more.'">...</a>
             </li>';
      }
	}
}