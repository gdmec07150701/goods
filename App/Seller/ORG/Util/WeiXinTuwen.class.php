<?php
/**
 * 系统图文回复
 */
class WeiXinTuwen {
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
	//图文信息发送
	public function start(){
		$msgtype = $this->_wechatObj->getRevType();
		if(!$msgtype=="text")return;	
				
		$content= $this->_wechatObj->getRevContent();
		$content=trim($content."");
		if($content=="")return;
		$tuwengroup=F('WeiXin/TuwenGroup');
		if(!$tuwengroup){
				$tuwengroup=M("WxTuwenGroup")->where('status=1')->order('id desc')->select();
				if($tuwengroup)F('WeiXin/TuwenGroup',$tuwengroup);
			}

		$tw_pp_gid=0;
		foreach($tuwengroup as $key_u=>$inputrss_u){
				if(empty($inputrss_u["keyword"]))continue;
				$split_k = split("\n", $inputrss_u["keyword"]);
				foreach($split_k as $k => $v){
					$v=trim($v."");
					if(empty($v))continue;
					$pi_ok=false;
					if($inputrss_u["pipei"] && strtoupper($content)==strtoupper($v))$pi_ok=true;
					if(!$inputrss_u["pipei"] && stripos(','.$content,$v))$pi_ok=true;
					if($pi_ok){$tw_pp_gid=$inputrss_u["id"];break;}
				}			
			}
		if($tw_pp_gid<=0)return;
		$tuwen=F('WeiXin/Tuwen_'.$tw_pp_gid);
		if(!$tuwen){
				$tuwen=M("WxTuwen")->where('status=1 and gid='.$tw_pp_gid)->order('id asc')->select();
				if($tuwen)F('WeiXin/Tuwen_'.$tw_pp_gid,$tuwen);
		}
		if(!$tuwen)return;
		$news = array();
		foreach($tuwen as $key_tw=>$inputrss_tw){
			$re_description=$inputrss_tw["info"];
			$re_title=$inputrss_tw["title"];
			$re_img="http://".$_SERVER['HTTP_HOST'].$inputrss_tw["img"];
			//$re_url=$inputrss_tw["url"];
			$re_url=$inputrss_tw["url"];
			if(empty($re_url))$re_url=U('Web/WeiXin/tuwen?id='.$inputrss_tw["id"],"",true,false,true);			
			$new_1= array('Title'=>$re_title, 'Description'=>$re_description,'PicUrl'=>$re_img,'Url'=>$re_url);
			array_push($news,$new_1);
		}
		$this->_wechatObj->news($news)->reply();
		exit();
	}
	
	
}
