<section id="slider" class="indexbg">
<div class="owl-carousel owl-theme">
<?php $page_id = get_queried_object(); $terms = get_field('sliders',$page_id);if( $terms ): ?>
<?php foreach( $terms as $value ): ?>
<div class="item">
<img src="<?php echo $value['images']?>" alt="<?php echo $value['title']?>" title="<?php echo $value['title']?>">
</div>
<?php endforeach;?>
<?php else : ?>
<div class="item">
<img src="<?php bloginfo('template_url')?>/images/index.jpg">
</div>
<?php  endif; ?>
</div>
</section>