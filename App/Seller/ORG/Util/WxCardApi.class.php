<?php

class WxCardAuthV2 {
     public $access_token;
     public $host = "https://api.weixin.qq.com/card/";
     public $timeout = 30;
     public $connecttimeout = 30;
     public $ssl_verifypeer = FALSE;
     public $format = '?';
     public $decode_json = TRUE;
     public $http_info;
     public static $boundary = '';
     function __construct($access_token = NULL) {
          $this->access_token = $access_token;
     }
     function base64decode($str) {
          return base64_decode(strtr($str.str_repeat('=', (4 - strlen($str) % 4)), '-_', '+/'));
     }
     /**
     * GET wrappwer for oAuthRequest.
     *
     * @return mixed
     */
     function get($url, $parameters = array()) {
		 $this->host="https://api.weixin.qq.com/card/";
		 if($url=="token")$this->host="https://api.weixin.qq.com/cgi-bin/";
          $response = $this->oAuthRequest($url, 'GET', $parameters);
          if ($this->format === '?' && $this->decode_json) {
               return json_decode($response, true);
          }
          return $response;
     }
	  function getOld($url, $parameters = array()) {
          $response = $this->oAuthRequest($url, 'GET', $parameters);
          if ($this->format === '?' && $this->decode_json) {
               return json_decode($response, true);
          }
          return $response;
     }

     /**
     * POST wreapper for oAuthRequest.
     *
     * @return mixed
     */
     function post($url, $parameters = array(), $multi = false) {
          $response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
          if ($this->format === '?' && $this->decode_json) {
               return json_decode($response, true);
          }
          return $response;
     }

     /**
     * DELTE wrapper for oAuthReqeust.
     *
     * @return mixed
     */
     function delete($url, $parameters = array()) {
          $response = $this->oAuthRequest($url, 'DELETE', $parameters);
          if ($this->format === 'json' && $this->decode_json) {
               return json_decode($response, true);
          }
          return $response;
     }

     /**
     * Format and sign an OAuth / API request
     *
     * @return string
     * @ignore
     */
     function oAuthRequest($url, $method, $parameters, $multi = false) {

          if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
               $url = "{$this->host}{$url}{$this->format}"."access_token=".$this->access_token;
     }

     switch ($method) {
          case 'GET':
               $url = $url . '&' . http_build_query($parameters);
               return $this->http($url, 'GET');
          default:
               $headers = array();
               if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
                    $body = $this->ch_json_encode($parameters);
               } else {
                    $body = self::build_http_query_multi($parameters);
                    $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
               }
               return $this->http($url, $method, $body, $headers);
     }
     }

     /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
     function http($url, $method, $postfields = NULL, $headers = array()) {
          $this->http_info = array();
          $ci = curl_init();
          /* Curl settings */
          curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
          curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ci, CURLOPT_ENCODING, "");
          curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
          curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
          curl_setopt($ci, CURLOPT_HEADER, FALSE);

          switch ($method) {
               case 'POST':
                    curl_setopt($ci, CURLOPT_POST, TRUE);
                    if (!empty($postfields)) {
                         curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                         $this->postdata = $postfields;
                    }
                    break;
          }
          curl_setopt($ci, CURLOPT_URL, $url );
          curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
          curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
          $response = curl_exec($ci);
          $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
          $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
          $this->url = $url;
          curl_close ($ci);
          return $response;
     }

     /**
     * Get the header info to store.
     *
     * @return int
     * @ignore
     */
     function getHeader($ch, $header) {
          $i = strpos($header, ':');
          if (!empty($i)) {
               $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
               $value = trim(substr($header, $i + 2));
               $this->http_header[$key] = $value;
          }
          return strlen($header);
     }

     /**
     * @ignore
     */
     public static function build_http_query_multi($params) {
          if (!$params) return '';

          uksort($params, 'strcmp');

          $pairs = array();

          self::$boundary = $boundary = uniqid('------------------');
          $MPboundary = '--'.$boundary;
          $endMPboundary = $MPboundary. '--';
          $multipartbody = '';

          foreach ($params as $parameter => $value) {

               if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
                    $url = ltrim( $value, '@' );
                    $content = file_get_contents( $url );
                    $array = explode( '?', basename( $url ) );
                    $filename = $array[0];

                    $multipartbody .= $MPboundary . "\r\n";
                    $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
                    $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
                    $multipartbody .= $content. "\r\n";
               } else {
                    $multipartbody .= $MPboundary . "\r\n";
                    $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                    $multipartbody .= $value."\r\n";
               }

          }

          $multipartbody .= $endMPboundary;
          return $multipartbody;
     }
     /**
      * 对数组和标量进行 urlencode 处理
      * 通常调用 wphp_json_encode()
      * 处理 json_encode 中文显示问题
      * @param array $data
      * @return string
      */
     function wphp_urlencode($data) {
     	if (is_array($data) || is_object($data)) {
     		foreach ($data as $k => $v) {
     			if (is_scalar($v)) {
     				if (is_array($data)) {
						if(is_string($v))$data[$k] = urlencode($v);
						if(!is_string($v))$data[$k] = $v;
     				} else if (is_object($data)) {
						if(is_string($v))$data->$k = urlencode($v);
						if(!is_string($v))$data->$k =$v;
     					
     				}
     			} else if (is_array($data)) {
     				$data[$k] = $this->wphp_urlencode($v); //递归调用该函数
     			} else if (is_object($data)) {
     				$data->$k = $this->wphp_urlencode($v);
     			}
     		}
     	}
     	return $data;
     }
     /**
      * json 编码
      *
      * 解决中文经过 json_encode() 处理后显示不直观的情况
      * 如默认会将“中文”变成"\u4e2d\u6587"，不直观
      * 如无特殊需求，并不建议使用该函数，直接使用 json_encode 更好，省资源
      * json_encode() 的参数编码格式为 UTF-8 时方可正常工作
      *
      * @param array|object $data
      * @return array|object
      */
     public function ch_json_encode($data) {
     	$ret = $this->wphp_urlencode($data);
     	$ret = json_encode($ret);
     	return urldecode($ret);
     }
}

