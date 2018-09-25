<?php
require get_template_directory() . '/inc/helper.php';

add_filter('acf/settings/path', 'my_acf_settings_path');
 
function my_acf_settings_path( $path ) {
    $path = get_stylesheet_directory() . '/acf/';
    return $path;
    
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
    $dir = get_stylesheet_directory_uri() . '/acf/';
    return $dir;
    
}


add_action( 'init', 'cptui_register_my_cpts_product' );
function cptui_register_my_cpts_product() {
	$labels = array(
		"name" => __( '产品', 'xs' ),
		"singular_name" => __( '产品列表', 'xs' ),
		'add_new'            => _x( '新建产品', '添加新内容的链接名称' ),
		'add_new_item'       => __( '新建一个产品' ),
		'edit_item'          => __( '编辑产品' ),
		'new_item'           => __( '新产品' ),
		'all_items'          => __( '所有产品' ),
		);

	$args = array(
		"label" => __( '产品', 'xs' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "product", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 5,
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes" ),		
		"taxonomies" => array(  ),
			);
	register_post_type( "product", $args );

// End of cptui_register_my_cpts_product()
}
add_action( 'init', 'cptui_register_my_taxes_products' );
function cptui_register_my_taxes_products() {
	$labels = array(
		"name" => __( '产品分类', 'xs' ),
		"singular_name" => __( '产品分类', 'xs' ),
		);

	$args = array(
		"label" => __( '产品分类', 'xs' ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "产品分类",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'products', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"show_in_quick_edit" => true,
	);
	register_taxonomy( "products", array( "product" ), $args );

}
add_filter('manage_product_posts_columns', 'add_new_product_columns');   
  
function add_new_product_columns($book_columns) {   
       
    $new_columns['cb'] = '<input type="checkbox" />';//这个是前面那个选框，不要丢了   
	$new_columns['id'] = __('ID');   
    $new_columns['title'] = '产品名称';   
    $new_columns['images'] = __('缩略图');   
       
    $new_columns['products'] =__('产品分类');    
    
    $new_columns['date'] = _x('Date', 'column name');   
  
    //直接返回一个新的数组   
    return $new_columns;   
}
add_action('manage_product_posts_custom_column', 'manage_product_columns', 10, 2);   
    
function manage_product_columns($column_name, $id) {   
    global $wpdb;   
    switch ($column_name) {   
    case 'id':   
        echo $id;   
        break;  
   case 'images':   
         echo the_post_thumbnail( array(125,80) );  
        break;  		
case 'products':
 echo get_the_term_list($post->ID,'products');
      break;
    
    default:   
        break;   
    }   
} 
 add_filter( 'manage_edit-product_sortable_columns', 'my_post_sortable_columns' );
function my_post_sortable_columns( $columns ) {
    $columns['products'] = '产品分类';
    return $columns;
}
function wpdaxue_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo'); //移除Logo
   //$wp_admin_bar->remove_menu('my-account'); //移除个人中心
    $wp_admin_bar->remove_menu('comments'); //移除评论
    $wp_admin_bar->remove_menu('my-sites');  //移除我的网站(多站点)
   // $wp_admin_bar->remove_menu('site-name'); //移除网站名称
    $wp_admin_bar->remove_menu('new-content'); // 移除“新建”
    $wp_admin_bar->remove_menu('search');  //移除搜索
    //$wp_admin_bar->remove_menu('updates'); //移除升级通知

}
add_action( 'wp_before_admin_bar_render', 'wpdaxue_admin_bar' );



// 跳转到设置
if (is_admin() && $_GET['activated'] == 'true') {
header("Location: index.php");
}
function remove_dns_prefetch( $hints, $relation_type ) {
if ( 'dns-prefetch' === $relation_type ) {
return array_diff( wp_dependencies_unique_hosts(), $hints );
}
return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

/**
 * 引入必要的css和js文件
 */
add_action( 'wp_enqueue_scripts', 'wphy_script_style' );

function wphy_script_style(){
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' ); 
    wp_enqueue_style( 'xs-style', get_stylesheet_uri() );
	wp_enqueue_style( 'ui',get_template_directory_uri() . '/css/ui.css');
	wp_enqueue_style( 'responsive',get_template_directory_uri() . '/css/responsive.css' );
	wp_enqueue_style( 'jquery.fancybox',get_template_directory_uri() . '/css/jquery.fancybox.css' );
	wp_enqueue_style( 'animate',get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'owl.carousel',get_template_directory_uri() . '/css/owl.carousel.css');
	wp_enqueue_style( 'owl.theme.default',get_template_directory_uri() . '/css/owl.theme.default.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' ); 
	wp_enqueue_script( 'owl.carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.js', array('jquery'));
	wp_enqueue_script( 'jquery.fancybox', get_stylesheet_directory_uri() . '/js/jquery.fancybox.js', array('jquery'));
	wp_enqueue_script( 'wow.min', get_stylesheet_directory_uri() . '/js/wow.min.js', array('jquery'),'1.0.0', true );
	wp_enqueue_script( 'xs-js', get_stylesheet_directory_uri() . '/js/xs.js', array('jquery'),'1.0.0', true );

}

// 自定义菜单
register_nav_menus(
   array(
      'main-nav' => __( '顶部菜单' ),
	  'foot-nav' => __( '底部菜单' ),
	  'about-nav' => __( '关于我们菜单' ),
	  'pro-nav' => __( '产品分类菜单' ),
   )

);
function default_menu() {
require get_template_directory() . '/inc/default-menu.php';
}

// 小工具
if (function_exists('register_sidebar')){
	register_sidebar( array(
		'name'          => '侧边栏',
		'id'            => 'sidebar-1',
		'description'   => '显示在左侧边栏',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}


/* 摘要去除短代码
/* ----------------- */
function tin_excerpt_delete_shortcode($excerpt){
	$r = "'\[button(.*?)+\](.*?)\[\/button]|\[toggle(.*?)+\](.*?)\[\/toggle]|\[callout(.*?)+\](.*?)\[\/callout]|\[infobg(.*?)+\](.*?)\[\/infobg]|\[tinl2v(.*?)+\](.*?)\[\/tinl2v]|\[tinr2v(.*?)+\](.*?)\[\/tinr2v]|\<pre(.*?)+\>(.*?)\<\/pre>|\[php(.*?)+\](.*?)\[\/php]|\[PHP(.*?)+\](.*?)\[\/PHP]'";
	return preg_replace($r, '', $excerpt);
}
add_filter( 'the_excerpt', 'tin_excerpt_delete_shortcode', 999 );


/* 文章图片自动添加alt和title信息
/* -------------------------------- */
function tin_image_alt($content){
	global $post;
	$pattern = "/<img(.*?)src=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<img$1src=$2$3.$4$5 alt="'.$post->post_title.'" title="'.$post->post_title.'"$6>';
	$content = preg_replace($pattern,$replacement,$content);
	return $content;
}
add_filter('the_content','tin_image_alt',15);


/* 中文名图片上传改名
/* ------------------- */
function tin_custom_upload_name($file){
	if(preg_match('/[一-龥]/u',$file['name'])):
	$ext=ltrim(strrchr($file['name'],'.'),'.');
	$file['name']=preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])).'_'.date('Y-m-d_H-i-s').'.'.$ext;
	endif;
	return $file;
}
add_filter('wp_handle_upload_prefilter','tin_custom_upload_name',5,1);


// 去掉描述P标签
function deletehtml($description) {
	$description = trim($description);
	$description = strip_tags($description,"");
	return ($description);
}
add_filter('category_description', 'deletehtml');
add_filter('tag_description', 'deletehtml');
add_filter('term_description', 'deletehtml');
add_filter('the_excerpt', 'deletehtml');


remove_action('post_updated','wp_save_post_revision' );
 
 //输出缩略图地址
function post_thumbnail_src(){
	global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	} else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(!empty($matches[1][0])){
			$post_thumbnail_src = $matches[1][0];   //获取该图片 src
		}else{	//如果日志中没有图片，则显示随机图片
			//$random = mt_rand(1, 5);
			//$post_thumbnail_src = get_template_directory_uri().'/img/rand/'.$random.'.jpg';
			//如果日志中没有图片，则显示默认图片
			$post_thumbnail_src = get_template_directory_uri().'/images/1.png';
		}
	};
	echo $post_thumbnail_src;
}
function wpdx_paging_nav(){
	global $wp_query;
	$big = 999999999; // 需要一个不太可能的整数
	$pagination_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'add_args'     => true,
		'add_fragment' => '',
	) );
