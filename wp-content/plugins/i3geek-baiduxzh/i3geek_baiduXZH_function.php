<?php
class i3geek_baiduXZH_function{
	const LIMIT = 500;
	const ORIGINAL = 3600;
	public static $success_log;
	public static $fail_log;
	public static function submit_times(){
		$nustr = get_option( 'I3GEEK_XZH_SUBMITNUMBER');
		if(!$nustr){
			return 0;
		}else{
			$arr = explode("|",$nustr);
			$times = 0;
			if (date('Y-m-d') == date('Y-m-d',$arr[0])) {
				$times = (int)$arr[1];
			}
			return $times;
		}
	}
	public static function submit_left(){
		return (self::LIMIT-self::submit_times());
	}
	public static function submit($n){
		$times = self::submit_times() + $n;
		update_option( 'I3GEEK_XZH_SUBMITNUMBER', strtotime('today')."|".$times );
	}
	public static function saveSetting($appid,$token,$types,$auto,$original){
		if(empty($appid) || empty($token)) return;
		$appid = trim($appid);
		$token = trim($token);
		$xzh		= self::save_verify($appid, $token);
		if( $xzh && @$xzh['success_batch']!=1 ){
			set_transient('I3GEEK_XZH_MSG_STATUS', 1, 86400);
			set_transient('I3GEEK_XZH_MSG_CONTENT', 'appid或token错误', 86400);
			return;
		}
		$types = array();$types[] = 'post';//free
		$Settings = array( 
			'Appid'		=> $appid,
			'Token'	=> $token,
			'Types'		=> $types,
			'auto'	=> trim($auto),
			'original'	=> trim($original),
		);
		@update_option('I3GEEK_XZH_SETTING', $Settings);
		set_transient('I3GEEK_XZH_MSG_STATUS', -1, 86400);
		set_transient('I3GEEK_XZH_MSG_CONTENT', '保存成功', 86400);
	}
	public static function submit2baidu($post_ID, $original, $Settings){
		$status = get_post_meta( $post_ID, 'i3geek_xzh_submit', TRUE);
		$post = get_post( $post_ID );
		$type='';
		if($status == 2){
			return;
		}else if($status == 1){
			if( ($original=='1') && (time()-get_post_time('G', true, $post)<self::ORIGINAL) ) $type = 'original';
			else return;
		}else{
			if( date('Y-m-d') == date('Y-m-d',get_post_time('G', true, $post)) ){
	          if( ($original=='1') && (time()-get_post_time('G', true, $post)<self::ORIGINAL) ) $type = 'original';
	          else $type='realtime';
	        }else{
	          $type='batch';
	        }
		}
		self::post2baidu($post_ID,$type,$Settings);
	}
	public static function post2baidu($post_ID, $type, $Settings){
		if( $type=='' ) return;
		$api_url = 'http://data.zz.baidu.com/urls?appid='.$Settings['Appid'].'&token='.$Settings['Token'].'&type='.$type;
      	$response = wp_remote_post($api_url, array(
	        'headers' => array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
	        'timeout' => 10,
	        'sslverify' => false,
	        'blocking'  => true,
	        'body'    => get_permalink($post_ID)
	     ));
	     if ( is_wp_error( $response ) ) {
	        self::write_log('ERROR','01 POST ERROR: '.$response->get_error_message());
	     } else {
	        $type_arr = explode(",",$type);
	        if( is_array($type_arr) ) $type = $type_arr[0];
	        else $type='';
	        $res = json_decode($response['body'], true);
	        if($res['success_'.$type]==1){
	          if($type == 'batch'){
	          	update_post_meta($post_ID, 'i3geek_xzh_submit', '-1');
	          }else{
	            update_post_meta($post_ID, 'i3geek_xzh_submit', '1');
	            if($res['success_original']==1){
	              update_post_meta($post_ID, 'i3geek_xzh_submit', '2'); 
	            }
	            self::submit(1);
	          }
	          self::write_log('SUCCESS',get_permalink($post_ID).'|'.$type.'|'.$res['success_original']);
	        }elseif($res['remain_'.$type]==0){
	          self::write_log('FAIL',get_permalink($post_ID).'|'.$type.'|'.'已达上限');
	        }else{
	          self::write_log('FAIL',get_permalink($post_ID).'|'.$type.'|'.'提交失败');
	        }
	      }
	}
	public static function log_file($type){
		$filename= 'submit_log.txt';
		switch ($type) {
			case 'ERROR':
				$filename= 'i3geek_baiduXZH.error';
				break;
			case 'SUCCESS':
				$filename= 'i3geek_baiduXZH.success';
				break;
			case 'FAIL':
				$filename= 'i3geek_baiduXZH.fail';
				break;
		}
		return dirname(__FILE__).'/log/'.$filename;
	}
	public static function write_log($type,$content){
		$file = self::log_file($type);
		if(is_writable($file)){
	        $handle = @fopen($file,"a");
	        $time = date('y-m-d h:i:s',time());
	        fwrite($handle,$time.'|'.$content."\n");
	        fclose($handle);
	        set_transient('I3GEEK_XZH_LOG_WRITABLE', 0, 3600);
	    }else{
	    	set_transient('I3GEEK_XZH_LOG_WRITABLE', 1, 3600);
	    }
	}
	public static function read_log($type, $n){
		return self::read_file_last(self::log_file($type),$n);
	}
	public static function read_file_last($filename,$n){
	  if(!$fp=@fopen($filename,'r')){
	    return false;
	  }
	  $pos=-2;
	  $eof="";
	  $arr = array();
	  while($n>0){
	    while($eof!="\n"){
	      if(!fseek($fp,$pos,SEEK_END)){
	        $eof=fgetc($fp);
	        $pos--;
	      }else{
	      	$n = 0;
	      	fseek($fp, $pos+1, SEEK_END); 
	        break;
	      }
	    }
	    $arr[] = explode("|",fgets($fp));
	    $eof="";
	    $n--;
	  }
	  return $arr;
	}
	public static function loadLog(){
		self::$success_log = self::read_log('SUCCESS',10);
		self::$fail_log = self::read_log('FAIL',10);
	}
	public static function save_verify($Appid, $Token){
		$baidu_api_url = 'http://data.zz.baidu.com/urls?appid='.$Appid.'&token='.$Token.'&type=batch';
		$response = wp_remote_post($baidu_api_url, array(
			'headers'	=> array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
			'timeout'	=> 10,
			'sslverify'	=> false,
			'blocking'	=> true,
			'body'		=> home_url()
		));
		if(is_array($response) && array_key_exists('body', $response)){
			$data = json_decode( $response['body'], true );
			return $data;
		}else{return FALSE;}
	}
	public static function getNoticeMsg(){
		if( get_transient('I3GEEK_XZH_UPDATE_FLAG')==1 )return get_option( 'I3GEEK_XZH_NOTICE');
		$response = wp_remote_get( 'http://xzh.i3geek.com/baiduXZH.php?url='.home_url(), array('timeout' => 10) );
		if (!is_wp_error($response) && $response['response']['code'] == '200' ){
			$res = json_decode( $response['body'] ,true );
			@update_option('I3GEEK_XZH_NOTICE', $res);
			set_transient('I3GEEK_XZH_UPDATE_FLAG', 1, 10800);
			return $res;
		}else{
			@update_option('I3GEEK_XZH_NOTICE', '');
			return '';
		}
		
	}
}
?>
