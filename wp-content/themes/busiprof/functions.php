<?php 

	/**Includes reqired resources here**/
	define('BUSI_TEMPLATE_DIR_URI',get_template_directory_uri());
	define('BUSI_TEMPLATE_DIR',get_template_directory());
	define('BUSI_THEME_FUNCTIONS_PATH',BUSI_TEMPLATE_DIR.'/functions');

	require_once('theme_setup_data.php');

	//Files for custom - defaults menus
	require( BUSI_THEME_FUNCTIONS_PATH . '/menu/busiprof_nav_walker.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/menu/default_menu_walker.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/woo/woocommerce.php' );
	require( BUSI_THEME_FUNCTIONS_PATH .'/font/font.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/breadcrumbs/breadcrumbs.php');


	// Theme functions file including
	require( BUSI_THEME_FUNCTIONS_PATH . '/scripts/script.php');
	require( BUSI_THEME_FUNCTIONS_PATH . '/widgets/custom-widgets.php' ); // for footer widget
	require( BUSI_THEME_FUNCTIONS_PATH . '/commentbox/comment-function.php' ); // for custom contact widget

	// customizer files include
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_general_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_sections_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_template_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_post_slugs_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_layout_manager_settings.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/cust_pro.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/custo_emailcourse.php' );
	require( BUSI_THEME_FUNCTIONS_PATH . '/customizer/customizer.php' );
	
	
	//theme ckeck plugin required 	
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('woocommerce');
	
	//content width
	if ( ! isset( $content_width ) ) $content_width = 750;	


	if ( ! function_exists( 'busiporf_setup' ) ) :
	function busiporf_setup() {
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'busiprof', get_template_directory() . '/lang' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	
	// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	/*
	 * Let WordPress manage the document title.
	 * 增加头部标题功能
	 */
	//add_theme_support( 'title-tag' );
	
	// supports featured image
	add_theme_support( 'post-thumbnails' );
	
		
	add_theme_support( 'custom-header');
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'busiprof' )
	) );
	
	
} // busiporf_setup
endif;
	
	add_action( 'after_setup_theme', 'busiporf_setup' );
	
	
	function busiprof_inline_style() {
	$custom_css              = '';
	
	
	$busiprof_service_content = get_theme_mod(
		'busiprof_service_content', json_encode(
			array(
				array(
					'color'      => '#e91e63',
				),
				array(
					'color'      => '#00bcd4',
				),
				array(
					'color'      => '#4caf50',
				),
			)
		)
	);
	
	if ( ! empty( $busiprof_service_content ) ) {
		$busiprof_service_content = json_decode( $busiprof_service_content );
		
		
		foreach ( $busiprof_service_content as $key => $features_item ) {
			$box_nb = $key + 1;
			if ( ! empty( $features_item->color ) ) {
				
				$color = ! empty( $features_item->color ) ? apply_filters( 'busiprof_translate_single_string', $features_item->color, 'Features section' ) : '';
				
				$custom_css .= '.service-box:nth-child(' . esc_attr( $box_nb ) . ') .service-icon {
                            color: ' . esc_attr( $color ) . ';
				}';
				
				
			}
		}
	}
	wp_add_inline_style( 'style', $custom_css );
}

add_action( 'wp_enqueue_scripts', 'busiprof_inline_style' );

//百度站长的 JS 代码实现自动推送
// add_action( 'wp_enqueue_scripts', 'fanly_baidu_zz_enqueue_scripts' );
// function fanly_baidu_zz_enqueue_scripts(){
//   wp_enqueue_script( 'baidu_zz_push', 'http://push.zhanzhang.baidu.com/push.js');
// }

//WordPress百度主动推送功能
// add_action('save_post', 'fanly_save_post_notify_baidu_zz', 10, 3);
// function fanly_save_post_notify_baidu_zz($post_id, $post, $update){
// 	if($post->post_status != 'publish') {
// 		return;	
// 	}else{
// 		$baidu_zz_api_url = 'http://data.zz.baidu.com/urls?site=your_site_url&token=your_token';
// 	 //请到百度站长后台获取你的站点的专属提交链接
// 		 $response = wp_remote_post($baidu_zz_api_url, array(
// 		  'headers' => array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
// 		  'sslverify' => false,
// 		  'blocking' => false,
// 		  'body' => get_permalink($post_id)
// 		 ));
// 	}
// }


//删除wp_head()中的title标签
// remove_action( 'wp_head', '_wp_render_title_tag', 1 );
// add_filter( 'get_the_archive_title', function ($title) {

// if ( is_category() ) {

//         $title = single_cat_title( '', false );

//     } elseif ( is_tag() ) {

//         $title = single_tag_title( '', false );

//     } elseif ( is_author() ) {

//         $title = '<span class="vcard">' . get_the_author() . '</span>' ;

//     }

// return $title;

// });


?>