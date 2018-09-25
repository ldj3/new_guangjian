<?php get_header(); ?>
<section id="slider" class="text-center">
<img src="<?php bloginfo('template_url')?>/images/s1.jpg" >
</section>
<?php the_crumbs(); ?>
<Section id="content" class="mb20">
<div class="container">
<div class="row">
<div class="col-md-2 col-sm-2 hidden-xs wow fadeInLeft delay300">
<div class="sidebar">
<?php get_sidebar();?>
</div>
</div>
<div class="col-md-10 col-sm-10 col-xs-12 wow fadeInRight delay300">
<ul class="content-list">
 <?php 
 $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$args = array(
	'post_type'=> 'post',
	'paged' => $paged,
	'ignore_sticky_posts' => 1  ,
);query_posts($args);?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<a href="<?php the_permalink(); ?>">
<h2><?php the_title(); ?></h2>
<span class="hidden-xs"><?php the_time('Y / n / j'); ?></span>
</a>
</li>
<?php endwhile; endif;?>
</ul>
<div class="page-nav mt20 mb20"><?php if(function_exists('wpdx_paging_nav')) wpdx_paging_nav();wp_reset_query();  ?></div>
</div>
</div>
</div>

</section>
<?php get_footer(); ?>