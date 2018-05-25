<?php
function gettoken($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
    curl_setopt($ch, CURLOPT_ENCODING ,'gzip'); //加入gzip解析
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function getshort($data,$url){
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     $tmpInfo = curl_exec($ch);
     if (curl_errno($ch)) {
      return curl_error($ch);
     }
     curl_close($ch);
     return $tmpInfo;
}

function get_contents() {     
  $xmlstr = file_get_contents('php://input')?file_get_contents('php://input') : gzuncompress($GLOBALS['HTTP_RAW_POST_DATA']);//得到post过来的二进制原始数据  
  $filename=time().'.png';    
  /*if(file_put_contents($filename,$xmlstr)){
  	 //echo file_put_contents($filename,$xmlstr, FILE_APPEND);  
  	 echo file_put_contents('https://Rexmix/hpy/index.php/public/Uploads/'.$filename, $filename);
	 echo 'success';    
	  }else{    
	 echo 'failed';  
	 echo "文件 $filename 不可写";  
  }*/
  if (is_writable($filename)) {
	echo file_put_contents($filename, "This is another something.", FILE_APPEND);
	} else {
	    echo "文件 $filename 不可写";    
	} 
}

/*
* 排序二维数组
*$arrays  数组
*$sort_key 排序字节
**/
function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){   
    if(is_array($arrays)){   
        foreach ($arrays as $array){   
            if(is_array($array)){   
                $key_arrays[] = $array[$sort_key];   
            }else{   
                return false;   
            }   
        }   
    }else{   
        return false;   
    }  
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);   
    return $arrays;   
}  




function is_weixin(){
	if (stripos($_SERVER['HTTP_USER_AGENT'],'micromessenger')!== false)return true;
	return false;
}



/** 格式化时间戳，精确到毫秒，x代表毫秒 */
function microtime_format($tag, $time)
{
	list($usec, $sec) = explode(".", $time);
	$date = date($tag,$usec);
	return str_replace('x', $sec, $date);
}


/** 获取当前时间戳，精确到毫秒 */
function microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}


//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}



function getModelTypeType($v) {
	if($v=="text")return "单行文本";
	if($v=="textarea")return "多行文本";
	if($v=="html")return "HTML输入框";
	if($v=="select")return "下拉框";
	if($v=="radio")return "单选框";
	if($v=="checkbox")return "多选框";
	if($v=="password")return "密码框";
	if($v=="hidden")return "隐藏域";
	if($v=="file")return "上传按钮";

	return "";
}
function getModelTypeMust($v) {
	if($v=="")return "不做限制";
	if($v=="must")return "不能为空";
	if($v=="email")return "邮件格式";
	if($v=="mobile")return "手机号码";
	if($v=="phone")return "电话号码";
	if($v=="url")return "网址格式";
	if($v=="post")return "邮政编码";
	if($v=="qq")return "QQ号码";
	if($v=="number")return "数字格式";
	if($v=="english")return "英文字母";
	return "";
}


//获取根据某一个条件返回某个记录
function getModelBy($selectValue,$model,$selectStr,$returnId="") {
	if(empty($selectStr))return "";
	$xhj_re=M($model)->where(array($selectStr=>$selectValue))->find();
	if(!$xhj_re)return "";
	if(empty($returnId))return $xhj_re;
	return $xhj_re[$returnId];
}

function getWxuserMobile($openid) {
	$wxinfo=F('WeiXinUser/chk_'.$openid);
	if(!$wxinfo){
		$wxinfo=getModelBy($openid,"WxUser","openid","");
		if($wxinfo)F('WeiXinUser/chk_'.$openid,$wxinfo);
	}
	if(!$wxinfo) return "";
	return $wxinfo["mobile"];
}


/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}


