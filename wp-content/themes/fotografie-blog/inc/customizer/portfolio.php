<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Fotografie_Blog
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_portfolio_options( $wp_customize ) {
    // Add note to Jetpack Portfolio Section
    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'label'             => sprintf( esc_html__( 'For Portfolio Options for this theme, go %1$shere%2$s', 'fotografie-blog' ),
                 '<a href="javascript:wp.customize.section( \'fotografie_blog_portfolio\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'jetpack_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'fotografie_blog_portfolio', array(
            'panel'    => 'fotografie_theme_options',
            'title'    => esc_html__( 'Portfolio', 'fotografie-blog' ),
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
            'name'              => 'fotografie_blog_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'active_callback'   => 'fotografie_blog_is_ect_portfolio_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Type Enabled', 'fotografie-blog' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'fotografie_blog_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'fotografie_sanitize_select',
            'active_callback'   => 'fotografie_blog_is_ect_portfolio_active',
			'choices'           => fotografie_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'fotografie-blog' ),
			'section'           => 'fotografie_blog_portfolio',
			'type'              => 'select',
		)
	);

    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'active_callback'   => 'fotografie_blog_is_portfolio_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'fotografie-blog' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'fotografie_blog_portfolio',
            'type'              => 'description',
        )
    );

    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_portfolio_number',
            'default'           => '3',
            'sanitize_callback' => 'fotografie_sanitize_number_range',
            'active_callback'   => 'fotografie_blog_is_portfolio_active',
            'label'             => esc_html__( 'Number of items to show', 'fotografie-blog' ),
            'section'           => 'fotografie_blog_portfolio',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'fotografie_blog_portfolio_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        fotografie_blog_register_option( $wp_customize, array(
                'name'              => 'fotografie_blog_portfolio_cpt_' . $i,
                'sanitize_callback' => 'fotografie_sanitize_post',
                'active_callback'   => 'fotografie_blog_is_portfolio_active',
                'label'             => esc_html__( 'Portfolio', 'fotografie-blog' ) . ' ' . $i ,
                'section'           => 'fotografie_blog_portfolio',
                'type'              => 'select',
                'choices'           => fotografie_blog_generate_post_array( 'jetpack-portfolio' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'fotografie_blog_portfolio_options', 20 );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'fotografie_blog_is_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Fotografie Blog Pro 1.0
    */
    function fotografie_blog_is_portfolio_active( $control ) {
        $enable = $control->manager->get_setting( 'fotografie_blog_portfolio_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( fotografie_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'fotografie_blog_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function fotografie_blog_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'fotografie_blog_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function fotografie_blog_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
