<?php

namespace Seller\Controller;

use Think\Controller;

class GoodsController extends CommonController
{
    function _initialize()
    {
        //获取类别
        $sorts = M('sort')->select();
        $this->assign('sorts', $sorts);
    }
    
    //导入excel
    public function lst()
    {
        /*
            判断是否有文件过来 file_stu是表单中对应的name值
        */
        if (!empty ($_FILES ['file_stu'] ['name'])) {
            
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode(".", $_FILES ['file_stu'] ['name']);
            $file_type = $file_types [count($file_types) - 1];
            
            
            /*判别是不是.xls文件，判别是不是excel文件*/
            if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                
                $this->error('不是Excel文件，重新上传');
            }
            /*这里是用了ThinkPHP3.2.3的上传类*/
            
            $config = array(
                'exts' => array('xlsx', 'xls'),
                'maxSize' => 3145728000,
                'rootPath' => "./Public/", //上传的主目录
                'savePath' => 'Uploads/',   //上传的子目录
                'subName' => array('date', 'Ymd'), //子子目录
            );
            $upload = new \Think\Upload($config);
            //这面这一句是设置上传的文件名 pathinfo函数也可以了解一下
            // $upload ->saveName  =  $file_types [count ( $file_types ) - 2];
            if (!$info = $upload->upload()) {
                $this->error($upload->getError());
            }
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
                // $this->success('上传成功！');
            }
            
            /*
                这里引入PHPExcel类
            */
            vendor("PHPExcel.PHPExcel");
            /*
              获取文件地址
            */
            $file_name = $upload->rootPath . $info['file_stu']['savepath'] . $info['file_stu']['savename'];
            
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            //判断导入表格后缀格式 采用不同的加载方式
            if ($extension == 'xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
                $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            } else if ($extension == 'xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
            }
            /*
                获取Excel的内容
            */
            $sheet = $objPHPExcel->getSheet(0);
            $row = $sheet->getHighestRow();//取得总行数
            $column = $sheet->getHighestColumn(); //取得总列数
            for ($i = 1; $i <= $row; $i++) {
                //看这里看这里,前面小写的k是表中的字段名，后面的大写A是excel中位置
                $data['k'] = $objPHPExcel->getActiveSheet()->getCell("A" . $i)->getValue();
                $data['v'] = $objPHPExcel->getActiveSheet()->getCell("B" . $i)->getValue();
                //kv是数据库中的表
                $add = M('kv')->add($data);
            }
        }
        $model = M('goods');
        $this->_list($model, '');
        $this->display();
    }
    
    
    //导出excel
    
    public function exportExcel()
    {
        
        vendor('PHPExcel.PHPExcel');
        
        $objPHPExcel = new \PHPExcel();        //这里要注意‘\’ 要有这个。因为版本是3.1.2了。
        
        $objDrawing = new \PHPExcel_Worksheet_Drawing();
        
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);   //设置保存版本格式
        
        //接下来就是写数据到表格里面去
        
        $user = M('kv');
        
        $list = $user->order('id desc')->select();
        
        foreach ($list as $key => $value) {
            
            $i = $key + 1;//表格是从1开始的
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['k']);
            //这里是设置A1单元格的内容
            
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['v']);
            ////这里是设置B1单元格的内容
            
            
        }
        
        //接下来当然是下载这个表格了，在浏览器输出就好了
        ob_end_clean();//清除缓冲区,避免乱码  还有一个导出报错的是版本低的问题，可以删掉对应那行的break即可
        header("Pragma: public");
        
        header("Expires: 0");
        
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        
        header("Content-Type:application/force-download");
        
        header("Content-Type:application/vnd.ms-execl");
        
        header("Content-Type:application/octet-stream");
        
        header("Content-Type:application/download");;
        
        header('Content-Disposition:attachment;filename=' . date('YmdHis') . '.xls');
        
        header("Content-Transfer-Encoding:binary");
        header("Content-type:application/vnd.ms-excel");
        
        $objWriter->save(date('YmdHis') . '.xls');
        
        $objWriter->save('php://output');
        
        
    }
    
    public function add()
    {
        
        if ($_POST['id']) {
            $_POST['updated_at'] = date('Y-m-d H:i:s');
            $res = M('goods')->save($_POST);
            if ($res) {
                $this->success('修改商品成功');
            }
            $this->error('修改商品失败');
        }
        if ($_POST) {
            $_POST['updated_at'] = $_POST['created_at'] = date('Y-m-d H:i:s');
            $res = M('goods')->add($_POST);
            if ($res) {
                $logRes = $this->doLog('3', $res, $_POST['stock']);
                if ($logRes) {
                    $this->successAjax('新增商品成功');
                }
                $this->successAjax('日志写入失败，请马上联系13798143242');
            }
            $this->errorAjax('新增商品失败');
        }
        $this->display();
//
    }
    
    public function edit()
    {
        $res = M('goods')->find($_GET['id']);
        $this->assign('vo', $res);
        $this->display('add');
    }
    
    public function del()
    {
        if ($_POST['id']) {
            $res = M('goods')->delete($_POST['id']);
        }
        if ($res) {
            $this->successAjax('成功删除');
        }
        $this->errorAjax('删除失败');
        
    }
    
    public function saveStock()
    {
        $goods = M('goods');
        //进货操作
        $num = $_POST['num'];
        $type = $_POST['type'];
        $id = $_POST['id'];
        if ($num < 1) {
            $this->errorAjax('数值问题');
        }
        $where['id'] = $id;
        if ($type == '1') {
            $res = $goods->where($where)->setInc('stock', $num);
            $logRes = $this->doLog($type, $id, $num);
            if ($res && $logRes) {
                $this->successAjax('成功进库');
            }
            $this->errorAjax('进库失败');
        } elseif ($type == '2') {
            $res = $goods->where($where)->setDec('stock', $num);
            $logRes = $this->doLog($type, $id, $num);
            if ($res && $logRes) {
                $this->successAjax('成功出库');
            }
            $this->errorAjax('出库失败');
        }
        
    }
    
    public function changeStock()
    {
        
        if ($_POST['act'] == 'plus') {
            $where['id'] = $_POST['id'];
            $res = M('goods')->where($where)->setInc('stock', 1);
            if ($res) {
                $this->successAjax('更新库存成功');
            }
            $this->errorAjax('更新库存失败');
        }
        if ($_POST['act'] == 'minus') {
            $where['id'] = $_POST['id'];
            $stock = M('goods')->where($where)->getField('stock');
            if ($stock < 1) {
                $this->errorAjax('库存小于0');
            }
            $res = M('goods')->where($where)->setDec('stock', 1);
            if ($res) {
                $this->successAjax('更新库存成功');
            }
            $this->errorAjax('更新库存失败');
        }
    }
}