echo $pagination_links;
}


function the_crumbs() {
	$delimiter = '>'; // 分隔符
	$before = '<span class="current">'; // 在当前链接前插入
	$after = '</span>'; // 在当前链接后插入
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo '<nav  class="crumbs"><div class="container"><div class="con">'.__( '现在位置:' , 'xs' );
		global $post;
		$homeLink = home_url();
		echo ' <a itemprop="breadcrumb" href="' . $homeLink . '">' . __( '首页' , 'xs' ) . '</a> ' . $delimiter . ' ';
		if ( is_category() ) { // 分类 存档
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0){
				$cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
			}
			echo $before . '' . single_cat_title('', false) . '' . $after;
		}  elseif ( is_single() ) { // 文章
			if ( get_post_type() == 'product' ) { // 自定义文章类型	
	$terms = wp_get_post_terms($post->ID, 'products', array("fields" => "all"));$termsid = $terms[0]->term_taxonomy_id;
    echo get_term_parents_list( $termsid , 'products',array( 'inclusive' => false ,'separator'=>' > ')  );
	echo get_the_term_list( $post->ID, 'products' ,'','>',' > ');
				echo '<span>正文</span>';
			} 
			if ( get_post_type() == 'forum' ) { // 自定义文章类型	

				echo get_the_title();
			} 
			if ( get_post_type() == 'topic' ) { // 自定义文章类型	

				echo get_the_title() ;
			} 
			if ( get_post_type() == 'post' ) { // 文章 post
				$cat = get_the_terms($id, 'category'); $cat = $cat[0];
				$cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
				echo '<span>正文</span>';
			}
		}
