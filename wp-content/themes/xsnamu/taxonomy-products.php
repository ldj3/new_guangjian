<?php get_header(); ?>
<section id="slider" class="text-center">
<?php 
$cat_ID = get_queried_object_id();
if( get_field('top-images',products_.$cat_ID) ): ?>
<img src="<?php the_field('top-images',products_.$cat_ID)?>">
<?php else:?>
<img src="<?php bloginfo('template_url')?>/images/s1.jpg" >
<?php endif; ?>
</section>
<?php the_crumbs(); ?>
<Section id="mian" class="mb20">
<div class="container">
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12 wow fadeInLeft delay300">
<div class="content-cp">
<div class="entry-des">
<?php if( category_description() ):?>
<p><?php echo category_description(); ?></p>
<?php endif;?>
</div>
<div class="pro-con">
 <ul class="row"> 
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li class="col-md-3  col-sm-3 col-xs-12" > 
<a href="<?php the_permalink(); ?>"> 
<img  src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=350&w=400&zc=1" alt="<?php the_title(); ?>" />
<p><?php the_title(); ?></p> 
</a> 
</li> 
<?php endwhile;  endif;?>
</ul> 
</div>
<div class="page-nav mt20 mb20"><?php if(function_exists('wpdx_paging_nav')) wpdx_paging_nav();wp_reset_query();  ?></div>
</div>
</div>
<div class="col-md-2 col-sm-2 hidden-xs  wow fadeInRight delay300">
<div class="sidebar">
<?php get_sidebar();?>
</div>
</div>
</div>
</div>
</section>
<?php get_footer();?>