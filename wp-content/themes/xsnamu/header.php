<!DOCTYPE html>
<html id="doc">
<head>
<link rel="icon" href="<?php the_field('fav','option')?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php the_field('fav','option')?>" type="image/x-icon" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Cache-Control" content="no-transform" /> 
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="applicable-device" content="pc,mobile">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php get_template_part( 'content/seo' ); ?>
<?php wp_head(); ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?>>
<header id="header" class="clearfix">
<div class="top-header">
<div class="container">
<div class="pull-left"><?php _e('您好，欢迎来到','xs')?><?php bloginfo('name')?>！</div>
<div class="pull-right phone hidden-xs"><?php _e('咨询电话：','xs')?><?php the_field('phone','option'); ?></div>
</div>
</div>
<div class="btm-header mt10">
<div class="container">
<div class="header-logo pull-left">
<?php if ( is_front_page() ) { ?><h1><?php  the_field('keywords',$page_id);?></h1><?php } ?>
<?php if( get_field('logo','option') ): ?>
<a title="<?php bloginfo('description')?>" class="logo-url" href="<?php bloginfo('url')?>">
<img src="<?php the_field('logo','option'); ?>" alt="<?php bloginfo('name')?>" title="<?php bloginfo('name')?>"/>
</a>
<?php else : ?>
<a title="<?php bloginfo('description')?>" class="logo-url" href="<?php bloginfo('url')?>">
<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name')?>" />
</a>
<?php endif; ?>
</div>
<div class="header-menu pull-right">
<?php wp_nav_menu( array( 'theme_location' => 'main-nav', 'menu_class' => 'header-menu-con', 'container'=>'','fallback_cb' => 'default_menu',) ); ?>
</div>
<div class="button visible-xs-block">
<div class="menu-toggle">
<span></span>
</div>
</div>
</div>
</div>
</header>