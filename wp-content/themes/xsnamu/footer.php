<section id="footer">
<div class="footer-top clearfix mb10">
<div class="container">
<div class="footer-menu">
<?php wp_nav_menu( array( 'theme_location' => 'foot-nav', 'menu_class' => 'footer-menu-con', 'container'=>'','fallback_cb' => 'default_menu',) ); ?>
</div>
</div>
</div>
<div class="footer-btm clearfix">
<div class="container">
<div class="pull-left footer-info">Copyright © <?php the_time('Y');?> <a href="<?php bloginfo("url");?>"><?php bloginfo("name");?></a> <?php _e('版权所有','xs')?> <?php the_field('btm-icp','option') ?>
&nbsp;<a href="<?php bloginfo("url");?>/sitemap.xml" target="_blank"><?php _e('网站地图','xs')?></a><?php the_field('tjgj','option') ?>
<p><?php the_field('footer-info','option') ?></p>
<?php if ( is_front_page() ) { ?><div class="link"><ul><?php wp_list_bookmarks('title_li=&categorize=0'); ?></ul></div><?php } ?>
</div>
<div class="social pull-right hidden-xs">
<div class="btm-search mb20">
<form method="get" action="<?php bloginfo('url'); ?>" >
<input type="text" name="s" class="text" autocomplete="off"  placeholder="<?php _e('输入搜索内容','xs')?>">
<button class="btn-search"> <i class="fa fa-search"></i></button>
</form>
</div>
<div class="weixin">
<img src="
<?php if( get_field('wechat','option') ): ?><?php the_field('wechat','option') ?>
<?php else :?>
<?php bloginfo('template_url');?>/images/wechat.png
<?php endif;?>" alt="<?php _e('扫描二维码','xs')?>">
</div> 
<p><?php _e('扫描二维码','xs')?><br><?php _e('关注更多精彩','xs')?></p> 
<div class="bdsharebuttonbox"> 
<a class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a> 
<a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a> 
<a class="bds_qzone" data-cmd="qzone" href="#" title="分享到QQ空间"></a> 
<a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a> 
<a class="bds_more" data-cmd="more">更多</a> 
</div> 
</div>
</div>
</div>
</section>
<?php wp_footer(); ?>
<?php if ( is_singular() ){ ?>
<!-- Baidu Button BEGIN -->
<script>
window._bd_share_config = {
"common": {
"bdSnsKey": {},
"bdText": "",
"bdMini": "2",
"bdMiniList": false,
"bdPic": "",
"bdStyle": "0",
"bdSize": "16"
},
"share": {}
};
with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~ ( - new Date() / 36e5)];
</script>
<!-- Baidu Button END -->
<?php } ?>
<div class="main-im hidden-xs">
<div id="open_im" class="open-im">&nbsp;</div>  
<div class="im_main" id="im_main">
<div id="close_im" class="close-im"><a href="javascript:void(0);" title="<?php _e('点击关闭','xs')?>">&nbsp;</a></div>
<a href="http://wpa.qq.com/msgrd?v=3&uin=<?php the_field('qq','option') ?>&site=qq&menu=yes" target="_blank" class="im-qq qq-a" title="<?php _e('在线QQ客服','xs')?>">
<div class="qq-container"></div>
<div class="qq-hover-c"><img class="img-qq" src="<?php bloginfo('template_url');?>/images/kf/qq.png"></div>
<span><?php _e('QQ在线咨询','xs')?></span>
</a>
<div class="im-tel">
<div><?php _e('销售服务热线','xs')?></div>
<div class="tel-num"><?php the_field('phone','option') ?></div>
<div><?php _e('手机/微信','xs')?></div>
<div class="tel-num"><?php the_field('mini','option') ?></div>
</div>
<div class="im-footer" style="position:relative">
<div class="weixing-container">
<div class="weixing-show">
<div class="weixing-txt"><?php _e('微信扫一扫','xs')?><br><?php _e('询价更方便','xs')?></div>
<img class="weixing-ma" src="
<?php if( get_field('wechat','option') ): ?><?php the_field('wechat','option') ?>
<?php else :?>
<?php bloginfo('template_url');?>/images/wechat.png
<?php endif;?>">
<div class="weixing-sanjiao"></div>
<div class="weixing-sanjiao-big"></div>
</div>
</div>
<div class="go-top"><a href="javascript:;" title="<?php _e('返回顶部','xs')?>"></a> </div>
<div style="clear:both"></div>
</div>
</div>
</div>
<script>new WOW().init();</script>
</body>
</html>