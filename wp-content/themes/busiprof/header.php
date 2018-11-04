<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	
	<!-- 自定义关键词 -->
	
	<?php
		//描述
		$description = '';
		//关键词
		$keywords = '';
 
		if (is_home() || is_page()) {
		   // 将以下引号中的内容改成你的主页description
		   $description = "广州市广建水泥制品有限公司主营：环保彩砖|透水砖|建菱砖|植草砖|环保砖|路面砖|人行道砖|广场砖|水泥砖|电缆沟盖板|电力盖板|水泥隔离墩|水泥防撞墩|交通隔离墩|仿花岗岩路侧石|水泥排水管|钢筋混凝土排水管|广州顶管|路平石|路侧石|预制件等各种水泥制品，服务热线：020-39965653";

		   // 将以下引号中的内容改成你的主页keywords
		   $keywords = "环保彩砖|透水砖|广场砖|植草砖|建菱砖|电缆沟盖板|电力盖板|水泥隔离墩|水泥防撞墩|交通隔离墩|仿花岗岩路侧石|水泥排水管|钢筋混凝土排水管|路侧石|预制件";
		}
		elseif (is_single()) {
		   $description1 = get_post_meta($post->ID, "description", true);
		   $description2 = str_replace("\n","",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));

		   // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
		   $description = $description1 ? $description1 : $description2;

		   // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
		   $keywords = get_post_meta($post->ID, "keywords", true);
		   if($keywords == '') {
			  $tags = wp_get_post_tags($post->ID);    
			  foreach ($tags as $tag ) {        
				 $keywords = $keywords . $tag->name . ", ";    
			  }
			  $keywords = rtrim($keywords, ', ');
		   }
		}
		elseif (is_category()) {
		   // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
		   $description = category_description();
		   $keywords = single_cat_title('', false);
		}
		elseif (is_tag()){
		   // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
		   $description = tag_description();
		   $keywords = single_tag_title('', false);
		}
		$description = trim(strip_tags($description));
		$keywords = trim(strip_tags($keywords));
		?>
		<meta name="description" content="<?php echo $description; ?>" />
		<meta name="keywords" content="<?php echo $keywords; ?>" />
	
	<!-- 关键词结束 -->
	<!--标题开始 -->
	<?php if ( is_home() ) { ?><title><?php bloginfo('name'); ?>-<?php bloginfo('description'); ?></title><?php } ?>
	<?php if ( is_search() ) { ?><title>搜索结果-Search Results-<?php bloginfo('name'); ?></title><?php } ?>
	<?php if ( is_single() ) { ?><title><?php echo trim(wp_title('',0)); ?>-<?php bloginfo('name'); ?>-<?php bloginfo('description'); ?></title><?php } ?>
	<?php if ( is_page() ) { ?><title><?php echo trim(wp_title('',0)); ?></title><?php } ?>
	<?php if ( is_category() ) { ?><title><?php single_cat_title(); ?></title><?php } ?>
	<?php if ( is_month() ) { ?><title><?php the_time('F'); ?>-<?php bloginfo('name'); ?></title><?php } ?>
	<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><title><?php single_tag_title("", true); ?>-<?php bloginfo('name'); ?></title><?php }?> <?php } ?>
	
	<!-- 标题结束 -->
	

<?php wp_head(); 
$current_options = wp_parse_args(  get_option( 'busiprof_theme_options', array() ), theme_setup_data() );
?>	
</head>
<body <?php body_class(); ?>>

<!-- Navbar -->	
<nav class="navbar navbar-default">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo home_url( '/' ); ?>" class="brand" style="height:96px;">
				<?php
					bloginfo('name');
				?>
				<p style="text-align:center;letter-spacing:8px;">
					<?php bloginfo('blog_name_p1'); ?>
				</p>
<!-- 				<p style="text-align:center;font-size:12px;letter-spacing:8px;">
					<?php bloginfo('blog_name_p2'); ?>
				</p> -->
<!-- 				<img alt="<?php bloginfo("name"); ?>" src="<?php echo ( esc_url($current_options['upload_image']) ? $current_options['upload_image'] : get_template_directory_uri() . '/images/logo.png' ); ?>" 
				alt="<?php bloginfo("name"); ?>"
				class="logo_imgae" style="width:<?php echo esc_html($current_options['width']).'px'; ?>; height:<?php echo esc_html($current_options['height']).'px'; ?>;"> -->
				
			</a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php 
				wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'  => 'nav-collapse collapse navbar-inverse-collapse',
				'menu_class' => 'nav navbar-nav navbar-right',
				'fallback_cb' => 'busiprof_fallback_page_menu',
				'walker' => new busiprof_nav_walker()) 
				); 
			?>			
		</div>
	</div>
</nav>	
<!-- End of Navbar -->