elseif ( is_archive() )   
		{ // 分类 存档
		echo get_the_title();
		}
		elseif ( is_tax() )   
		{ // 分类 存档
			    $query_obj = get_queried_object();
				// var_dump( $query_obj );
				$term_id   = $query_obj->term_id;
				$taxonomy   = $query_obj->taxonomy;
		echo get_term_parents_list( $term_id, $taxonomy,array( 'inclusive' => false ,'separator'=>' > ')  );
			echo $before . '' . single_cat_title('', false) . '' . $after;
		}
		elseif ( is_page() && !$post->post_parent ) { // 页面
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) { // 父级页面
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a itemprop="breadcrumb" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) { // 搜索结果
			echo $before ;
			printf( __( '搜索结果是: %s', 'xs' ),  get_search_query() );
			echo  $after;
		} elseif ( is_404() ) { // 404 页面
			echo $before;
			_e( '您找的页面不存在', 'xs' );
			echo  $after;
		}
		if ( get_query_var('paged') ) { // 分页
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo sprintf( __( '( 页面 %s )', 'xs' ), get_query_var('paged') );
		}
		echo '</div></div></nav>';
	}
}


include_once( get_stylesheet_directory() . '/acf/acf.php' );
include_once( get_stylesheet_directory() . '/inc/acf.php' );

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => '网站设置',
        'menu_title'    => '网站设置',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'create_users',
        'redirect'      => false
    ));
    
}
//使WordPress支持post thumbnail
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

// 禁止后台加载谷歌字体
function wp_remove_open_sans_from_wp_core() {
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
	wp_enqueue_style('open-sans','');
}
add_action( 'init', 'wp_remove_open_sans_from_wp_core' );

//设置让文章内链接单独页面打开
function autoblank($text) {
	$return = str_replace('<a', '<a target="_blank"', $text);
	return $return;
}
add_filter('the_content', 'autoblank');

// 移除头部冗余代码
remove_action( 'wp_head', 'wp_generator' );// WP版本信息
remove_action( 'wp_head', 'rsd_link' );// 离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' );// 同上
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );// 上下文章的url
remove_action( 'wp_head', 'feed_links', 2 );// 文章和评论feed
remove_action( 'wp_head', 'feed_links_extra', 3 );// 去除评论feed
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );// 短链接

// 友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

    /**
* Disable the emoji's
*/
function disable_emojis() {
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
/**
* Filter function used to remove the tinymce emoji plugin.
*/
function disable_emojis_tinymce( $plugins ) {
if ( is_array( $plugins ) ) {
return array_diff( $plugins, array( 'wpemoji' ) );
} else {
return array();
}
}
//移除头部多余.recentcomments样式
function Fanly_remove_recentcomments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'Fanly_remove_recentcomments_style' );


// 后台预览
add_editor_style( '/css/editor-style.css' );

//隐藏管理后台帮助按钮和版本更新提示
function hide_help() {
	echo'<style type="text/css">#contextual-help-link-wrap { display: none !important; }  .update-nag{ display: none !important; } #footer-left, #footer-upgrade{ display: none !important; } #wp-admin-bar-wp-logo{display: none !important;}.default-header img{width:400px;}</style>';
}
add_action('admin_head', 'hide_help');
 // add_filter('pre_site_transient_update_core', create_function('$a', "return null;")); // 关闭核心提示
 // add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;")); // 关闭插件提 示
 // add_filter('pre_site_transient_update_themes', create_function('$a', "return null;")); // 关闭主题提 示
 // remove_action('admin_init', '_maybe_update_core'); // 禁止 WordPress 检查更新
 remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
 remove_action('admin_init', '_maybe_update_themes'); // 禁止 WordPress 更新主题

