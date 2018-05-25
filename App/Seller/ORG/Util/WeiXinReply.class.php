<?php
/**
 * 系统自定义关键字回复
 */
class WeiXinReply {
	public $_wechatObj;	//微信类	
	public $_config;//WEB配置
	public $_weixinuser;//当前微信用户

	function __construct($i_wechatObj,$i_config,$i_weixinuser){
		$this->_wechatObj=$i_wechatObj;
		$this->_config=$i_config;
		$this->_weixinuser=$i_weixinuser;
	}
	private function exitInfo($msg="") {
		 print_r($msg);
		 exit();
	 }
	//自定义回复
	public function start(){
		$msgtype = $this->_wechatObj->getRevType();
		if(!$msgtype=="text")return;		
		$content= $this->_wechatObj->getRevContent();
		$content=trim($content."");
		if($content=="")return;
		$wxreply=F('WeiXin/Reply');
		if(!$wxreply){
			//获取自定义回复
			$wxreply=M("WxReply")->where('status=1')->order('id desc')->select();
			if($wxreply)F('WeiXin/Reply',$wxreply);
			}
		if(!$wxreply)return;

				foreach($wxreply as $key_u=>$inputrss_u){
						if(empty($inputrss_u["keyword"]))continue;
						$split_k = split("\n", $inputrss_u["keyword"]);
						foreach($split_k as $k => $v){
							$v=trim($v."");
							if(empty($v))continue;
							$pi_ok=false;
							if($inputrss_u["pipei"] && strtoupper($content)==strtoupper($v))$pi_ok=true;
							if(!$inputrss_u["pipei"] && stripos(','.$content,$v))$pi_ok=true;
							if($pi_ok){
									$re_wtype=strtoupper(trim($inputrss_u["wtype"].""));
									$re_description=$inputrss_u["description"];
									$re_title=$inputrss_u["title"];
									$re_url1="http://".$_SERVER['HTTP_HOST'].$inputrss_u["url1"];
									$re_url2=$inputrss_u["url2"];		
									if(empty($re_url2))$re_url2=U('Web/WeiXin/reply?id='.$inputrss_u["id"],"",true,false,true);
									if($re_wtype=="TEXT"){
										$this->_wechatObj->text($re_description)->reply();
										exit();
									}
									if($re_wtype=="NEWS"){
										$news1= array('Title'=>$re_title, 'Description'=>$re_description,'PicUrl'=>$re_url1,'Url'=>$re_url2);
										$news= array($news1);
										$this->_wechatObj->news($news)->reply();
										exit();
									}
							}
						}			
					}
	}



	
	
}
