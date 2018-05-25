<?php
//PHP异步处理
class Trigger{
		  function triggerRequest($url, $post_data = array(), $cookie = array()){
			$method = "GET";  //可以通过POST或者GET传递一些参数给要触发的脚本
			$url_array = parse_url($url); //获取URL信息，以便平凑HTTP HEADER
			$port = isset($url_array['port'])? $url_array['port'] : 80; 
		   
			$fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30); 
			if (!$fp){
					return FALSE;
			}
			$end = "\r\n";
			$getPath = $url_array['path'] ."?". $url_array['query'];
			if(!empty($post_data)){
					$method = "POST";
			}
			$header = $method . " " . $getPath;
			$header .= " HTTP/1.1$end";
			$header .= "Host: ". $url_array['host'] . "$end"; //HTTP 1.1 Host域不能省略
			$header .= "Connection: Close$end";
			if(!empty($cookie)){
					$_cookie = strval(NULL);
					foreach($cookie as $k => $v){
							$_cookie .= $k."=".$v."; ";
					}
					$cookie_str =  "Cookie: " . base64_encode($_cookie) ." \r\n";//传递Cookie
					$header .= $cookie_str;
			}
			if(!empty($post_data)){
					$_post = strval(NULL);
					foreach($post_data as $k => $v){
							$_post .= $k."=".$v."&";
					}
					$post_str  = "Content-Type: application/x-www-form-urlencoded$end";//POST数据
					$post_str .= "Content-Length: ". strlen($_post) ."$end$end";//POST数据的长度
					$post_str .= $_post."$end"; //传递POST数据
					$header .= $post_str;
			}
			$header .= "$end";
			fputs($fp, $header);
			fclose($fp);
			return true;
		}
}
?>