<?php add_action( 'wp_enqueue_scripts', 'vdperanto_theme_css',999);
	function vdperanto_theme_css() {
	wp_enqueue_style( 'vdperanto-parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'vdperanto-child-style', get_stylesheet_uri(), array( 'vdperanto-parent-style' ) );
    wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'custom-style-css', get_stylesheet_directory_uri()."/css/custom.css" );
	wp_dequeue_style( 'custom-css', get_template_directory_uri() .'/css/custom.css');	
}

add_action( 'after_setup_theme', 'vdperanto' );
function vdperanto()
{	
	load_theme_textdomain( 'vdperanto', get_stylesheet_directory() . '/languages' );
	
	require( get_stylesheet_directory() . '/functions/customizer/custo_general_settings.php' );
}


function vdperanto_default_data(){
	return array(
	// general settings
	'footer_copyright_text' => '<p>'.__( '<a href="https://wordpress.org">Proudly powered by WordPress</a> | Theme: <a href="https://webriti.com" rel="designer">vdperanto</a> by Webriti', 'vdperanto' ).'</p>',
	);
}

//WordPress百度主动推送功能
// add_action('save_post', 'fanly_save_post_notify_baidu_zz', 10, 3);
// function fanly_save_post_notify_baidu_zz($post_id, $post, $update){
// 	$baidu_zz_api_url = ' http://data.zz.baidu.com/urls?site=www.gz-guangjian.com&token=en3QsdnDNG835quq';
// 	$response = wp_remote_post($baidu_zz_api_url, array(
// 		'headers' => array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
// 	 	'sslverify' => false,
// 		'blocking' => false,
// 		'body' => get_permalink($post_id)
// 	));
// }

/**
* WordPress发布文章主动推送到百度，加快收录保护原创【WordPress通用方式】
*/
if(!function_exists('Baidu_Submit')){
    function Baidu_Submit($post_ID) {
        $WEB_TOKEN  = 'en3QsdnDNG835quq';  //这里请换成你的网站的百度主动推送的token值
        $WEB_DOMAIN = get_option('home');
        //已成功推送的文章不再推送
        if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?site='.$WEB_DOMAIN.'&token='.$WEB_TOKEN;
        $request = new WP_Http;
        $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
        $result = json_decode($result['body'],true);
        //如果推送成功则在文章新增自定义栏目Baidusubmit，值为1
        if (array_key_exists('success',$result)) {
            add_post_meta($post_ID, 'Baidusubmit', 1, true);
        }
    }
    add_action('publish_post', 'Baidu_Submit', 0);
}

//显示文章是否被百度收录
function checkBaidu($url) { 
    $url = 'http://www.baidu.com/s?wd=' . urlencode($url); 
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    $rs = curl_exec($curl); 
    curl_close($curl); 
    if (!strpos($rs, '没有找到')) { //没有找到说明已被百度收录 
        return '百度已收录'; 
    } else { 
        return '百度未收录'; 
    } 
}

/**
*  WordPress API 方式自动推送到百度熊掌号*
*/
if(!function_exists('Baidu_XZH_Submit')){
    function Baidu_XZH_Submit($post_ID) {
        //已成功推送的文章不再推送
        if(get_post_meta($post_ID,'BaiduXZHsubmit',true) == 1) return;
        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?appid=1603214234273922&token=T7p3Oq3WGgRO4N5X&type=realtime';
        $request = new WP_Http;
        $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
        $result = json_decode($result['body'],true);
        //如果推送成功则在文章新增自定义栏目BaiduXZHsubmit，值为1
        if (array_key_exists('success_realtime',$result)) {
				 if ($result['success_realtime'] > 0) {
					add_post_meta($post_ID, 'Baidu_XZH_Submit', 1, true); 
				 }else{
					 add_post_meta($post_ID, 'Baidu_XZH_Submit', 0, true); 
				 }
        }else{
			add_post_meta($post_ID, 'Baidu_XZH_Submit', 0, true); 
		}
    }
    add_action('publish_post', 'Baidu_XZH_Submit', 0);
}


?>