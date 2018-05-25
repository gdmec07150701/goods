<?php
namespace Think\Template\TagLib;
use Think\Template\TagLib;
class Hd extends TagLib{
	/**
	 * 定义标签列表
	 * @var array
	 */
	protected $tags   =  array(
 		'hd_other'=>array('attr'=>'id,title,data','close' => 0,'level'=>3),//格式化data
		'hd_arc'=>array('attr'=>'arc','level'=>4),
	);
	public function _hd_other($attr,$content) {
    	 //$tag		=	$this->parseXmlAttr($attr,'hd_other');
		 $data		=	!empty($attr['data'])?$attr['data']:'';
		 $tag_id	=	empty($attr['id'])?'hd_other_id':$attr['id'];
         $tag_title	=	empty($attr['title'])?'hd_other_title':$attr['title'];
        $parsestr   = '<?php $c_tag_hd_other = unserialize($'.$data.');';		
		$parsestr  .= '$'.$tag_id.'=array();';		
		$parsestr  .= '$'.$tag_title.'=array();';
		$parsestr  .= 'if(!empty($c_tag_hd_other)&&count($c_tag_hd_other[\'title\'])>0):';
        $parsestr  .= 'foreach($c_tag_hd_other[\'title\'] as $k=>$v):';
        $parsestr  .= '$'.$tag_id.'=array_merge($'.$tag_id.',array("c_".$c_tag_hd_other[\'id\'][$k]=>$c_tag_hd_other[\'sys\'][$k]));';
       $parsestr  .= '$'.$tag_title.'=array_merge($'.$tag_title.',array($c_tag_hd_other[\'title\'][$k]=>$c_tag_hd_other[\'sys\'][$k]));';
        $parsestr .= 'endforeach; endif;';
		$parsestr .= ' ?>';

        $parsestr .= $content;//解析在article标签中的内容
        return  $parsestr;
    }

	public function _hd_arc($attr,$content) {
		 //$tag		=	$this->parseXmlAttr($attr,'hd_arc');
		 $arc		=	!empty($attr['arc'])?$attr['arc']:'';
		$parsestr   = '<?php ';		
		$parsestr  .= '$arc="'.$arc.'";';		
		$parsestr  .= 'if(chkArc($arc)){ ?>';		
		$parsestr  .= $content;		
		$parsestr  .= '<?php }';
		$parsestr .= ' ?>';
         return  $parsestr;
    }


	

}