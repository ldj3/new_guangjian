<div class="col-md-6 ddd col-sm-12 col-xs-12">
<div class="iproduct">
<h3><?php _e('产品中心','xs')?><a href="<?php the_field('product-url',$page_id)?>">MORE</a></h3>
<div class="pro-con">
<ul class="row">
<?php 
$args = array(
'post_type'=> 'product',
'posts_per_page'	=> 6,
'ignore_sticky_posts' => 1,
'orderby'   => date,
);query_posts($args);?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<li class="col-md-4 col-sm-6 col-xs-12">
<a href="<?php the_permalink(); ?>"  title="<?php the_title(); ?>">
<img   src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=350&w=400&zc=1" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
<p><?php the_title(); ?></p>
</a>
</li>
<?php endwhile; ?>
<?php else : ?>
<?php endif; wp_reset_query(); ?>
</ul>
</div>
</div>
</div>