<?php
/**
 * Fotografie Blog Pro Theme Options
 *
 * @package Fotografie Blog Pro
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_theme_options( $wp_customize ) {
	// Layout Options
	/* Default Layout */
	$wp_customize->get_control( 'fotografie_default_layout' )->choices = array(
		'right-sidebar' => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'fotografie-blog' ),
		'no-sidebar'    => esc_html__( 'No Sidebar', 'fotografie-blog' ),
	);

	$wp_customize->get_setting( 'fotografie_default_layout' )->default = 'right-sidebar';
}
add_action( 'customize_register', 'fotografie_blog_theme_options', 20 );