class WxCardApi
{
	 var $oauth;  
     var $access_token;

     /**
     * 构造函数
     *
     * @access public
     * @param mixed $access_token OAuth认证返回的token
     * @return void
     */
     function __construct($app_id,$app_secret)
     {
		  $this->access_token_get($app_id,$app_secret);
		  $this->oauth = new WxCardAuthV2($this->access_token);
     }

	 /**
      * 获取access_token  API：http://mp.weixin.qq.com/wiki/index.php?title=%E8%8E%B7%E5%8F%96access_token
      * 
     */
     function access_token_get($app_id,$app_secret)
     {
		 
         
		 //先检查缓存中的access_token时间，如果超过60分钟，就获取新的。
		  $access_token_cache=F('WxApi/chk_'.$app_id.'_'.$app_secret);
		  if($access_token_cache){
			$time=abs(time()-($access_token_cache["time"]+0));
			if($time<=60*90){
					$this->access_token=$access_token_cache["access_token"];
					return;
				}
		  }
		   
		  $params = array();
		  $params['grant_type'] = "client_credential";
		  $params['appid'] = $app_id;
		  $params['secret'] = $app_secret;
		  $oauth = new WxCardAuthV2("");
          $data=$oauth->get('token', $params);
		  if($data['access_token']){
			  $access_token_cache=array("access_token"=>$data['access_token'],"time"=>time());
			  F('WxApi/chk_'.$app_id.'_'.$app_secret,$access_token_cache);
			  $this->access_token=$access_token_cache["access_token"];
		  }
		  return;
     }



 /*******************************************************
         *      微信卡券：获取颜色
         *******************************************************/
        function getcolors(){
            $params = array();
			return $this->oauth->get('getcolors', $params);
        }
		function testwhitelist($openid){
            $params = array("");
     		$params['openid']=$openid;
			return $this->oauth->post('testwhitelist/set', $params);
        }
		function card_delete($card_id){
            $params = array("");
     		$params['card_id']=$card_id;
			return $this->oauth->post('delete', $params);
        }

		function card_create($params){
			return $this->oauth->post('create', $params);
        }
		function card_update($params){
			return $this->oauth->post('update', $params);
        }
		function card_modifystock($params){
			return $this->oauth->post('modifystock', $params);
        }
		function card_code_update($params){
			return $this->oauth->post('code/update', $params);
        }
		function card_code_decrypt($params){
			return $this->oauth->post('code/decrypt', $params);
        }
		function card_code_consume($params){
			return $this->oauth->post('code/consume', $params);
        }
		
}
