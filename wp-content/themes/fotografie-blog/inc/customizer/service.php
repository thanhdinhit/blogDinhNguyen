<?php
/**
* The template for adding Service Settings in Customizer
*
 * @package Fotografie Blog Pro
*/

function fotografie_blog_service_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'label'             => sprintf( esc_html__( 'For Service Options for this theme, go %1$shere%2$s', 'fotografie-blog' ),
                 '<a href="javascript:wp.customize.section( \'fotografie_blog_service\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'ect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'fotografie_blog_service', array(
			'panel' => 'fotografie_theme_options',
			'title' => esc_html__( 'Service', 'fotografie-blog' ),
		)
	);

	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'fotografie_sanitize_select',
			'choices'           => fotografie_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'fotografie-blog' ),
			'section'           => 'fotografie_blog_service',
			'type'              => 'select',
		)
	);

	fotografie_blog_register_option( $wp_customize, array(
				'name'              => 'fotografie_blog_service_number',
				'default'           => 6,
				'sanitize_callback' => 'fotografie_sanitize_number_range',
				'active_callback'   => 'fotografie_blog_is_service_active',
				'description'       => esc_html__( 'Save and refresh the page if No. of Service is changed', 'fotografie-blog' ),
				'input_attrs'       => array(
					'style' => 'width: 100px;',
					'min'   => 0,
				),
				'label'             => esc_html__( 'No of Service', 'fotografie-blog' ),
				'section'           => 'fotografie_blog_service',
				'type'              => 'number',
		)
	);

	$number = get_theme_mod( 'fotografie_blog_service_number', 6 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		//for CPT
		fotografie_blog_register_option( $wp_customize, array(
				'name'              => 'fotografie_blog_service_cpt_' . $i,
				'sanitize_callback' => 'fotografie_sanitize_post',
				'default'           => 0,
				'active_callback'   => 'fotografie_blog_is_service_active',
				'label'             => esc_html__( 'Service ', 'fotografie-blog' ) . ' ' . $i ,
				'section'           => 'fotografie_blog_service',
				'type'              => 'select',
				'choices'           => fotografie_blog_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'fotografie_blog_service_options', 20 );

if ( ! function_exists( 'fotografie_blog_is_service_active' ) ) :
	/**
	* Return true if service is active
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_service_active( $control ) {
		$enable = $control->manager->get_setting( 'fotografie_blog_service_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( fotografie_check_section( $enable ) );
	}
endif;
