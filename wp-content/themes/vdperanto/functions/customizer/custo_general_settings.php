<?php 
function vdperanto_general_settings( $wp_customize ){

		// copyright text
		$wp_customize->add_setting( 'busiprof_theme_options[footer_copyright_text]', array( 'default' => '<p>'.__( '<a href="https://wordpress.org">Proudly powered by WordPress</a> | Theme: <a href="https://webriti.com" rel="designer">vdperanto</a> by Webriti', 'vdperanto' ).'</p>' , 'type' => 'option', 'sanitize_callback' => 'vdperanto_copyright_sanitize_text' ) );
		$wp_customize->add_control(	'busiprof_theme_options[footer_copyright_text]', 
			array(
				'label'    => __( 'Copyright text','vdperanto' ),
				'section'  => 'footer_copy_section',
				'type'     => 'textarea',
		));

		
		function vdperanto_copyright_sanitize_text( $input ) {

		return wp_kses_post( force_balance_tags( $input ) );

		}
	
		function vdperanto_copyright_sanitize_html( $input ) {

		return force_balance_tags( $input );

		}
		
}
add_action( 'customize_register', 'vdperanto_general_settings' );

/**
 * Add selective refresh for Front page section section controls.
 */
function vdperanto_register_copyright_section_partials( $wp_customize ){

$wp_customize->selective_refresh->add_partial( 'busiprof_theme_options[footer_copyright_text]', array(
		'selector'            => '.site-info .col-md-7 p',
		'settings'            => 'busiprof_theme_options[footer_copyright_text]',
	
	) );
}

add_action( 'customize_register', 'vdperanto_register_copyright_section_partials' );