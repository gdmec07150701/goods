<?php
namespace Seller\Controller;
use Think\Controller;
class IndexController extends CommonController {
	// 框架首页
	function _initialize() {
		parent::_initialize();
	}
	public function index() {
		//认证登录
		if ( 'public' != strtolower(CONTROLLER_NAME)) {
			if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
				$this->redirect('Public/login');
			}
		}

		$this -> assign('info',$info);

		$this->display();
	}

	public function delrun() {
		$this->assign('menu_active', "index");
		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$dir=RUNTIME_PATH;
		$del_dir=$this->deldir($dir);
		if($del_dir)$this->assign('runtime',"<font color='red'>缓存清除成功！</font>");
		if(!$del_dir)$this->assign('runtime',"<font color='red'>缓存清除失败！</font>");
		$this->display('index');
	}


	function deldir($dir) {
		//先删除目录下的文件：
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
		  $fullpath=$dir."/".$file;
		  if(!is_dir($fullpath)) {
			  unlink($fullpath);
		  } else {
			  $this->deldir($fullpath);
		  }
			}
		}
		closedir($dh);
		//删除当前文件夹：
		if(rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}



}