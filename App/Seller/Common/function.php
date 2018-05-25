<?php

function getManagerRole($role, $imageShow = false)
{
    switch ($role) {
        case 1 :
            $showText = '系统管理员';
            $showImg = '<span class="label label-success">系统管理员</span>';
            break;
        case 2 :
            $showText = '业务管理员';
            $showImg = '<span class="label label-success">业务管理员</span>';
            break;
        default :
            $showText = '未知';
            $showImg = '<span class="label label-warning">未知</span>';
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

//获取管理员用户名
function getManagerAccount($id)
{
    $info = M("Managers")->getById($id);
    if (!$info) return "未知";
    return $info["account"];
    
}


//锁定
function check($id, $model)
{
    $res = $model->where('id=' . $id)->find();
    if (empty($res)) return false;
    
    //锁定状态提醒
    if ($res['act_status'] == 0) {
        if ($res['act_id'] != $_SESSION[C('USER_AUTH_KEY')]) return false;
    } else {
        $data['act_id'] = $_SESSION[C('USER_AUTH_KEY')];
        $data['act_status'] = 0;
        $info = $model->where('id=' . $id)->save($data);
        return true;
    }
    return true;
}

//解除锁定
function remove($id, $model)
{
    $res = $model->where('id=' . $id)->find();
    if (empty($res)) return false;
    if ((empty($res['act_id'])) || ($res['act_status'] != 1)) {
        // $info['act_id'] = 0;
        $info['act_status'] = 1;
        $changeRes = $model->where('id=' . $id)->save($info);
        return true;
    }
    return true;
}

//获取管理员名称
function getAdminname($id, $model)
{
    $res = $model->where('id=' . $id)->find();
    $id = $res['act_id'];
    $info = M('Managers')->where('id=' . $id)->getField('account');
    return $info;
    
}

/*获取人民币*/
function getRmb($id)
{
    if (empty($id)) exit;
    $info = M('users')->where('id=' . $id)->getField('rmb_price');
    return $info;
}

/*获取比特币*/
function getBtc($id)
{
    if (empty($id)) exit;
    $info = M('users')->where('id=' . $id)->getField('btc_price');
    return $info;
}

/*禁用状态*/
function getStatus($status, $imageShow = false)
{
    switch ($status) {
        case 0 :
            $showText = '禁用';
            $showImg = '<span class="label label-important">禁用</span>';
            break;
        case 1 :
            $showText = '正常';
            $showImg = '<span class="label label-success">正常</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

/*非整充值*/
function getFigure($status, $imageShow = false)
{
    switch ($status) {
        case 0 :
            $showText = '非整数';
            $showImg = '<span class="label label-important">非整数</span>';
            break;
        case 1 :
            $showText = '整数';
            $showImg = '<span class="label label-success">整数</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

/*充值状态*/
function getChongzhi($status, $imageShow = false)
{
    switch ($status) {
        case 1 :
            $showText = '未充值';
            $showImg = '<span class="label label-important">未充值</span>';
            break;
        case 2 :
            $showText = '已充值';
            $showImg = '<span class="label label-success">已充值</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

/*余额充值状态*/
function getYue($status, $imageShow = false)
{
    switch ($status) {
        case 0 :
            $showText = '未充值';
            $showImg = '<span class="label label-important">未充值</span>';
            break;
        case 1 :
            $showText = '已充值';
            $showImg = '<span class="label label-success">已充值</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

/*余额体现状态*/
function getWithdraw($status, $imageShow = false)
{
    switch ($status) {
        case 1 :
            $showText = '未提现';
            $showImg = '<span class="label label-important">未提现</span>';
            break;
        case 2 :
            $showText = '已提现';
            $showImg = '<span class="label label-success">已提现</span>';
            break;
        
        case 3:
            $showText = '提现失败';
            $showImg = '<span class="label label-important">提现失败</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}

/*充值状态*/
function getChuidan($status, $imageShow = false)
{
    switch ($status) {
        case 1 :
            $showText = '催单';
            $showImg = '<span class="label label-important">催单</span>';
            break;
        case 0 :
            $showText = '正常';
            $showImg = '<span class="label label-success">正常</span>';
            break;
        
        default:
            $showText = '催单';
            $showImg = '<span class="label label-important">催单</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
}

/*订单状态*/
function getOrderStatus($status, $imageShow = false)
{
    switch ($status) {
        case 1 :
            $showText = '正常';
            $showImg = '<span class="label label-success">正常</span>';
            break;
        case 2 :
            $showText = '申请退款';
            $showImg = '<span class="label label-important">申请退款</span>';
            break;
        
        case 3 :
            $showText = '退款成功';
            $showImg = '<span class="label label-error">退款成功</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
}


/*礼品使用状态*/
function getGiftStatus($status, $imageShow = false)
{
    switch ($status) {
        case 1 :
            $showText = '未使用';
            $showImg = '<span class="label label-important">未使用</span>';
            break;
        case 2 :
            $showText = '已使用';
            $showImg = '<span class="label label-success">已使用</span>';
            break;
        
        case 3 :
            $showText = '不能使用';
            $showImg = '<span class="label label-danger">不能使用</span>';
            break;
        
        
    }
    return ($imageShow === true) ? $showImg : $showText;
    
}


function chkArc($arc)
{
    if (empty($arc)) return false;
    $manager = @$_SESSION[C('USER_AUTH_INFO')];
    if (!$manager) return false;
    if ($manager['role'] == 1) return true;
    $manager_arc = $manager['arc'];
    if (empty($manager_arc)) return false;
    $split_k = split(",", $arc);
    foreach ($split_k as $k => $v) {
        if (!empty($v) && (stripos(',,' . $manager_arc . ',,', ',' . $v . ','))) return true;
    }
    return false;
}

/*获取供应商名称*/
function getStoreName($id)
{
    if (empty($id)) exit;
    $info = M('Users')->where('id=' . $id)->getField('store_name');
    return $info;
}

/*获取客户名称*/
function getUsername($id)
{
    if (empty($id)) exit;
    $info = M('Users')->where('id=' . $id)->getField('nickname');
    return $info;
}

/*Timestamp 不显示0000-00-00 00:00:00*/
function timeShow($time)
{
    if ($time == "0000-00-00 00:00:00") {
        return '';
    } else {
        return $time;
    }
}

/*获取管理员名称*/
function getAdmin($id)
{
    if (empty($id)) exit;
    $info = M('Admin')->where('id=' . $id)->getField('username');
    return $info;
}

/*Timestamp 不显示0000-00-00 00:00:00*/
function reminderShow($reminder)
{
    if ($reminder == 1) {
        return '是';
    } else {
        return '否';
    }
}

function getStoreName2($storenum)
{
    $map['id'] = $storenum;
    $storename = M('user')->where($map)->getField('name');
    return $storename ? $storename : '未知';
}

function ketixian($storenum)
{
    $map['state'] = 1;
    $map['merchantNo'] = $storenum;
    $a = M('run')->where($map)->sum('money');
    return $a;
}

function yitixian($storenum)
{
    $map['state'] = 2;
    $map['merchantNo'] = $storenum;
    $a = M('run')->where($map)->sum('money');
    return $a;
}

function zongshouyi($storenum)
{
    $map['merchantNo'] = $storenum;
    $a = M('run')->where($map)->sum('money');
    return $a;
}

function getBank($user_id)
{
    $map['id'] = $user_id;
    $a = M('user')->where($map)->getField('bankname');
    return $a;
}

function getPhone($user_id)
{
    $map['id'] = $user_id;
    $a = M('user')->where($map)->getField('phone');
    return $a;
}

function getCardNo($user_id)
{
    $map['id'] = $user_id;
    $a = M('user')->where($map)->getField('bankcardno');
    return $a;
}

function getSortName($id)
{
    $where['id'] = $id;
    $name = M('sort')->where($where)->getField('name');
    return $name;
    
}

?>