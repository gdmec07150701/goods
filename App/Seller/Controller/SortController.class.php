<?php

namespace Seller\Controller;

use Think\Controller;

class SortController extends CommonController
{
    // function _initialize() {
    // 	Load('extend');
    // 	parent::_initialize();
    // 	if(!chkArc("xc_w41"))$this->error('无权限!');
    // }
    
    public function lst()
    {
        $model = M('sort');
        $this->_list($model, '');
        $this->display();
    }
    
    public function add()
    {
        if($_POST['id']&&$_POST['name']){
            $res = M('sort')->save($_POST);
            if ($res) {
                $this->successAjax('修改类别成功');
            }
            $this->errorAjax('修改类别失败');
        }
        if ($_POST['name']&&!$_POST['id']) {
            $res = M('sort')->add($_POST);
            if ($res) {
                $this->successAjax('新增类别成功');
            }
            $this->errorAjax('新增类别失败');
        }
        $this->display();
//
    }
    
    public function edit()
    {
        $res = M('sort')->find($_GET['id']);
        $this->assign('vo',$res);
        $this->display('add');
    }
    
    public function del()
    {
        if ($_POST['id']) {
            $res = M('sort')->delete($_POST['id']);
        }
        if ($res) {
            $this->successAjax('成功删除');
        }
        $this->errorAjax('删除失败');
    }
    
}