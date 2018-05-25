<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/14 0014
 * Time: 下午 4:59
 */

namespace Think;

//用户后台获取表格数据
class TableList
{
    static private $_instance = NULL;
    public $data;
    public $count;
    private function __construct(){

    }

    private function __clone(){

    }

    static public function getInstance(){
        if(!self::$_instance instanceof self){
            self::$_instance = new self;
        }else{

        }
        return self::$_instance;
    }

    //查询数据库列表
    public function dataList($table,$field,$where,$p,$psize,$order){
        $this->data=M($table)->where($where)->field($field)->page($p,$psize)->order($order)->select();
        return $this->data;
    }
    public function dataCount($table,$where){
        $this->count=M($table)->where($where)->count();
        return $this->count;
    }
    //数据库插入
    public function dataInsert($table,$data,$where){
        $this->data=M($table)->where($where)->field($field)->add($data);
        return $this->data;
    }
    //数据库字段插入
    public function dataColumn($table,$data,$where,$column){
        $this->data=M($table)->where($where)->setField($column,$data);
    }
}