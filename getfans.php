<?php
    header('Content-Type: text/html;charset=utf-8');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:GET');
    header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin');
if(isset($_GET['getfans'])&&isset($_GET['userid'])){
	$userid=htmlspecialchars($_GET['userid']);
	$hander = curl_init();
    $url ="https://api.bilibili.com/x/relation/followers?vmid=".$userid."&ps=1";
    curl_setopt ($hander,CURLOPT_USERAGENT ,"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.113 Safari/537.36" );
	curl_setopt ($hander, CURLOPT_CUSTOMREQUEST, 'GET' );  
	curl_setopt($hander,CURLOPT_URL,$url);
	curl_setopt($hander,CURLOPT_HEADER,0);
	curl_setopt($hander, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($hander,CURLOPT_TIMEOUT,600);//超时时间10min,超过了估计也down不下来
	curl_setopt($hander, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($hander, CURLOPT_SSL_VERIFYHOST, false);
    $content=curl_exec($hander);
	$decode=json_decode($content,true);
	if($decode['code']=="-400"){
		echo "-400";
		exit();
	}
	$fans_number=$decode['data']['total'];
	echo sprintf("%07d", $fans_number);
	exit();
}else{
	$value=array(
	"status"=>"error",
	"response"=>"请求参数错误!"
	);
	echo json_encode($value);
	exit();
}
?>