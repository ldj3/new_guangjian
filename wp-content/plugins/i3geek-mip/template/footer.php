<div id="footer">
	<div id="footer-body">
		<div id="footer-content">
			<?php $h5_url = i3geek_mip_function::get_h5_url(get_queried_object_id());
			if($h5_url)echo '<a href="'.$h5_url.'" />'."[查看原页面]</a><br />"; ?>
			<a href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a> · 版权所有 · MIP Powered by <a href="http://www.i3geek.com">I3geek.com</a>
		</div>
	</div>
</div>
<div class="clear"></div>
<mip-stats-baidu token="d22ad065e285ad395d08707fcc17ef83"></mip-stats-baidu>
<script src="https://c.mipcdn.com/static/v1/mip.js"></script>
<script src="https://c.mipcdn.com/static/v1/mip-stats-baidu/mip-stats-baidu.js"></script>
<!-- MIP reform powered by www.i3geek.com -->
</body>
</html>