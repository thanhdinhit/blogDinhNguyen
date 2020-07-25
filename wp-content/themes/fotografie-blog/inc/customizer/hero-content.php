<?php
/**
 * Fotografie Blog Pro Hero Content Options
 * @package Fotografie Blog Pro
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_hero_content_options( $wp_customize ) {
	$wp_customize->remove_section( 'fotografie_hero_content_options' );

	$wp_customize->add_section( 'fotografie_blog_hero_content_options', array(
		'title' => esc_html__( 'Hero Content Options', 'fotografie-blog' ),
		'panel' => 'fotografie_theme_options',
	) );

	$wp_customize->add_setting( 'fotografie_blog_hero_content_visibility', array(
		'default'           => 'disabled',
		'sanitize_callback' => 'fotografie_sanitize_select',
	) );

	$wp_customize->add_control( 'fotografie_blog_hero_content_visibility', array(
		'choices'  => fotografie_section_visibility_options(),
		'label'    => esc_html__( 'Enable on', 'fotografie-blog' ),
		'section'  => 'fotografie_blog_hero_content_options',
		'type'     => 'select',
	) );

	$wp_customize->add_setting( 'fotografie_blog_hero_content', array(
		'default'           => '0',
		'sanitize_callback' => 'fotografie_sanitize_post',
	) );

	$wp_customize->add_control( 'fotografie_blog_hero_content', array(
		'active_callback' => 'fotografie_blog_is_hero_content_active',
		'label'           => esc_html__( 'Page', 'fotografie-blog' ),
		'section'         => 'fotografie_blog_hero_content_options',
		'type'            => 'dropdown-pages',
	) );
}
add_action( 'customize_register', 'fotografie_blog_hero_content_options', 20 );
