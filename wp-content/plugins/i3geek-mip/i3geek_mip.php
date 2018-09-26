<?php  
/*
Plugin Name: MIP改造
Plugin URI: http://mip.i3geek.com
Description: MIP for WP - Add Mobile Instant Pages support to your WordPress site. Wordpress站点的百度MIP格式改造
Version: 1.1.2
Author: yan.i3geek
Author URI: https://www.i3geek.com/
License: GPL
*/
define( 'I3GEEK_MIP__FILE__', __FILE__ );
define( 'I3GEEK_MIP__DIR__', dirname( __FILE__ ) );
require_once (I3GEEK_MIP__DIR__.'/i3geek_mip_function.php');
require_once (I3GEEK_MIP__DIR__.'/i3geek_mip_admin.php');
register_activation_hook( __FILE__, 'i3geek_mip_activate' );
function i3geek_mip_activate() {
  i3geek_mip_after_setup_theme();
  if ( ! did_action( 'i3geek_mip_init' ) ) {
    i3geek_mip_init();
  }
  flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'i3geek_mip_deactivate' );
function i3geek_mip_deactivate() {
  global $wp_rewrite;
  foreach ( $wp_rewrite->endpoints as $index => $endpoint ) {
    if ( I3GEEK_MIP_QUERY_VAR === $endpoint[1] ) {
      unset( $wp_rewrite->endpoints[ $index ] );
      break;
    }
  }
  flush_rewrite_rules();
}
add_action( 'after_setup_theme', 'i3geek_mip_after_setup_theme', 5 );
function i3geek_mip_after_setup_theme() {  
  if ( ! defined( 'I3GEEK_MIP_QUERY_VAR' ) ) {
    define( 'I3GEEK_MIP_QUERY_VAR', apply_filters( 'I3GEEK_MIP_QUERY_VAR', 'mip' ) );
  }
  add_action( 'init', 'i3geek_mip_init' );
  add_action( 'admin_init', 'i3geek_mip_admin::register_settings' );
  add_action( 'wp_loaded', 'i3geek_mip_add_options_menu' );
  add_action( 'parse_query', 'i3geek_mip_correct_query_when_is_front_page' );
  i3geek_mip_function::add_post_type_support();

}
add_filter( 'plugin_action_links', 'i3geek_mip_add_link', 10, 2 );
function i3geek_mip_add_link( $actions, $plugin_file ) {
  static $plugin;
  if (!isset($plugin))
    $plugin = plugin_basename(__FILE__);
  if ($plugin == $plugin_file) {
      $settings = array('settings' => '<a href="admin.php?page=i3geek_mip">' . __('Settings') . '</a>');
      $site_link  = array('support' => '<a href="http://mip.i3geek.com" target="_blank">官网</a>','bbs' => '<a href="http://bbs.i3geek.com" target="_blank">论坛</a>');
      $actions  = array_merge($settings, $actions);
      $actions  = array_merge($site_link, $actions);
  }
  return $actions;
}
function i3geek_mip_add_options_menu() {
  if ( ! is_admin() ) return;
  $options = new i3geek_mip_admin();
  $options->init();
}
function i3geek_mip_init() {
  do_action( 'i3geek_mip_init' );
  i3geek_mip_function::get_option();
  add_rewrite_endpoint( I3GEEK_MIP_QUERY_VAR, EP_ALL );
  add_filter( 'request', 'i3geek_mip_force_query_var_value' );
  add_action( 'wp', 'i3geek_mip_maybe_add_actions' );
}
function i3geek_mip_force_query_var_value( $query_vars ) {
  if ( isset( $query_vars[ I3GEEK_MIP_QUERY_VAR ] ) && '' === $query_vars[ I3GEEK_MIP_QUERY_VAR ] ) {
    $query_vars[ I3GEEK_MIP_QUERY_VAR ] = 1;
  }
  return $query_vars;
}
function i3geek_mip_maybe_add_actions() {
  global $wp_query;
  if (  ! ( is_singular() || $wp_query->is_posts_page ) || is_feed() ) {
    return;
  }
  $is_mip_endpoint = i3geek_mip_function::is_mip_endpoint();
  $post = get_queried_object();
  if ( ! i3geek_mip_function::post_supports_mip( $post ) ) {
    if ( $is_mip_endpoint ) {
      wp_safe_redirect( get_permalink( $post->ID ), 302 );
      exit;
    }
    return;
  }
  if ( $is_mip_endpoint ) {
    add_action( 'template_redirect', 'i3geek_mip_render' );
  } else {
    add_action( 'wp_head', 'i3geek_mip_frontend_add_canonical' );
  }
}
function i3geek_mip_frontend_add_canonical() {
   $mip_url = i3geek_mip_function::get_mip_url( get_queried_object_id() );
  printf( '<link rel="miphtml" href="%s">', esc_url( $mip_url ) );
}
function i3geek_mip_correct_query_when_is_front_page( WP_Query $query ) {
  $is_front_page_query = (
    $query->is_main_query()
    &&
    $query->is_home()
    &&
    false !== $query->get( I3GEEK_MIP_QUERY_VAR, false )
    &&
    ! $query->is_front_page()
    &&
    'page' === get_option( 'show_on_front' )
    &&
    get_option( 'page_on_front' )
    &&
    0 === count( array_diff( array_keys( wp_parse_args( $query->query ) ), array( I3GEEK_MIP_QUERY_VAR, 'preview', 'page', 'paged', 'cpage' ) ) )
  );
  if ( $is_front_page_query ) {
    $query->is_home     = false;
    $query->is_page     = true;
    $query->is_singular = true;
    $query->set( 'page_id', get_option( 'page_on_front' ) );
  }
}
function i3geek_mip_render() {
  if ( is_single() ) { 
    add_filter( 'the_content', 'i3geek_mip_function::auto_add_url_parse');
    add_filter('the_content', 'i3geek_mip_function::mip_reform',100);
    add_action('get_header', 'i3geek_mip_function::mip_reform_link');
    add_filter('get_header', 'i3geek_mip_function::upgrade_ssl');
    load_template(i3geek_mip_function::get_template_path("single.php"));
    exit;
  }
}

    ?>