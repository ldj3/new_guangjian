<?php get_header(); ?>
<section id="slider" class="text-center bg-info">
<?php 
if( get_field('top-images') ): ?>
<img src="<?php the_field('top-images')?>" alt="<?php the_title();?>">
<?php else:?>
<img src="<?php bloginfo('template_url')?>/images/s1.jpg" alt="<?php the_title();?>">
<?php endif; ?>
</section>
<?php the_crumbs(); ?>
<Section id="main" class="mb20">
<div class="container">
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12 wow fadeInLeft delay300">
<div class="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-meta">
<h1 class="mb10"><?php the_title();?></h1>
</div>
<div class="entry-content">
<?php the_content();?> 
</div>
</article>
<?php endwhile;  endif;?>
</div>
</div>
<div class="col-md-2 col-sm-2 hidden-xs wow fadeInRight delay300">
<div class="sidebar">
<?php get_sidebar();?>
</div>
</div>
</div>
</section>
<?php get_footer(); ?>