<?php
/**
 * 检测当前关注的用户是否登记在微信中
 *
 */
class WeiXinUser {
	public $_wechatObj;	//微信类	
	public $_config;//WEB配置
	public $_weixinuser;//当前微信用户

	function __construct($i_wechatObj,$i_config){
		$this->_wechatObj=$i_wechatObj;
		$this->_config=$i_config;
	}
	private function exitInfo($msg="") {
		 print_r($msg);
		 exit();
	 }
	//获取当前微信的用户信息
	public function getUser(){
		$time=time();	
		$openid=$this->_wechatObj->getRevFrom();
		$weixinuser=F('WeiXinUser/chk_'.$openid);
		$condition['openid'] =array("eq",$openid);
		$iscache=true;
		if(!$weixinuser){
			$iscache=false;
			$weixinuser=M("WxUser")->where($condition)->find();
		}
		if(!$weixinuser){
					$iscache=false;
				//不在关注列表中的时候插入数据
					$model = M("WxUser");
					$model->openid=$openid;
					$model->create_time=$time;
					$model->update_time=0;
					$model->add();
					$weixinuser=M("WxUser")->where($condition)->find();
		}
		if(!$weixinuser)$this->exitInfo('用户信息不存在！');
		$this->_weixinuser=$weixinuser;
		$date_day=abs(ceil(($time-$weixinuser['update_time'])/86400));
		if($date_day>=10){
			//10天未更新就启动更新用户资料信息
			import("@.ORG.Util.Trigger");
			$trigger=new Trigger();
			$get_url=U('WxApi/getwxinfo?id='.$weixinuser["id"],"",true,false,true);
			$trigger->triggerRequest($get_url);	
		}	
		if(!$iscache)F('WeiXinUser/chk_'.$openid,$weixinuser);
		$msgtype = $this->_wechatObj->getRevType();
		//记录下用户发来的消息 文本或是图片
		if($msgtype=="text" || $msgtype=="image"){
			$content="";
			if($msgtype=="text")$content= $this->_wechatObj->getRevContent();
			if($msgtype=="image")$content= $this->_wechatObj->getRevPic();
			$model = new Model("WxMsg");
			$time=time();	
			$model->openid=$openid;
			$model->create_time=$time;	
			$model->type=$msgtype;
			$model->wtxt=$content;
			$model->mid=0;
			$model->add();
		}
		return $weixinuser;
	}
	//根据事件情况返回事件模拟的关键字
	public function getEvent(){
		$msgtype = $this->_wechatObj->getRevType();
		if($msgtype!="event")return;
		if(!$this->_weixinuser)$this->getUser();
		$revEvent = array();
        $revEvent = $this->_wechatObj->getRevEvent();
		$mn_keyword="";
		if($revEvent['event']=="subscribe"){
			$mn_keyword=$this->_config["weixin_subscribe"];
			$cid=$revEvent['key'];
			$cid=str_replace("qrscene_","",$cid);
			if(!empty($cid)){
				$cid=strval($cid);
				M("WxUser")->where('id='.$this->_weixinuser["id"])->setField("cid",$cid);
				F('WeiXinUser/chk_'.$this->_weixinuser["openid"],null);
			}
			import("@.ORG.Util.Trigger");
			$trigger=new Trigger();
			$get_url=U('WxApi/getwxinfo?id='.$this->_weixinuser["id"],"",true,false,true);
			$trigger->triggerRequest($get_url);	
		}
		if($revEvent['event']=="unsubscribe"){
			//取消订阅事件 删除缓存，删除用户
			F('WeiXinUser/chk_'.$this->_weixinuser["openid"],null);
			M("WxUser")->where('id='.$this->_weixinuser["id"])->delete();
			$this->exitInfo('unsubscribe');	
		}
		if($revEvent['event']=="SCAN"){
			//扫描带参数二维码事件 此时用户已经关注
			$mn_keyword=$this->_config["weixin_scan"];
			//更新用户所在物业
			$cid=$revEvent['key'];
			$cid=getModelBy($cid,"Company","id","id");
			M("WxUser")->where('id='.$this->_weixinuser["id"])->setField("cid",$cid);
			F('WeiXinUser/chk_'.$this->_weixinuser["openid"],null);
		}


		if(strtolower($revEvent['event'])=="click"){
			$wxmenu=F('WeiXin/Menu');
			if(!$wxmenu){
				$wxmenu=M("WxMenu")->order('id desc')->select();
				if($wxmenu)F('WeiXin/Menu',$wxmenu);
			}

			if($wxmenu){
					$kid=str_replace("v_", "",$revEvent['key'])."";
					foreach($wxmenu as $key_u=>$inputrss_u){
							if(empty($inputrss_u["keyword"]))continue;
							if($kid==($inputrss_u["id"]."")){
								$mn_keyword=$inputrss_u["keyword"];
								break;
							}
					}
			}
		}
		if(empty($mn_keyword))exit();
		//模拟文本关键字
		$wx_str="<xml><ToUserName><![CDATA[".$this->_wechatObj->getRevTo()."]]></ToUserName><FromUserName><![CDATA[".$this->_wechatObj->getRevFrom()."]]></FromUserName><CreateTime>".$this->_wechatObj->getRevCtime()."</CreateTime> <MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$mn_keyword."]]></Content><MsgId>1234567</MsgId></xml>";
		$this->_wechatObj->setRev($wx_str);
	}



	//语音识别
	public function getVoice($log=true){
		$msgtype = $this->_wechatObj->getRevType();
		if($msgtype!="voice")return;
		if(!$this->_weixinuser)$this->getUser();
		$revvoice = $this->_wechatObj->getRevVoice();
		if($revvoice && isset($revvoice["recognition"]) && !empty($revvoice["recognition"])){
			$content=$revvoice["recognition"];
			$openid=$this->_wechatObj->getRevFrom();
			$wx_str="<xml><ToUserName><![CDATA[".$this->_wechatObj->getRevTo()."]]></ToUserName><FromUserName><![CDATA[".$this->_wechatObj->getRevFrom()."]]></FromUserName><CreateTime>".$this->_wechatObj->getRevCtime()."</CreateTime> <MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$revvoice["recognition"]."]]></Content><MsgId>1234567</MsgId></xml>";
			$this->_wechatObj->setRev($wx_str);
			if($log){
				$model = new Model("WxMsg");
				$time=time();	
				$model->openid=$openid;
				$model->create_time=$time;	
				$model->type=$msgtype;
				$model->wtxt=$content;
				$model->mid=0;
				$model->add();
			}
		}
	}



	//检查自定义关键字和自定义图文信息
	public function getKeyWord(){
		if(!$this->_weixinuser)$this->getUser();
		import("@.ORG.Util.WeiXinReply");
		$weiXinReply = new WeiXinReply($this->_wechatObj,$this->_config,$this->_weixinuser);
		$weiXinReply->start();
		import("@.ORG.Util.WeiXinTuwen");
		$weiXinTuwen = new WeiXinTuwen($this->_wechatObj,$this->_config,$this->_weixinuser);
		$weiXinTuwen->start();
	}
	//检查是否是客服消息
	public function getTransfer(){
		if(!$this->_weixinuser)$this->getUser();
		$msgtype = $this->_wechatObj->getRevType();
		if(!$msgtype=="text")return;
		$mn_keyword="";
		$mn_keyword=$this->_config["weixin_transfer"];
		if(empty($mn_keyword))return;
		$content= $this->_wechatObj->getRevContent();
		if(strtoupper($content)==strtoupper($mn_keyword)){

		$weixin_transfer_msg=$this->_config["weixin_transfer_msg"];
		if(!empty($weixin_transfer_msg)){
			import("@.ORG.Util.WxApi");
			$wxmenuObj = new WxApi($this->_config['weixin_appid'],$this->_config['weixin_secret']);  
			$wxmenuObj->message_custom_send_text($this->_wechatObj->getRevFrom(),$weixin_transfer_msg);
		}
		$this->_wechatObj->transfer()->reply();
		exit();
		}
		return;
	}
	

	
	//获取默认回复
	public function getDefault(){
		if(!$this->_weixinuser)$this->getUser();
		$msgtype = $this->_wechatObj->getRevType();
		$mn_keyword="";
		$mn_keyword=$this->_config["weixin_other"];
		if($msgtype=="text")$mn_keyword=$this->_config["weixin_text"];
		if($msgtype=="image")$mn_keyword=$this->_config["weixin_image"];
		if(empty($mn_keyword))exit();


		$wx_str="<xml><ToUserName><![CDATA[".$this->_wechatObj->getRevTo()."]]></ToUserName><FromUserName><![CDATA[".$this->_wechatObj->getRevFrom()."]]></FromUserName><CreateTime>".$this->_wechatObj->getRevCtime()."</CreateTime> <MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$mn_keyword."]]></Content><MsgId>1234567890123456</MsgId></xml>";
		$this->_wechatObj->setRev($wx_str);
		//再循环一下关键字回复
		$this->getKeyWord();
	}
	


	public function getWeiXinCard(){;
		import("@.ORG.Util.WeiXinCard");
		$weiXinCard = new WeiXinCard($this->_wechatObj,$this->_config);
		$weiXinCard->start();
	}



	public function getApiUrlReceive($server,$path){
		$xml_data = file_get_contents('php://input');
		$this->_wechatObj->setRev("");
		$this->_wechatObj->getRev();
		$msgtype = $this->_wechatObj->getRevType();
		if($msgtype=="event"){
			$this->_wechatObj->setRev("");
			$this->getEvent();
			$event_data=$this->_wechatObj->getSetRevStr();
			if(!empty($event_data))$xml_data =$event_data;
		}
		if($msgtype=="voice"){
			$this->_wechatObj->setRev("");
			$this->getVoice(false);
			$event_data=$this->_wechatObj->getSetRevStr();
			if(!empty($event_data))$xml_data =$event_data;
		}
		$contentLength=strlen($xml_data);		
		$fp = fsockopen($server, 80);
		fputs($fp, "POST ".$path." HTTP/1.0\r\n");
		fputs($fp, "Host: ".$server."\r\n");
		fputs($fp, "Content-Type: text/xml\r\n");
		fputs($fp, "Content-Length: ".$contentLength."\r\n");
		fputs($fp, "Connection: close\r\n");
		fputs($fp, "\r\n"); // all headers sent
		fputs($fp, $xml_data); 
		  $inheader = 1; 
		  $result = '';
		  while(!feof($fp)){
		   $line = fgets($fp,1024); 
		   //去掉请求包的头信息 
		   if ($inheader && ($line == "\n" || $line == "\r\n")) { 
				 $inheader = 0; 
			} 
			if ($inheader == 0) { 
			  $result .=$line; 
			} 
		  } 
		  fclose($fp); 
		  unset ($line); 
		  echo $result;
	}


	
}
