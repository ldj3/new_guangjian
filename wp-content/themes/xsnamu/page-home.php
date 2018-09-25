<?php 
/**
 * Template Name: 首页
 * 作者：小兽
 */
get_header(); ?>
<?php get_template_part( 'template/slider' ); ?>
<div class="section1 p30"> 
<div class="container">
<div class="row">
<?php get_template_part( 'template/section3' ); ?>
<?php get_template_part( 'template/section2' ); ?>
<?php get_template_part( 'template/section1' ); ?>
</div>
</div>
</div>
<?php get_footer();?>