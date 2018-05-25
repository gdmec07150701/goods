<?php

namespace Seller\Controller;

use Think\Controller;

class CommonController extends Controller
{
    
    protected $_manager;
    
    public function doLog($type, $good_id, $num = '1')
    {
        $data['uid'] = $_SESSION['adminAuthId'];
        $data['good_id'] = $good_id;
        $data['num'] = $num;
        $data['type'] = $type;
        $data['created_at'] = date('Y-m-d H:i:s');
        $add = M('log')->add($data);
        if($add){
            return true;
        }
        return false;
    }
    
    public function successAjax($info)
    {
        $result['status'] = 1;
        $result['info'] = $info;
        $this->ajaxReturn($result);
    }
    
    public function errorAjax($info)
    {
        $result['status'] = 0;
        $result['info'] = $info;
        $this->ajaxReturn($result);
    }
    
    function _initialize()
    {
        //认证登录
        if ('public' != strtolower(CONTROLLER_NAME)) {
            if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
                $this->redirect('Public/login');
            }
        }
        
        $this->_manager = @$_SESSION[C('USER_AUTH_INFO')];
        $this->assign('app_manager', $this->_manager);
        $head = "http://" . $_SERVER['HTTP_HOST'] . C('MY_APP_NAME');
        $this->assign('head', $head);
        
    }
    
    
    protected function _empty($name)
    {
        $this->index();
    }
    
    
    public function writeLog($type = "", $memo = "", $sql = "", $id = 0)
    {
        //写LOG
        $uid = isset($_SESSION[C('USER_AUTH_KEY')]) ? $_SESSION[C('USER_AUTH_KEY')] : 0;
        //$uid=isset($_SESSION['SID'])?$_SESSION['SID']:0;
        $type = empty($type) ? strtolower(MODULE_NAME) . "_" . strtolower(ACTION_NAME) : $type;
        $data['module_name'] = strtolower(MODULE_NAME);
        $data['action_name'] = strtolower(ACTION_NAME);
        $data['action_id'] = $id;
        $data['type'] = $type;
        $data['ipaddress'] = get_client_ip();
        $data['uid'] = $uid;
        $data['memo'] = $memo;
        $data['sql_content'] = $sql;
        $data['create_time'] = date('Y-m-d H:i:s', time());
        $managersLog = M('ManagersLog');
        $managersLog->create($data);
        if ($managersLog->add()) return true;
        return false;
    }
    
    /**
     * +----------------------------------------------------------
     * 取得操作成功后要返回的URL地址
     * 默认返回当前模块的默认操作
     * 可以在action控制器中重载
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return string
     * +----------------------------------------------------------
     * @throws ThinkExecption
     * +----------------------------------------------------------
     */
    function getReturnUrl($cookie = true)
    {
        if ($cookie && cookie('_currentAdminUrl_')) return cookie('_currentAdminUrl_');
        return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
    }
    
    /**
     * +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param string $name 数据对象名称
     * +----------------------------------------------------------
     * @return HashMap
     * +----------------------------------------------------------
     * @throws ThinkExecption
     * +----------------------------------------------------------
     */
    protected function _search($name = '')
    {
        //生成查询条件
        if (empty($name)) {
            $name = $this->getActionName();
        }
        // $name = $this->getActionName();
        $model = D($name);
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $map [$val] = $_REQUEST [$val];
            }
        }
        return $map;
    }
    
    /**
     * +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * +----------------------------------------------------------
     * @return void
     * +----------------------------------------------------------
     * @throws ThinkExecption
     * +----------------------------------------------------------
     */
    protected function _list($model, $map, $sortBy = '', $asc = false)
    {
        //排序字段 默认为主键名
        if (isset($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        //取得满足条件的记录数
        $count = $model->where($map)->count('id');
        if ($count > 0) {
            import("@.ORG.Util.Page");
            //创建分页对象
            if (!empty($_REQUEST ['listRows'])) {
                $listRows = $_REQUEST ['listRows'];
            } else {
                $listRows = '';
            }
            $p = new \Page($count, $listRows);
            //分页查询数据
            $order_sql = "`" . $order . "` " . $sort;
            if (strpos($order, ",") > 1) $order_sql = $order;
            $voList = $model->where($map)->order($order_sql)->limit($p->firstRow . ',' . $p->listRows)->select();
            //echo $model->getlastsql();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "&$key=" . urlencode($val) . "&";
                }
            }
            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        cookie('_currentAdminUrl_', __SELF__);
        return;
    }
    
    function getNumber($object)
    {
        
        //获取订单号 时间+序号 如：201704050001
        $tomorrow = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));
        $yesterday = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        
        //条件
        $map['create_time'] = array(array('gt', $yesterday), array('lt', $tomorrow));
        
        //统计今日订单的条数
        $todayCount = $object->where($map)->field('count(id)')->getField('count(id)');
        //获取前四位【年月日】
        $today = date('Ymd', time());
        $todayCount = $todayCount + 1;
        //如果大于9999
        if ($todayCount > 9999) {
            $todayCount = $todayCount;
        } else {
            //如果小于9999
            $todayCount = str_pad($todayCount, 4, "0", STR_PAD_LEFT);
        }
        
        //订单号
        $order_number = $today . $todayCount;
        
        return $order_number;
    }
    
    /**
     * 邮件发送函数
     */
    function sendMail($to, $title, $content)
    {
        
        // Vendor('Vendor.PHPMailer.PHPMailerAutoload'); 
        // Vendor('PHPMailer.PHPMailerAutoload');
        vendor('PHPMailer.class#phpmailer');
        vendor('PHPMailer.class#smtp');
        
        // import('Vendor.PHPMailer.class.phpmailer');     
        // Load('Vender');  
        $mail = new \PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->SMTPAuth = true;                  // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';                 // 使用安全协议
        // $mail->SMTPDebug  = 1;    调试的时候可以设置为1
        $mail->Host = C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->Port = C('SMTP_PORT');  // SMTP服务器的端口号
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD'); //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to, "尊敬的客户");
        $mail->WordWrap = 50; //设置每行字符长度
        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet = C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject = $title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        echo '66';
        return ($mail->Send());
        
    }
    
    
    
    //判断是否锁定
    // function check($id,$model){
    // 	$res = $model -> where('id='.$id) -> find();
    // 	$admin = getAdmin($res['act_id']);
    // 	//锁定状态--提醒
    // 	if($res['act_status'] == 0){
    // 		if($res['act_id'] !=$_SESSION[C('USER_AUTH_KEY')]) $this->error($admin.'正在操作，已被锁定！');
    // 	}else{
    // 		$data['action_id'] = $_SESSION[C('USER_AUTH_KEY')];
    // 		$data['act_status'] = 0;
    // 		$res = $model -> where('id='.$id) -> save($data);
    // 	}
    // }
    
    // //解除锁定
    // function remove($id,$model){
    // 	//获取订单
    // 	$data = $model -> where('id='.$id) -> find();
    // 	if(empty($data)) exit;
    // 	if(($data['act_id'] != '') || ($data['act_status'] != 1)){
    // 		$info['act_id'] = '';
    // 		$info['act_status'] = 1;
    // 		$res = $model -> where('id='.$id) -> save($info);
    // 	}
    // }
    
    
}