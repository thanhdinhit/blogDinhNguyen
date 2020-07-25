<?php
/**
 * Add Featured Content options
 *
 * @package Fotografie Blog Pro
 */

/**
 * Add featured content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_featured_content_options( $wp_customize ) {
	// Add note to ECT Featured Content Section
	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_featured_content_ect_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Fotografie_Note_Control',
			'label'             => sprintf( esc_html__( 'For all Featured Content Options for this theme, go %1$shere%2$s', 'fotografie-blog' ),
				'<a href="javascript:wp.customize.section( \'fotografie_blog_featured_content\' ).focus();">',
				 '</a>'
			),
		   'section'            => 'ect_featured_content',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$action = 'install-plugin';
	$slug   = 'essential-content-types';

	$install_url = wp_nonce_url(
	    add_query_arg(
	        array(
	            'action' => $action,
	            'plugin' => $slug
	        ),
	        admin_url( 'update.php' )
	    ),
	    $action . '_' . $slug
	);

	// Add note to ECT Featured Content Section
    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_featured_content_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'active_callback'   => 'fotografie_blog_is_ect_featured_content_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Featured Content, install %1$sEssential Content Types%2$s Plugin with Featured Content Type Enabled', 'fotografie-blog' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'fotografie_blog_featured_content',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'fotografie_blog_featured_content', array(
		'panel' => 'fotografie_theme_options',
		'title' => esc_html__( 'Featured Content', 'fotografie-blog' ),
	) );

	$wp_customize->add_setting( 'fotografie_blog_featured_content_option', array(
		'default'			=> 'disabled',
		'sanitize_callback' => 'fotografie_sanitize_select',
	) );

	$wp_customize->add_control( 'fotografie_blog_featured_content_option', array(
		'active_callback'	=> 'fotografie_blog_is_ect_featured_content_active',
		'choices'  			=> fotografie_section_visibility_options(),
		'label'    			=> esc_html__( 'Enable on', 'fotografie-blog' ),
		'section'  			=> 'fotografie_blog_featured_content',
		'type'	  			=> 'select',
	) );

	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_featured_content_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Fotografie_Note_Control',
			'active_callback'   => 'fotografie_blog_is_featured_content_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
	  'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'fotografie-blog' ),
				 '<a href="javascript:wp.customize.control( \'featured_content_title\' ).focus();">',
				 '</a>'
			),
			'section'           => 'fotografie_blog_featured_content',
			'type'              => 'description',
		)
	);

	$wp_customize->add_setting( 'fotografie_blog_featured_content_number', array(
		'default'			=> 3,
		'sanitize_callback'	=> 'fotografie_sanitize_number_range',
	) );

	$wp_customize->add_control( 'fotografie_blog_featured_content_number' , array(
			'active_callback' => 'fotografie_blog_is_featured_content_active',
			'description'     => esc_html__( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'fotografie-blog' ),
			'input_attrs'     => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'           => esc_html__( 'No of Featured Content', 'fotografie-blog' ),
			'section'         => 'fotografie_blog_featured_content',
			'type'            => 'number',
			'transport'       => 'postMessage',
		)
	);

	$number = get_theme_mod( 'fotografie_blog_featured_content_number', 3 );

	//loop for featured post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		$wp_customize->add_setting( 'fotografie_blog_featured_content_cpt_' . $i, array(
		  'sanitize_callback' => 'fotografie_sanitize_post',
		) );

		$wp_customize->add_control( 'fotografie_blog_featured_content_cpt_' . $i, array(
		  'active_callback' => 'fotografie_blog_is_featured_content_active',
		  'label'           => esc_html__( 'Custom Post #', 'fotografie-blog' ) . ' ' . $i ,
		  'section'         => 'fotografie_blog_featured_content',
		  'type'            => 'select',
		  'choices'         => fotografie_blog_generate_post_array( 'featured-content' ),
		) );
	} // End for().
}
add_action( 'customize_register', 'fotografie_blog_featured_content_options', 20 );

/**
 * Returns an array of featured content options
 *
 * @since Fotografie Blog Pro 1.0
 */
function fotografie_blog_featured_content_layout_options() {
	$options = array(
		'layout-two'   => esc_html__( '2 columns', 'fotografie-blog' ),
		'layout-three' => esc_html__( '3 columns', 'fotografie-blog' ),
		'layout-four'  => esc_html__( '4 columns', 'fotografie-blog' ),
	);

	return apply_filters( 'fotografie_blog_featured_content_layout_options', $options );
}
