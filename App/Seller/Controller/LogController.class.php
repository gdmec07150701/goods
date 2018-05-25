<?php

namespace Seller\Controller;

use Think\Controller;

class LogController extends CommonController
{
    
    public function lst()
    {
        $model = M('log');
        $where['type'] = array('in',['1','2']);
        $this->_list($model, $where);
        $this->display();
    }
    
    public function goBack()
    {
        $res = M('log')->find($_POST['id']);
        if ($res) {
            $good_id = $res['good_id'];
            $num = $res['num'];
            $type = $res['type'];
            $where['id'] = $good_id;
            switch ($type){
                case '1':
                    $stock = M('goods')->where($where)->getField('stock');
                    if($num > $stock){
                        $this->errorAjax('该数据无法回滚，请联系13798143242');
                    }
                    $res = M('goods')->where($where)->setDec('stock',$num);
                    if($res){
                        M('log')->delete($_POST['id']);
                        $this->successAjax('回滚成功');
                    }
                    break;
                case '2':
                    $res = M('goods')->where($where)->setInc('stock',$num);
                    if($res){
                        M('log')->delete($_POST['id']);
                        $this->successAjax('回滚成功');
                    }
                    $this->errorAjax('回滚失败');
                    break;
            }
        }
        
        
    }
}