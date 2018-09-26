<?php

class i3geek_mip_admin {
	const OPTION_NAME = 'i3geek_mip';
	const ICON_BASE64_SVG = 'data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI3Mi4yNTYgMjcyLjI1NiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjcyLjI1NiAyNzIuMjU2OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCI+CjxwYXRoIGQ9Ik0yMzUuMDk2LDEwMy41NjNjLTEuNjQ0LTMuNjg4LTUuMzA0LTYuMDYzLTkuMzQyLTYuMDYzYy0xMS42ODksMC03Ni45NSwwLTc2Ljk1LDBsMzEuNjUyLTgzLjY1MyAgYzEuMTg5LTMuMTQyLDAuNzU5LTYuNjY4LTEuMTUxLTkuNDMzQzE3Ny4zOTYsMS42NSwxNzQuMjUxLDAsMTcwLjg5MSwwSDk0Ljc2MmMtNC4yNTIsMC04LjA2MSwyLjYzMS05LjU2Niw2LjYwOGwtNDguMjYsMTI3LjU0NCAgYy0xLjE4OSwzLjE0Mi0wLjc1OSw2LjY2OCwxLjE1MSw5LjQzM2MxLjkxLDIuNzY0LDUuMDU1LDQuNDE1LDguNDE1LDQuNDE1bDg1LjM5OS0wLjUxM0w4Ni43OCwyNjcuNDkyICBjLTAuNTk2LDEuNTg2LDAuMDIxLDMuMzcyLDEuNDY5LDQuMjUyYzEuNDQ4LDAuODgsMy4zMTgsMC42MDQsNC40NTEtMC42NTZsMTQwLjY2Mi0xNTYuNTIzICBDMjM2LjA2LDExMS41NjEsMjM2Ljc0LDEwNy4yNTEsMjM1LjA5NiwxMDMuNTYzeiIgZmlsbD0iI0ZGRkZGRiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K';
	public static function register_settings() {
		register_setting(self::OPTION_NAME,	self::OPTION_NAME,array('type'=> 'array','sanitize_callback' => array( __CLASS__, 'validate_options' ),)
		);
	}
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_menu_items' ) );
		i3geek_mip_function::get_option();
	}
	public function add_menu_items() {
		add_menu_page(__( 'MIP改造设置', 'mip options' ),__( 'MIP改造', 'mip' ),'manage_options',self::OPTION_NAME,array( $this, 'render_screen' ),self::ICON_BASE64_SVG);
		add_settings_section('mip_options',false,'__return_false',self::OPTION_NAME);
		add_settings_field('mip_logo', __( 'logo', 'mip' ),array( $this, 'render_mip_logo' ),self::OPTION_NAME,'mip_options');
		add_settings_field('reform_range',__( '改造范围', 'mip' ),array( $this, 'render_reform_range' ),self::OPTION_NAME,'mip_options');
		add_settings_field('supported_post_types',	__( '允许改造的类型', 'mip' ),array( $this, 'render_post_types_support' ),self::OPTION_NAME,'mip_options');
		add_settings_field('mip_xzh',__( '熊掌号', 'mip' ),array( $this, 'render_mip_xzh' ),self::OPTION_NAME,
			'mip_options');
		add_settings_field('auto_baidu',__( '自动推送至百度', 'mip' ),array( $this, 'render_auto_baidu' ),self::OPTION_NAME,'mip_options');
	}
	public function render_screen() {
		$plugin_data = get_plugin_data( I3GEEK_MIP__FILE__ );
		$i3geek_mip_notice = i3geek_mip_function::get_option();
		if( is_array($i3geek_mip_notice) && $i3geek_mip_notice['version'] > $plugin_data['Version'] ){?>
			<div id="message" class="updated" style="border-left-color: #f0ad4e;background: #fcf8e4;">
			<p>MIP改造 插件已有新版本啦！请更新插件到最新版. <a href=<?php echo '"'.$i3geek_mip_notice['download'].'"'; ?> target="_blank">查看详情</a></p></div>
		<?php
		} if( is_array($i3geek_mip_notice) && $i3geek_mip_notice['msg_switch']==0 ){}else{?>
			<div id="notice_msg" class="updated" style="border-left-color: #00a0d2;background: #f7fcfe;">
            <p><strong>公告</strong>： <?php echo is_array($i3geek_mip_notice)?$i3geek_mip_notice['content']:'请更新插件到最新版，以避免百度处罚，详情查看插件主页：<a href="http://mip.i3geek.com" target="_blank">MIP改造</a>'; ?></p>
           </div>
		<?php } ?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<?php settings_errors(); ?>
			<p><strong>* 启动插件后即完成改造，验证方法：手机端浏览 -> 站点任一文章url后加/mip</strong><br>例如，你的文章链接是http://example.com/archives/123/，那么改造后的MIP页面为http://example.com/archives/123/mip/</p>
			<form action="options.php" method="post">
				<?php
				settings_fields( self::OPTION_NAME );
				do_settings_sections( self::OPTION_NAME );
				// submit_button();
				?>
				<input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改">
				<a href="http://mip.i3geek.com" target="_blank" class="button"> 升级专业版</a>
			</form>
		</div>
		<hr>
		<div style='text-align:center;'>
	      <a href="http://mip.i3geek.com/" target="_blank">插件主页</a> | <a href="http://bbs.i3geek.com/forum.php?mod=forumdisplay&fid=40" target="_blank">插件讨论</a> | <a href="http://bbs.i3geek.com/home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_1&touid=1" target="_blank">联系作者</a> | <a href="http://www.i3geek.com/archives/1979" target="_blank">专业版</a> | <a href="http://bbs.i3geek.com/forum.php?mod=viewthread&tid=13" target="_blank">更新记录</a> | QQ群：194895016
	      <br> Powered by <a href="http://www.i3geek.com" target="_blank">i3geek.com</a>
	    </div>
		<?php
	}
	public function render_mip_logo() {
		$element_name    = self::OPTION_NAME . '[mip_logo]';
		$mip_logo = self::get_option('mip_logo',"");
		wp_enqueue_media();
		?>
			<script>   
		    jQuery(document).ready(function(){   
		    var ashu_upload_frame;   
		    jQuery('.ashu_upload_button').live('click',function(event){   
		        event.preventDefault();   
		        if( ashu_upload_frame ){   
		            ashu_upload_frame.open();   
		            return;   
		        }   
		        ashu_upload_frame = wp.media({   
		            title: 'Insert image',   
		            button: {   
		                text: 'Insert',   
		            },   
		            multiple: false   
		        });   
		        ashu_upload_frame.on('select',function(){   
		            attachment = ashu_upload_frame.state().get('selection').first().toJSON();   
		            jQuery('input[name=\'<?php echo esc_attr( $element_name ); ?>\']').val(attachment.url).trigger('change');   
		        });   
		           
		        ashu_upload_frame.open();   
		    });   
		    });   
	    </script>   
		<fieldset>
				<input type="text" size="60" value="<?php echo $mip_logo;?>" name="<?php echo esc_attr( $element_name ); ?>" class="ashuwp_url_input" id="ashu_upload_input"/><a id="ashu_upload" class="ashu_upload_button button" href="#">上传</a>
				<?php if(!empty($mip_logo)) echo"<br><img src=".$mip_logo."></img>";?>
				<br>
			<p class="description"><?php esc_html_e( '建议上传图片大小：128*42', 'mip' ); ?></p>
		</fieldset>
		<?php
	}
	public function render_post_types_support() {
		$builtin_support = i3geek_mip_function::get_builtin_supported_post_types();
		$element_name    = self::OPTION_NAME . '[supported_post_types][]';
		?>
		<fieldset>
			<?php foreach ( array_map( 'get_post_type_object', i3geek_mip_function::get_eligible_post_types() ) as $post_type ) : ?>
				<?php
				$element_id = self::OPTION_NAME . "-supported_post_types-{$post_type->name}";
				$is_builtin = in_array( $post_type->name, $builtin_support, true );
				?>
				<?php if ( $is_builtin ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $element_name ); ?>" value="<?php echo esc_attr( $post_type->name ); ?>">
				<?php endif; ?>
				<input
					type="checkbox"
					id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>"
					value="<?php echo esc_attr( $post_type->name ); ?>"
					<?php checked( true, post_type_supports( $post_type->name, I3GEEK_MIP_QUERY_VAR ) ); ?>
					<?php disabled( true ); ?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( $post_type->label ); ?>
				</label>
				<br>
			<?php endforeach; ?>
			<p class="description"><?php esc_html_e( '选择插件支持的MIP改造类型[专业版]', 'mip' ); ?></p>
		</fieldset>
		<?php
	}
	public function render_reform_range() {
		$element_name    = self::OPTION_NAME . '[reform_range]';
		$element_id = self::OPTION_NAME . "-reform_range";
		?>
		<fieldset>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="content"
					<?php checked( true ); disabled(true);?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "仅内容页" ); ?>
				</label>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="all"
					<?php checked( false ); disabled(true);?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "全局" ); ?>
				</label>
				<br>
			<p class="description"><?php esc_html_e( '选择插件支持的改造范围[专业版]', 'mip' ); ?></p>
		</fieldset>
		<?php
	}
	public function render_mip_xzh() {
		$element_name    = self::OPTION_NAME . '[mip_xzh]';
		$element_id = self::OPTION_NAME . "-mip_xzh";
		$_value = self::get_option('mip_xzh',"0");
		?>
		<fieldset>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="1"
					<?php checked( false );disabled(true); ?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "开启" ); ?>
				</label>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="0"
					<?php checked( true );disabled(true);?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "关闭" ); ?>
				</label>
				<br>
			<p class="description"><?php esc_html_e( '仅对改造后产生的MIP页面进行熊掌号支持 [专业版]', 'mip' ); ?></p>
		</fieldset>
		<?php
	}
	public function render_auto_baidu() {
		$element_name    = self::OPTION_NAME . '[auto_baidu]';
		$element_id = self::OPTION_NAME . "-auto_baidu";
		$_value = self::get_option('auto_baidu',"0");
		?>
		<fieldset>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="1"
					<?php checked( false );disabled(true); ?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "开启" ); ?>
				</label>
				<input type="radio"	id="<?php echo esc_attr( $element_id ); ?>"
					name="<?php echo esc_attr( $element_name ); ?>" value="0"
					<?php checked( true );disabled(true);?>
					>
				<label for="<?php echo esc_attr( $element_id ); ?>">
					<?php echo esc_html( "关闭" ); ?>
				</label>
				<br>
			<p class="description"><?php esc_html_e( '发布文章时自动推送mip页面至百度收录[专业版]', 'mip' ); ?></p>
		</fieldset>
		<?php
	}
	public static function get_options() {
		return get_option( self::OPTION_NAME, array() );
	}
	public static function get_option( $option, $default = false ) {
		$mip_options = self::get_options();
		if ( ! isset( $mip_options[ $option ] ) ) {
			return $default;
		}
		return $mip_options[ $option ];
	}
	public static function validate_options( $new_options ) {
		$defaults = array(
			'supported_post_types' => array(),
			'reform_range'            => "",
			'mip_logo'			=>"",
		);
		$options = array_merge(
			$defaults,
			self::get_options()
		);
		if ( isset( $new_options['mip_logo'] ) ) {
			$options['mip_logo'] = $new_options['mip_logo'];
		}
		return $options;
	}

}