function custom_dashboard_help() {
echo '
<p>
<ol><li>主题安装后，会在WP后台的左侧工具条上增加【<a href=/wp-admin/admin.php?page=theme-general-settings>网站设置</a>】选项，这是主题的核心设置，请知悉！</li>
<li>主题安装好第一件事不是去网站设置选项，而是创建好网站的<a href=/wp-admin/edit-tags.php?taxonomy=category>文章分类</a>、<a href=/wp-admin/edit-tags.php?taxonomy=products&post_type=product>产品分类</a>和<a href=/wp-admin/edit.php?post_type=page>页面</a>！（已有分类和页面的老站除外）。</li>
<li>在设置-><a href="/wp-admin/options-reading.php">阅读</a>->您的主页显示->一个静态页面，选择首页设置。</li>
<li>在页面->首页设置里选择调用分类时，没有显示你的分类名？那是因为您没有新建分类！</li>
<li>通过编辑<a href=/wp-admin/edit-tags.php?taxonomy=category>分类目录</a>、<a href=/wp-admin/edit-tags.php?taxonomy=products&post_type=product>产品分类</a>，可以看到分类目录的SEO设置和顶部图片设置</li>
<li>通过<a href=/wp-admin/nav-menus.php>菜单</a>的<a href=/wp-admin/nav-menus.php?action=edit&menu=0>创建</a>功能可以创建出很多的菜单组，设置好菜单组，选择好菜单所要显示的位置！</li>
<li>通过<a href=/wp-admin/widgets.php>小工具</a>的功能可以创建出页面右侧边栏，选择导航菜单拖到侧边栏->选择对应的菜单！</li>
<br>
<li>以上是主题使用方面最基础的操作，如需要修改主题里写死了的文字或链接，可以尝试下外观里的【<a href=/wp-admin/theme-editor.php>编辑</a>】 来进行修改（谨慎操作）！</li>

<li>最后，小兽wordpress在线QQ：<a  href="tencent://message/?uin=448696976&Menu=yes" title="QQ咨询" style="font-size: 14px;color: red;">448696976 </a>（工作日09:00-17:00在线，其他时间回复不及时见谅）更多wordpress信息请点击<a  href="http://www.seo628.com/?theme=xsnamu" style="font-size: 14px;color: red;" target="_blank">小兽wordpress官网</a></li></ol>

</p>';
}
function example_add_dashboard_widgets() {
    wp_add_dashboard_widget('custom_help_widget', '小兽wordpress', 'custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );

//删除仪表盘模块
function example_remove_dashboard_widgets() {
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;
    // 以下这一行代码将删除 "快速发布" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    // 以下这一行代码将删除 "引入链接" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    // 以下这一行代码将删除 "插件" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    // 以下这一行代码将删除 "近期评论" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    // 以下这一行代码将删除 "近期草稿" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // 以下这一行代码将删除 "WordPress 开发日志" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    // 以下这一行代码将删除 "其它 WordPress 新闻" 模块
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    // 以下这一行代码将删除 "概况" 模块
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );
remove_action('welcome_panel', 'wp_welcome_panel');

function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//3.8版开始
}
add_action( 'admin_init', 'remove_dashboard_meta' );


function change_post_menu_label() {
    global $menu;
    $menu[2][0] = '帮助中心';
}
function change_post_object_label() {
    
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

function shapeSpace_screen_layout_columns($columns) {
    $columns['dashboard'] = 1;
    return $columns;
}
add_filter('screen_layout_columns', 'shapeSpace_screen_layout_columns');
function shapeSpace_screen_layout_dashboard() { return 1; }
add_filter('get_user_option_screen_layout_dashboard', 'shapeSpace_screen_layout_dashboard');

function remove_submenus() {
  global $submenu;
  unset($submenu['index.php'][10]); // Removes 'Updates'.
    remove_menu_page( 'edit.php?post_type=acf-field-group' );
}
add_action('admin_menu', 'remove_submenus');


add_action('after_setup_theme', 'create_pages'); 
function create_pages(){
    $awesome_page_id2 = get_option("awesome_page_id2");
    if (!$awesome_page_id2) {
        //create a new page and automatically assign the page template
        $post1 = array(
            'post_title' => "首页设置", //这里是自动生成页面的页面标题
            'post_content' => "", //这里是页面的内容
            'post_status' => "publish",
            'post_type' => 'page',
		
        );
        $postID = wp_insert_post($post1, $error);
        update_post_meta($postID, "_wp_page_template", "page-home.php"); //这里是生成页面的模板类型
        update_option("awesome_page_id2", $postID);
    }
}

?>