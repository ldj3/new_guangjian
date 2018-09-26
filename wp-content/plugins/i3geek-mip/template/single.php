<?php load_template(i3geek_mip_function::get_template_path("header.php")); ?>
<div id="container">
	<div class="post">	
	<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1><?php the_title(); ?></h1>
			<div class="meta">
				<span class="item"><?php the_date(); ?></span>
				<span class="item">分类：<?php $category = get_the_category();if($category[0]){echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';}?></span>
				<span class="item post-views">作者：<?php the_author();?></span>
			</div>
		</header>
		<div class="post_content"><?php the_content(); ?></div><!-- MIP reform powered by www.i3geek.com -->
		<div id="rating"></div>
		<div class="clear"></div>
		<div class="section_title">
			<span>继续阅读</span>
		</div>
		<div class="post_detail">
		<?php endwhile; endif; ?>
			<ul class="entry-relate-links">
<?php
$prev_post = get_previous_post();
if (!empty( $prev_post )){
	echo '<li><span>上一篇 &gt;：</span><a href="'.get_permalink( $prev_post->ID ).'">'.$prev_post->post_title.'</a></li>';
}?>

<?php
$next_post = get_next_post();
if (!empty( $next_post )){
	echo '<li><span>下一篇 &gt;：</span><a href="'.get_permalink( $next_post->ID ).'">'.$next_post->post_title.'</a></li>';
}?>            
			</ul>
		</div>
	</div>
</div>
<div class="clear"></div>
<?php load_template(i3geek_mip_function::get_template_path("footer.php")); ?>