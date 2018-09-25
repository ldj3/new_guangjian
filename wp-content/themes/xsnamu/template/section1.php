<div class="col-md-3 col-sm-12 col-xs-12">
<div class="inews">
<h3><?php _e('新闻中心','xs')?><a href="<?php the_field('news-url',$page_id)?>">MORE</a></h3>
<ul class="tab-nav">
<?php $cat = get_field('news-cat',$page_id);if( $cat ): ?>
<?php foreach( $cat as $key=> $value ): ?>
<li class="<?php if($key ==0)echo "on";?>"><?php echo $value->name; ?></li>
<?php endforeach; ?>
<?php else:?>
<li class="on"><?php _e('公司新闻','xs')?></li>
<li><?php _e('行业新闻','xs')?></li>
<?php endif; ?>
</ul>
<div class="tab-con">
<?php 
$cat = get_field('news-cat',$page_id);
if( $cat ): ?><?php foreach( $cat as $key=> $value ): ?>
<ul class="<?php if($key ==0)echo "on";?>">
<?php 
$args = array(
'cat'=>$value->term_taxonomy_id,
'ignore_sticky_posts' => 1,
'posts_per_page' => 5,      // 显示多少条
'orderby' => 'date',         // 时间排序
'order' => 'desc',          // 降序（递减，由大到小）    
);
query_posts($args); while (have_posts()) : the_post();?>
<li>
<a href="<?php the_permalink(); ?>"> 
<img  src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=50&w=80&zc=1" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
<p><?php the_title(); ?></p>
</a>
</li>
<?php endwhile;wp_reset_query();  ?>
</ul>
<?php endforeach; ?>
<?php endif;?>
</div>
</div>
</div>