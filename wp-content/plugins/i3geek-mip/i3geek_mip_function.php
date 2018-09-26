<?php
if ( function_exists('add_theme_support') ){
	add_theme_support('post-thumbnails');
}
class i3geek_mip_function{

	public static function get_images_url( $file ) {
		return plugins_url( sprintf( 'images/%s', $file ), I3GEEK_MIP__FILE__ );
	}
	public static function get_template_path( $file ) {
		return I3GEEK_MIP__DIR__ .sprintf( '/template/%s', $file );
	}
	public static function get_logo_url( ) {
		$mip_logo = i3geek_mip_admin::get_option('mip_logo',"");
		if( empty($mip_logo) )
			return self::get_images_url("mip-logo.png");
		return $mip_logo;
	}
	public static function is_mip_endpoint() {
		if ( 0 === did_action( 'parse_query' ) ) {
			return false;
		}
		return false !== get_query_var( I3GEEK_MIP_QUERY_VAR, false );
	}
	public static function get_builtin_supported_post_types() {
		return array_filter( array( 'post' ), 'post_type_exists' );
	}
	public static function get_eligible_post_types() {
		return array_merge(
			self::get_builtin_supported_post_types(),
			array( 'page' ),
			array_values( get_post_types(
				array(
					'public'   => true,
					'_builtin' => false,
				),
				'names'
			) )
		);
	}
	public static function add_post_type_support() {
		$post_types = array_merge(
			self::get_builtin_supported_post_types(),
			i3geek_mip_admin::get_option( 'supported_post_types', array() )
		);
		foreach ( $post_types as $post_type ) {
			add_post_type_support( $post_type, I3GEEK_MIP_QUERY_VAR );
		}
	}
	public static function get_support_errors( $post ) {
		if ( ! ( $post instanceof WP_Post ) ) {
			$post = get_post( $post );
		}
		$errors = array();
		if ( ! post_type_supports( $post->post_type, I3GEEK_MIP_QUERY_VAR ) ) {
			$errors[] = 'post-type-support';
		}
		if ( post_password_required( $post ) ) {
			$errors[] = 'password-protected';
		}
		return $errors;
	}
	public static function post_supports_mip( $post ) {
		$errors = self::get_support_errors( $post );
		if ( ! empty( $errors ) ) return false;
		return true;
	}
	public static function get_option($force = false){
		if( !$force && get_transient('I3GEEK_MIP_UPDATE_FLAG')==1 )return get_option( 'I3GEEK_MIP_NOTICE');
		$response = wp_remote_get( 'http://mip.i3geek.com/mip.php?url='.home_url(), array('timeout' => 10) );
		if (!is_wp_error($response) && $response['response']['code'] == '200' ){
			$res = json_decode( $response['body'] ,true );
			@update_option('I3GEEK_MIP_NOTICE', $res);
			set_transient('I3GEEK_MIP_UPDATE_FLAG', 1, 10000);
			return $res;
		}else{
			@update_option('I3GEEK_MIP_NOTICE', '');
			return '';
		}
	}
	public static function get_mip_url($post_id){
		global $wp;
		$structure  = get_option( 'permalink_structure' );
		if(!is_singular()){
			$current_url= home_url(add_query_arg(array(),$wp->request));
			if(empty($structure) || ! empty( $parsed_url['query'] ) )
				$mip_url = add_query_arg( I3GEEK_MIP_QUERY_VAR, '', $current_url );
			else
				$mip_url = trailingslashit( $current_url ) . user_trailingslashit( I3GEEK_MIP_QUERY_VAR, 'imp' );
		}else{
			$parsed_url = wp_parse_url( get_permalink( $post_id ) );
			if ( empty( $structure ) || ! empty( $parsed_url['query'] ) || is_post_type_hierarchical( get_post_type( $post_id ) ) ) {
			  $mip_url = add_query_arg( I3GEEK_MIP_QUERY_VAR, '', get_permalink( $post_id ) );
			} else {
			  $mip_url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( I3GEEK_MIP_QUERY_VAR, 'imp' );
			}
		}
	  	return $mip_url;
	}
	public static function get_h5_url($post_id){
		global $wp;
		$current_url= home_url(add_query_arg(array(),$wp->request));
		$structure  = get_option( 'permalink_structure' );
		if(!is_singular()){
			if(empty($structure) || ! empty( $parsed_url['query'] ) )
				$h5_url = add_query_arg( I3GEEK_MIP_QUERY_VAR, false, $current_url );
			else
				$h5_url = preg_replace("/\/mip(\/)?/","/",$current_url);
			return $h5_url;
		}else{
			return get_permalink( $post_id );
		}
	}
	public static function auto_add_url_parse( $content ) {
		$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
		if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
			if( !empty($matches) ) {
				$srcUrl = get_option('siteurl');
				for ($i=0; $i < count($matches); $i++){
					$tag = $matches[$i][0];	$tag2 = $matches[$i][0];$url = $matches[$i][0];
					$noFollow = '';	$pattern = '/target\s*=\s*"\s*_blank\s*"/';
					preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
					if( count($match) < 1 )	$noFollow .= ' target="_blank" ';
					else $target = '';	 
					$pattern = '/rel\s*=\s*"\s*[n|d]ofollow\s*"/';
					preg_match($pattern, $tag2, $match, PREG_OFFSET_CAPTURE);
					if( count($match) < 1 )	$noFollow .= ' rel="nofollow" ';
					elseif($noFollow =='')	$noFollow .= '';
					$pos = strpos($url,$srcUrl);
					if ($pos === false) {$tag = rtrim ($tag,'>');$tag .= $noFollow.'>';
						$content = str_replace($tag2,$tag,$content);
					}elseif($target!==''){$tag = rtrim ($tag,'>');$tag .= ' target="_blank">';
						$content = str_replace($tag2,$tag,$content);}
				}
			}
		}
		$content = str_replace(']]>', ']]>', $content);
		return $content;
	}
	public static function mip_reform($content){
		require_once (I3GEEK_MIP__DIR__.'/i3geek_mip_standard.php');
		$standard = new i3geek_mip_standard();
		return $standard->reform($content);
	}
	public static function mip_reform_link(){
	    function I3geek_mip_link_main ($content){
			preg_match_all('/<a (.*?)\>(.*?)<\/a>/', $content, $links);
			if(!is_null($links)) {
				$siteurl	= get_option('siteurl');
				foreach($links[1] as $index => $value){
					preg_match('/href="(.*)"/', $value, $a);
					if( strpos($a[1],strstr($siteurl, '//')) ){
						$mip_link = preg_replace('/ target=\".*?\"/', '',$links[0][$index]);
						$mip_link = preg_replace('/ style=\".*?\"/', '',$mip_link);
						if(!strpos($mip_link,'data-type="mip"')){
							$mip_link = str_replace('<a', '<a data-type="mip"',$mip_link);
						}
						$content = str_replace($links[0][$index], $mip_link, $content);
					}
				}
			}
			return $content;
		}
		ob_start("I3geek_mip_link_main");
	}
	public static function upgrade_ssl(){
		if( is_ssl() ){
			function upgrade_ssl_main ($content){
				$siteurl = get_option('siteurl');
				$upload_dir = wp_upload_dir();
				$content = str_replace( 'http:'.strstr($siteurl, '//'), 'https:'.strstr($siteurl, '//'), $content);
				$content = str_replace( 'http:'.strstr($upload_dir['baseurl'], '//'), 'https:'.strstr($upload_dir['baseurl'], '//'), $content);
				return $content;
			}
			ob_start("upgrade_ssl_main");
		}
	}

}
?>