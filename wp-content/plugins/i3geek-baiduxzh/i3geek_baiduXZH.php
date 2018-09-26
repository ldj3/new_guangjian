<?php  
/*
Plugin Name: BaiduXZH Submit(百度熊掌号)
Plugin URI: http://www.i3geek.com/archives/1681
Description: 百度熊掌号wordpress插件，自动推送最新文章或历史文章至百度，以及原创保护文章推送，并支持页面改造SEO优化。
Version: 1.4.6
Author: yan.i3geek
Author URI: http://www.i3geek.com/
License: GPL
*/

require_once("i3geek_baiduXZH_function.php"); 
const ORIGINAL_TIMEOUT = 3600;
add_action( 'admin_init', 'i3geek_xzh_admin_init' );
add_action( 'plugins_loaded', 'i3geek_xzh_plugin_setup' );
set_transient('I3GEEK_XZH_MSG_STATUS', 0, 86400);
function i3geek_xzh_admin_init() {
  i3geek_xzh_default_options();
  add_action( 'do_meta_boxes', 'i3geek_xzh_do_meta_box', 20, 2 );
  add_action( 'admin_enqueue_scripts', 'i3geek_xzh_scripts' );
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if ( is_array($Settings['Types']) ) {
    foreach($Settings['Types'] as $type) {
      add_action('publish_'.$type, 'i3geek_xzh_publish');
      add_filter('manage_'.$type.'_posts_columns', 'i3geek_xzh_add_post_columns');
      add_action('manage_'.$type.'s_custom_column', 'i3geek_xzh_render_post_columns', 10, 2);
    } 
  }
}
function i3geek_xzh_default_options(){
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( !is_array($Settings) ){   
    $Settings = array(
      'Appid'   => '',
      'Token' => '',
      'Types'   => '',
      'auto'  => 'y',
      'original'  => 'y',
    );
    update_option('I3GEEK_XZH_SETTING', $Settings);
  }
}
function i3geek_xzh_plugin_setup(){
  add_filter( 'the_content', 'i3geek_xzh_common', 10 );
}
function i3geek_xzh_do_meta_box( $type, $context ) {
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( !is_array($Settings) ) return;
  if ( $Settings['auto'] !== 'y' || !@in_array( $type, $Settings['Types'] ) )
      return;
  if ( 'side' == $context && in_array( $type, array_keys( get_post_types() ) )  )
    add_meta_box( 'sd-i3geek-xzh', '百度熊掌号', 'i3geek_xzh_meta_box', $type, 'side', 'high' );
}
function i3geek_xzh_meta_box() {
    $Settings = get_option('I3GEEK_XZH_SETTING');
    global $post;
    $screen = get_current_screen();
    $lefttimes = i3geek_baiduXZH_function::submit_left();
    wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true );
    if ( 'add' !== $screen->action ){
      if( get_post_meta( $post->ID, 'i3geek_xzh_submit', TRUE)=='2'){
        echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" checked/><label for="original">已提交原创成功！</label></p>';
      }else{
        if( get_post_time('G', true, $post)>0 && time() - get_post_time('G', true, $post) > ORIGINAL_TIMEOUT){
          echo '<p>超过原创提交有效时间</p><p>* 注意：请在原创数据发布1小时内提交数据</p>';
          echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" /><label for="original">原创提交</label></p>';
        }else{
          echo '<p>今日剩余配额：'.$lefttimes.'</p>';
          echo '<p><input type="checkbox" name="original" id="original" value="1" ';
          checked( $Settings['original']=='y' );
          echo ' /> <label for="original">' . '原创提交'. '</label></p>';
        }
      }
    }else{
      if($lefttimes > 0){
        echo '<p>今日剩余配额：'.$lefttimes.'</p>';
        echo '<p><input type="checkbox" name="original" id="original" value="1" ';
        checked( $Settings['original']=='y' );
        echo ' /> <label for="original">' . '原创提交'. '</label></p>';
      }else{
        echo '<p>今日百度提交（原创保护）已达上限</p><p>* 注意：熊掌号与原创保护共享提交配额</p>';
        echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" /><label for="original">原创提交</label></p>';
      }
    }
    echo '<input name="i3geek_xzh_submit_CHECK" type="hidden" value="true">';
}
function i3geek_xzh_add_post_columns($columns) {
    $columns['i3geek_xzh'] = '推送至熊掌号';
    return $columns;
}
function i3geek_xzh_render_post_columns($column_name, $id) {
    switch ($column_name) {
    case 'i3geek_xzh':
      if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)=='1')
        echo '提交成功';
      else if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)=='2')
        echo '[原创]提交成功';
      else if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)== '-1')
        echo '历史内容提交成功';
      else if(get_post($id)->post_status == 'publish')
        echo '<div id="i3geek_content'.$id.'">未提交'.'>><a href="javascript:void(0);" onclick="i3geek_xzh_submit('.$id.',\''.wp_create_nonce( 'i3geek-xzh-post' ).'\')">提交</a></div>';
      break;
    }
}
function i3geek_xzh_publish($post_ID ,$manual = false) {
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( is_array($Settings) && !empty($Settings['Appid']) && !empty($Settings['Token']) ){
    if( $manual || (sanitize_text_field($_POST['i3geek_xzh_submit_CHECK']) &&  $Settings['auto'] == 'y') ){
      $original = sanitize_text_field($_POST['original']);
      i3geek_baiduXZH_function::submit2baidu($post_ID, $original, $Settings);
    }
  }
}
function i3geek_xzh_scripts(){
  wp_register_script( 'i3geek_xzh_js', plugins_url('scripts/xzh.js',__FILE__) );  
  wp_enqueue_script( 'i3geek_xzh_js' );  
  wp_register_style( 'i3geek_xzh_css', plugins_url('scripts/xzh.css',__FILE__) );  
  wp_enqueue_style( 'i3geek_xzh_css' );
}
function i3geek_xzh_common($content){
  if( is_single() ){
    $i3geek_xzh_notice = get_option( 'I3GEEK_XZH_NOTICE');
    $tag = is_array($i3geek_xzh_notice)?$i3geek_xzh_notice['htmlcontent']:'http://xzh.i3geek.com';
    return $content.$tag.'<!-- Page reform for Baidu by 爱上极客熊掌号 (i3geek.com) -->';
  }
  return $content;
}
add_filter( 'plugin_action_links', 'i3geek_xzh_add_link', 10, 2 );
function i3geek_xzh_add_link( $actions, $plugin_file ) {
  static $plugin;
  if (!isset($plugin))
    $plugin = plugin_basename(__FILE__);
  if ($plugin == $plugin_file) {
      $settings = array('settings' => '<a href="admin.php?page=i3geek_xzh">' . __('Settings') . '</a>');
      $site_link  = array('support' => '<a href="http://xzh.i3geek.com" target="_blank">官网</a>','bbs' => '<a href="http://bbs.i3geek.com" target="_blank">论坛</a>');
      $actions  = array_merge($settings, $actions);
      $actions  = array_merge($site_link, $actions);
  }
  return $actions;
}
if( is_admin() ) {
    add_action('admin_menu', 'i3geek_xzh_menu');
}
function i3geek_xzh_menu() {
    add_menu_page('百度熊掌号设置', '百度熊掌号', 'manage_options','i3geek_xzh', 'i3geek_xzh_html_page', 'data:image/svg+xml;base64,CjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDEwMDAgMTAwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTAwMCAxMDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPG1ldGFkYXRhPiDnn6Lph4/lm77moIfkuIvovb0gOiBodHRwOi8vd3d3LnNmb250LmNuLyA8L21ldGFkYXRhPjxnPjxwYXRoIGQ9Ik0xODYuMyw1MjYuNGMxMDYuNi0yMi45LDkyLjEtMTUwLjIsODguOS0xNzguMWMtNS4yLTQyLjktNTUuNy0xMTcuOS0xMjQuMi0xMTJjLTg2LjIsNy43LTk4LjgsMTMyLjMtOTguOCwxMzIuM0M0MC41LDQyNi4zLDgwLDU0OS4zLDE4Ni4zLDUyNi40eiBNMjk5LjUsNzQ3LjljLTMuMSw5LTEwLjEsMzEuOS00LDUxLjhjMTEuOSw0NC43LDUwLjcsNDYuNyw1MC43LDQ2LjdINDAyVjcxMGgtNTkuN0MzMTUuNCw3MTgsMzAyLjQsNzM4LjksMjk5LjUsNzQ3Ljl6IE0zODQuMSwzMTIuOGM1OC45LDAsMTA2LjQtNjcuNywxMDYuNC0xNTEuNUM0OTAuNSw3Ny43LDQ0MywxMCwzODQuMSwxMGMtNTguOCwwLTEwNi41LDY3LjctMTA2LjUsMTUxLjRDMjc3LjcsMjQ1LjEsMzI1LjQsMzEyLjgsMzg0LjEsMzEyLjh6IE02MzcuNiwzMjIuOWM3OC43LDEwLjIsMTI5LjItNzMuNywxMzkuMy0xMzcuNGMxMC4zLTYzLjUtNDAuNS0xMzcuNC05Ni4yLTE1MGMtNTUuOC0xMi44LTEyNS41LDc2LjYtMTMxLjgsMTM0LjlDNTQxLjMsMjQxLjYsNTU5LjEsMzEyLjgsNjM3LjYsMzIyLjl6IE04MzAuMyw2OTYuOWMwLDAtMTIxLjctOTQuMi0xOTIuNy0xOTUuOWMtOTYuMy0xNTAuMS0yMzMuMS04OS0yNzguOS0xMi43Yy00NS42LDc2LjMtMTE2LjYsMTI0LjYtMTI2LjcsMTM3LjRDMjIxLjgsNjM4LjIsODUsNzEyLDExNS40LDg0Ni45YzMwLjQsMTM0LjgsMTM3LDEzMi4yLDEzNywxMzIuMnM3OC42LDcuNywxNjkuOC0xMi43YzkxLjItMjAuMiwxNjkuNyw1LjEsMTY5LjcsNS4xczIxMy4xLDcxLjMsMjcxLjQtNjZDOTIxLjUsNzY4LjEsODMwLjMsNjk2LjksODMwLjMsNjk2Ljl6IE00NjUuOCw5MDEuM0gzMjcuM2MtNTkuOC0xMS45LTgzLjYtNTIuNy04Ni43LTU5LjdjLTIuOS03LjEtMTkuOS0zOS45LTEwLjktOTUuN2MyNS44LTgzLjYsOTkuNi04OS42LDk5LjYtODkuNkg0MDN2LTkwLjZsNjIuOCwxTDQ2NS44LDkwMS4zTDQ2NS44LDkwMS4zeiBNNzIzLjgsOTAwLjNINTY0LjRjLTYxLjgtMTUuOS02NC43LTU5LjgtNjQuNy01OS44VjY2NC4ybDY0LjctMXYxNTguNGMzLjksMTYuOSwyNC45LDIwLDI0LjksMjBINjU1VjY2NC4yaDY4LjhMNzIzLjgsOTAwLjNMNzIzLjgsOTAwLjN6IE05NDkuNCw0MjkuN2MwLTMwLjQtMjUuMy0xMjIuMS0xMTkuMS0xMjIuMWMtOTMuOSwwLTEwNi41LDg2LjUtMTA2LjUsMTQ3LjdjMCw1OC40LDQuOSwxMzkuOCwxMjEuNiwxMzcuMkM5NjIuMiw1ODkuOSw5NDkuNCw0NjAuMyw5NDkuNCw0MjkuN3oiIHN0eWxlPSJmaWxsOiNhOWI3YjciPjwvcGF0aD48L2c+PC9zdmc+ICA=');
}
function i3geek_xzh_html_page() {
  $nonced = ( isset( $_POST['_i3geek_xzh_post_nonce'] ) && wp_verify_nonce( $_POST['_i3geek_xzh_post_nonce'], 'i3geek-xzh-post' ) );
  if($nonced && !empty($_POST['action'])){
    switch ($_POST['action']) {
      case 'i3geek_xzh_setting':
          $appid = sanitize_text_field($_POST['appid']);
          $token = sanitize_text_field($_POST['token']);
          $Types = sanitize_text_field($_POST['Types']);
          $auto_submit = sanitize_text_field($_POST['auto_submit']);
          $auto_original = sanitize_text_field($_POST['auto_original']);
          i3geek_baiduXZH_function::saveSetting($appid ,$token ,$Types ,$auto_submit ,$auto_original );
          break;
      case 'i3geek_xzh_submit_manual':
          $postid = sanitize_text_field($_POST['postid']);
          i3geek_xzh_publish($postid,TRUE);
          break;
      case 'i3geek_xzh_log':
          i3geek_baiduXZH_function::loadLog();
          break;
    }
  }
  $plugin_data = get_plugin_data( __FILE__ );
  $i3geek_xzh_notice = i3geek_baiduXZH_function::getNoticeMsg();
  require_once('i3geek_baiduXZH_html.php');
} 
?>