function sendMsgTmp($openid,$order,$type,$p_1='') {
	if(empty($openid)||empty($order)||empty($type))return;
	//$url_api=U("Home/Url/order?to=1&id=".$order['id'],"",true,false,true);
	$url_api="http://Rexmix/parking/index.php/Home/User/order_info/id/".$order["id"].".html";
	$first="";
	$template_id_api=C($type.'_apiid');
	$ConfigAll=C('WEBCONFIG');
	if(!$ConfigAll)return;
	$remark_api=$ConfigAll[$type];
	if(empty($remark_api))return;
	if($type=="wxre_type0"){		
		$first=$remark_api;
					/*
					{{first.DATA}}
					订单号：{{orderID.DATA}}
					待付金额：{{orderMoneySum.DATA}}
					{{backupFieldName.DATA}}{{backupFieldData.DATA}}
					{{remark.DATA}}
					*/
		$data_api=array("first"=>array("value"=>$first),"remark"=>array("value"=>$remark_api),"orderMoneySum"=>array("value"=>($order['price'])),"orderID"=>array("value"=>$order['orderid']),"backupFieldName"=>array("value"=>"服务项目:"),"backupFieldData"=>array("value"=>$order['prdname']));

	}
	
	if($type=="wxre_type1"){

		$first=$remark_api;
		/*
		{{first.DATA}}
		课程：{{keyword1.DATA}}
		客户姓名：{{keyword2.DATA}}
		联系方式：{{keyword3.DATA}}
		预约时间：{{keyword4.DATA}}
		地址：{{keyword5.DATA}}
		{{remark.DATA}}
		在发送时，需要将内容中的参数（{{.DATA}}内为参数）赋值替换为需要的信息
		内容示例
		您有新的订单
		课程：哈他
		客户姓名：张三
		联系方式：15009995000
		预约时间：2014年7月21日 18:36
		地址：海定区
		加油！
		*/
		if(!empty($order['openid']))$wxuserName=getWxuserName($order['openid']);
		$mobile=getWxuserMobile($order['openid']);
		$data_api=array("first"=>array("value"=>$first),"remark"=>array("value"=>""),"keyword1"=>array("value"=>$order['prdname']),"keyword2"=>array("value"=>$wxuserName),"keyword3"=>array("value"=>$mobile),"keyword4"=>array("value"=>$order['train_date']." ".$order['train_hour']),"keyword5"=>array("value"=>$order['address']));	
		F('test/data_api',$data_api);
		F('test/template_id_api',$template_id_api);			
	}	

	if(empty($first))return;
	import("@.ORG.Util.WxApi");
	$wxmenuObj = new WxApi($ConfigAll['weixin_appid'],$ConfigAll['weixin_secret']);
	$re=$wxmenuObj->send_template_message($openid,$template_id_api,$url_api,$data_api);

}


function getWxuserName($openid,$uname=false) {
	$wxinfo=F('WeiXinUser/chk_'.$openid);
	if(!$wxinfo){
		$wxinfo=getModelBy($openid,"WxUser","openid","");
		if($wxinfo)F('WeiXinUser/chk_'.$openid,$wxinfo);
	}
	if(!$wxinfo) return "匿名";
	if($uname && !empty($wxinfo["name"])) return $wxinfo["name"];
	if(!empty($wxinfo["nickname"])) return $wxinfo["nickname"];
	return "微信用户".$wxinfo["id"];
}

function getPrdStatus($status, $imageShow = false) {
	/*
	 1 正常
	0 锁定
	*/
	switch ($status) {
		case 0 :
			$showText = '禁用';
			$showImg = '<span class="label label-important">禁用</span>';
			break;
		case 1 :
			$showText = '正常';
			$showImg = '<span class="label label-success">正常</span>';
			break;
		default :
			$showText = '未知';
			$showImg = '<span class="label label-warning">待审</span>';
	}

	return ($imageShow === true) ?  $showImg  : $showText;

}


function br_replace($str){
	//F('test/yyyy',$str);
	$re=str_replace("\r\n","<br>",$str);
	$re=str_replace("\n","<br>",$re);
	//F('test/xxxx',$re);
	return $re;
}

