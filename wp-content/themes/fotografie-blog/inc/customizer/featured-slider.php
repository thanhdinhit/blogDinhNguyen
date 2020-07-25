<?php
/**
 * Fotografie Blog Pro Featured Slider Options
 * @package Fotografie Blog Pro
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_slider_options( $wp_customize ) {
	$wp_customize->remove_section( 'fotografie_featured_slider' );

	$wp_customize->add_section( 'fotografie_blog_featured_slider', array(
		'panel' => 'fotografie_theme_options',
		'title' => esc_html__( 'Featured Slider', 'fotografie-blog' ),
	) );

	$wp_customize->add_setting( 'fotografie_blog_slider_option', array(
		'default'			=> 'disabled',
		'sanitize_callback' => 'fotografie_sanitize_select',
	) );

	$wp_customize->add_control( 'fotografie_blog_slider_option', array(
		'choices'   => fotografie_section_visibility_options(),
		'label'    	=> esc_html__( 'Enable on', 'fotografie-blog' ),
		'section'  	=> 'fotografie_blog_featured_slider',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'fotografie_blog_slider_number', array(
		'default'			=> '4',
		'sanitize_callback'	=> 'fotografie_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fotografie_blog_slider_number' , array(
			'active_callback' => 'fotografie_blog_is_slider_active',
			'description'     => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'fotografie-blog' ),
			'input_attrs'     => array(
				'style' => 'width: 45px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
				),
			'label'    		=> esc_html__( 'No of Slides', 'fotografie-blog' ),
			'section'  		=> 'fotografie_blog_featured_slider',
			'type'	   		=> 'number',
			'transport'		=> 'postMessage',
		)
	);

	$slider_number = get_theme_mod( 'fotografie_blog_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		$wp_customize->add_setting( 'fotografie_blog_slider_page_' . $i, array(
			'sanitize_callback'	=> 'fotografie_sanitize_post',
		) );

		$wp_customize->add_control( 'fotografie_blog_slider_page_' . $i, array(
			'active_callback'	=> 'fotografie_blog_is_slider_active',
			'label'    	=> esc_html__( 'Page', 'fotografie-blog' ) . ' # ' . $i,
			'section'  	=> 'fotografie_blog_featured_slider',
			'type'	   	=> 'dropdown-pages',
		) );
	} // End for().
}
add_action( 'customize_register', 'fotografie_blog_slider_options', 20 );


/**
 * Returns an array of Display Content option registered for Fotografie.
 *
 * @since Fotografie Blog Pro 1.0
 */
function fotografie_blog_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'fotografie-blog' ),
		'full-content' => esc_html__( 'Full Content', 'fotografie-blog' ),
		'hide-content' => esc_html__( 'Hide Content', 'fotografie-blog' ),
	);
	return apply_filters( 'fotografie_blog_content_show', $options );
}
