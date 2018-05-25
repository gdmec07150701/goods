<?php
namespace Seller\Controller;
use Think\Controller;
class PublicController extends CommonController {
	
	// 用户登录页面
	public function login() {
		if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->display();
		}else{
			$this->redirect('Index/index');
			
		}
	}

	public function index() {
		//如果通过认证跳转到首页
		$this->redirect(__GROUP__);
	}

	
	// 登录检测
	public function checkLogin(){
		return $this->checkLoginAct($_POST['username'],$_POST['password']);
	}

	// 登录检测
	public function checkLoginAct($username,$password,$md5=true) {
		// 数据验证
        
        if (empty($username))$this->error('请输入用户名');
		if (empty($password))$this->error('请输入密码');
		$password = $md5?md5($password):$password;
		$map['account']	= $username;
		$map["status"]	= 1;
		$authInfo = M('Managers')->where($map)->find();
        //使用用户名、密码和状态的方式进行认证
		if(!$authInfo)$this->error('帐号不存在或已经被禁用');
		if($authInfo['password'] != $password)$this->error('密码错误');			
		$_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
		$_SESSION[C('USER_AUTH_INFO')]	=	$authInfo;
		//保存登录信息
		$Managers	=	M('Managers');
		$ip		=	get_client_ip();
		$time	=	time();
		$data = array();
		$data['id']	=	$authInfo['id'];
		$data['last_login_time']	=	$time;
		//$data['login_count']	=	array('exp','login_count+1');
		$data['last_login_ip']	=	$ip;
		$Managers->save($data);
		$this->writeLog("","登录系统",$Managers->getLastSql());
		$this->success('登录成功!',"");	
	}	
	
	// 用户登出
	public function logout() {
		if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
		}
		//退出
		$this->redirect('Index/index');
	}

	//普通图片上传
	public function upimg() {
		//$this->checkUser();
		$type = @$_REQUEST["t"];
		import("ORG.Util.Image");
		import('ORG.Net.UploadFile');
		$upload = new \UploadFile();// 实例化上传类
		$upload->maxSize  = 1024*1024*2 ;// 设置附件上传大小 最大2M
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	
		$upload->thumb=false;//是否开启图片文件缩略图
		$upload->thumbMaxWidth='300,500';
		$upload->thumbMaxHeight='200,400';
		$upload->thumbPrefix='s_,m_';//缩略图文件前缀
		$upload->thumbRemoveOrigin=0;//如果生成缩略图，是否删除原图
	
		$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
		$upload->autoSub =true;
		$upload->subType ="date";
		$upload->dateFormat="Y-m-d";
		if(!$upload->upload()) {// 上传错误提示错误信息
			$info =  $upload->getUploadFileInfo();
				
			$data['status'] = 0;
			$data['info'] = $upload->getErrorMsg();
			//$this->ajaxReturn($data,'JSON');
			echo json_encode($data);
			exit();
	
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$img_url=$info[0]['savename'];
			$data['status'] = 1;
			$data['info'] = '上传成功';
			$data['url'] = $img_url;
			//$this->ajaxReturn($data,'JSON');
			echo json_encode($data);
			exit();
		}
	}

	//多图上传
	public function upMuch() {
		//$this->checkUser();
		$type = @$_REQUEST["t"];
		import("ORG.Util.Image");
		import('ORG.Net.UploadFile');
		$upload = new \UploadFile();// 实例化上传类
		//$upload->maxSize  = 1024*1024*2 ;// 设置附件上传大小 最大2M
		$upload->maxSize  = 1024*1024*15 ;// 设置附件上传大小 最大15M
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	
		$upload->thumb=false;//是否开启图片文件缩略图
		$upload->thumbMaxWidth='300,500';
		$upload->thumbMaxHeight='200,400';
		$upload->thumbPrefix='s_,m_';//缩略图文件前缀
		$upload->thumbRemoveOrigin=0;//如果生成缩略图，是否删除原图
		$upload->rootPath = '';
		$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
		$upload->autoSub =true;
		$upload->subType ="date";
		$upload->dateFormat="Y-m-d";
		if(!$upload->upload()) {// 上传错误提示错误信息
			$info =  $upload->getUploadFileInfo();	
			$data['status'] = 0;
			$data['info'] = $upload->getErrorMsg();
			//$this->ajaxReturn($data,'JSON');
			echo json_encode($data);
			exit();
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			foreach ($info as $key => $value) {
				/*$img_url[$key]= '/Public/Uploads/'.$info[$key]['savename'];
				$data['url'][$key] = $img_url;
				$data['pics'][]='/Public/Uploads/'.$info[$key]['savename'];*/
				$img_url[$key]= $info[$key]['savename'];
				$data['url'][$key] = $img_url;
				$data['pics'][]= $info[$key]['savename'];
			}
			$data['status'] = 1;
			$data['info'] = '上传成功';
			echo json_encode($data);
			exit();
		}
	}
	
	
}