function wxapi_error_code($code) {
	$errors = array(
			'-1' => '系统繁忙',
			'0' => '请求成功',
			'40001' => '获取access_token时AppSecret错误，或者access_token无效',
			'40002' => '不合法的凭证类型',
			'40003' => '不合法的OpenID',
			'40004' => '不合法的媒体文件类型',
			'40005' => '不合法的文件类型',
			'40006' => '不合法的文件大小',
			'40007' => '不合法的媒体文件id',
			'40008' => '不合法的消息类型',
			'40009' => '不合法的图片文件大小',
			'40010' => '不合法的语音文件大小',
			'40011' => '不合法的视频文件大小',
			'40012' => '不合法的缩略图文件大小',
			'40013' => '不合法的APPID',
			'40014' => '不合法的access_token',
			'40015' => '不合法的菜单类型',
			'40016' => '不合法的按钮个数',
			'40017' => '不合法的按钮个数',
			'40018' => '不合法的按钮名字长度',
			'40019' => '不合法的按钮KEY长度',
			'40020' => '不合法的按钮URL长度',
			'40021' => '不合法的菜单版本号',
			'40022' => '不合法的子菜单级数',
			'40023' => '不合法的子菜单按钮个数',
			'40024' => '不合法的子菜单按钮类型',
			'40025' => '不合法的子菜单按钮名字长度',
			'40026' => '不合法的子菜单按钮KEY长度',
			'40027' => '不合法的子菜单按钮URL长度',
			'40028' => '不合法的自定义菜单使用用户',
			'40029' => '不合法的oauth_code',
			'40030' => '不合法的refresh_token',
			'40031' => '不合法的openid列表',
			'40032' => '不合法的openid列表长度',
			'40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
			'40035' => '不合法的参数',
			'40038' => '不合法的请求格式',
			'40039' => '不合法的URL长度',
			'40050' => '不合法的分组id',
			'40051' => '分组名字不合法',
			'41001' => '缺少access_token参数',
			'41002' => '缺少appid参数',
			'41003' => '缺少refresh_token参数',
			'41004' => '缺少secret参数',
			'41005' => '缺少多媒体文件数据',
			'41006' => '缺少media_id参数',
			'41007' => '缺少子菜单数据',
			'41008' => '缺少oauth code',
			'41009' => '缺少openid',
			'42001' => 'access_token超时',
			'42002' => 'refresh_token超时',
			'42003' => 'oauth_code超时',
			'43001' => '需要GET请求',
			'43002' => '需要POST请求',
			'43003' => '需要HTTPS请求',
			'43004' => '需要接收者关注',
			'43005' => '需要好友关系',
			'44001' => '多媒体文件为空',
			'44002' => 'POST的数据包为空',
			'44003' => '图文消息内容为空',
			'44004' => '文本消息内容为空',
			'45001' => '多媒体文件大小超过限制',
			'45002' => '消息内容超过限制',
			'45003' => '标题字段超过限制',
			'45004' => '描述字段超过限制',
			'45005' => '链接字段超过限制',
			'45006' => '图片链接字段超过限制',
			'45007' => '语音播放时间超过限制',
			'45008' => '图文消息超过限制',
			'45009' => '接口调用超过限制',
			'45010' => '创建菜单个数超过限制',
			'45015' => '回复时间超过限制',
			'45016' => '系统分组，不允许修改',
			'45017' => '分组名字过长',
			'45018' => '分组数量超过上限',
			'46001' => '不存在媒体数据',
			'46002' => '不存在的菜单版本',
			'46003' => '不存在的菜单数据',
			'46004' => '不存在的用户',
			'47001' => '解析JSON/XML内容错误',
			'48001' => 'api功能未授权',
			'50001' => '用户未授权该api',
			'40070' => '基本信息baseinfo中填写的库存信息SKU不合法。',
			'41011' => '必填字段不完整或不合法，参考相应接口。',
			'40056' => '无效code，请确认code长度在20个字符以内，且处于非异常状态（转赠、删除）。',
			'43009' => '无自定义SN权限，请参考开发者必读中的流程开通权限。',
			'43010' => '无储值权限,请参考开发者必读中的流程开通权限。',
			'43011' => '无积分权限,请参考开发者必读中的流程开通权限。',
			'40078' => '无效卡券，未通过审核，已被置为失效。',
			'40079' => '基本信息base_info中填写的date_info不合法或核销卡券未到生效时间。',
			'45021' => '文本字段超过长度限制，请参考相应字段说明。',
			'40080' => '卡券扩展信息cardext不合法。',
			'40097' => '基本信息base_info中填写的url_name_type或promotion_url_name_type不合法。',
			'49004' => '签名错误。',
			'43012' => '无自定义cell跳转外链权限，请参考开发者必读中的申请流程开通权限。',
			'40099' => '该code已被核销。'
	);
	$code = strval($code);
	if($errors[$code]) {
		return $errors[$code];
	} else {
		return '未知错误';
	}
}

/** * 字符串半角和全角间相互转换
 * @param string $str 待转换的字符串
 * @param int  $type TODBC:转换为半角；TOSBC，转换为全角，0半角转全角；1全角转半角。
 * @return string 返回转换后的字符串
 */
function convertStrType($str, $type) {
	$DBC = Array(
			'０' , '１' , '２' , '３' , '４' ,
			'５' , '６' , '７' , '８' , '９' ,
			'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,
			'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' ,
			'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,
			'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' ,
			'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,
			'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' ,
			'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,
			'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' ,
			'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,
			'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' ,
			'ｙ' , 'ｚ' , '－' , '　' , '：' ,
			'．' , '，' , '／' , '％' , '＃' ,
			'！' , '＠' , '＆' , '（' , '）' ,
			'＜' , '＞' , '＂' , '＇' , '？' ,
			'［' , '］' , '｛' , '｝' , '＼' ,
			'｜' , '＋' , '＝' , '＿' , '＾' ,
			'￥' , '￣' , '｀' , '：' , '，'
	);

	$SBC = Array( // 半角
			'0', '1', '2', '3', '4',
			'5', '6', '7', '8', '9',
			'A', 'B', 'C', 'D', 'E',
			'F', 'G', 'H', 'I', 'J',
			'K', 'L', 'M', 'N', 'O',
			'P', 'Q', 'R', 'S', 'T',
			'U', 'V', 'W', 'X', 'Y',
			'Z', 'a', 'b', 'c', 'd',
			'e', 'f', 'g', 'h', 'i',
			'j', 'k', 'l', 'm', 'n',
			'o', 'p', 'q', 'r', 's',
			't', 'u', 'v', 'w', 'x',
			'y', 'z', '-', ' ', ':',
			'.', ',', '/', '%', '#',
			'!', '@', '&', '(', ')',
			'<', '>', '"', '\'','?',
			'[', ']', '{', '}', '\\',
			'|', '+', '=', '_', '^',
			'$', '~', '`', ':', ','
	);

	if ($type == 0) {
		return str_replace($SBC, $DBC, $str);  // 半角到全角
	} else if ($type == 1) {
		return str_replace($DBC, $SBC, $str);  // 全角到半角
	} else {
		return false;
	}
}





?>