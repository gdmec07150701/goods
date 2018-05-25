<?php
namespace Seller\Controller;
use Think\Controller;
class ManagerController extends CommonController {

	function _initialize() {
		Load('extend');
		parent::_initialize();
	}
	
	function index() {		 
		if($this->_manager['role']!=1)$this->error('无权限!');
		$model =new \Think\Model("Managers");
		if(!empty($_POST["act"]) && $_POST["act"]=="del") {
			F('Sys/Managers_*',null);
			$id=isset($_POST["id"])?$_POST["id"]+0:0;
			if($id==$this->_managerId)$this->error('系统未开启自杀功能。');
			if ($id>0){
				$vo = $model->getById($id);
				if(!$vo)$this->error('记录不存在！');
				$list=$model->where('id='.$id)->setField('status', - 1);
				$this->writeLog("","锁定管理员",$model->getLastSql(),$id);
				if($list){
					$this->success('删除成功！');
					exit();
				}
				$this->error('删除失败');
			}
			$this->error('删除失败');
		}
		$map = $this->_search("Managers");
		$map['status'] = array('egt',0);
		if(!empty($_GET['title'])) {
			$map['nickname'] = array('like',"%".$_GET['title']."%");
		}
		if (!empty($model))$this->_list($model, $map);
		$this->assign('reurl', $this->getReturnUrl());
		$this->display();
		return;
	}

	function add() {
		if($this->_manager['role']!=1){
			//修改自己的信息
			$this->redirect('managers_edit');
			exit();
		}
		$act="add";
		$id =isset($_REQUEST["id"])?$_REQUEST["id"]+0:-1;		
		if($id>0){
			$act="edit";			
			$vo = M("Managers")->where("status>=0")->getById($id);
			if(!$vo)$this->error('记录不存在！');
			$this->assign('vo', $vo);
			$arc=explode(',',$vo['arc']);
			$this->assign('accountarc',$arc);
		}
		if(!empty($_POST["sub"]) && $_POST["sub"]=="sub" && ($act=="add"||$act=="edit")) {
			F('Manager/Managers_*',null);
			$model = D("Managers");
	
			$arc="";
			if($_POST["arc"]){
				foreach($_POST["arc"] as $v){
					$arc=$arc.$v.",";
				}
			}
			$arc=rtrim(trim($arc),',');
			$_POST["arc"]=$arc;
			if($act=="add"){
				if (!$model->create())$this->error($model->getError());
				//如果有设置密码
				if(isset($_POST['password']) && !empty($_POST['password'])) {
					$model->password	=	md5($_POST['password']);
				}
				//如果有设置状态			
				if(isset($_POST['status']) && !empty($_POST['status'])) {
					$status=isset($_POST['status'])?1:0;
					$model->status = $status;
				}
				if($model->add()){
					$t_id=$model->getLastInsID();
					$this->writeLog("","新增管理员",$model->getLastSql(),$t_id);
					$this->success('新增成功!',$this->getReturnUrl(true));
					exit();
				}
				$this->error('新增失败!');
			}
			if($act=="edit"){
				
				if (!$model->create())$this->error($model->getError());
				if(isset($_POST['password']) && !empty($_POST['password'])) {
					$model->password	=	md5($_POST['password']);
				}else{
					$model->password	=	$vo['password'];
				}
				$status=isset($_POST['status'])?1:0;
				$model->status = $status;
				unset($model->account);
				if ($model->save()){
					$this->writeLog("","修改管理员",$model->getLastSql(),$id);
					$this->success('编辑成功!',$this->getReturnUrl(true));
					exit();
				}
				$this->error('编辑失败!');
				exit();
					
			}
		}
		$this->assign('act', $act);
		$this->assign('reurl', $this->getReturnUrl());
		$this->display();
	}
	
	function edit() {
		//修改自己的帐号，密码 姓名等基本资料
		$id =$this->_managerId;
		$act="edit";
		$vo = M("Managers")->where("status>=0")->getById($id);
		if(!$vo)$this->error('记录不存在！');
		$this->assign('vo', $vo);
		$arc=explode(',',$vo['arc']);
		$this->assign('arc',$arc);
	
	
		if(!empty($_POST["sub"]) && $_POST["sub"]=="sub" && ($act=="add"||$act=="edit")) {
			F('Sys/Managers_*',null);
			$model = D("Managers");
			if($act=="edit"){
				if (!$model->create())$this->error($model->getError());
				if(isset($_POST['password']) && !empty($_POST['password'])) {
					$model->password	=	md5($_POST['password']);
				}else{
					$model->password	=	$vo['password'];
				}
				unset($model->account);
				unset($model->role);
				unset($model->arc);
				unset($model->status);
				unset($model->remark);
				unset($model->last_login_time);
				unset($model->last_login_ip);
				unset($model->login_count);
				unset($model->create_time);
				if ($model->save()){
					$this->writeLog("","修改管理员",$model->getLastSql(),$id);
					$this->success('编辑成功!',$this->getReturnUrl(true));
					exit();
				}
				$this->error('编辑失败!');
				exit();
					
			}
		}		
		$this->assign('reurl', $this->getReturnUrl());
		$this->display();
		return;
	}	
	
	
	

	
	function log() {
		if($this->_manager['role']!=1)$this->error('无权限!');
		$model =new \Think\Model("ManagersLog");
		$map = $this->_search("ManagersLog");
		if (!empty($model))$this->_list($model, $map);
		$this->assign('reurl', $this->getReturnUrl());
		$this->display();
		return;
	}	
	

	
}