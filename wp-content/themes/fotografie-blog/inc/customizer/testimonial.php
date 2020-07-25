<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Fotografie Blog Pro
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options for this theme, go %1$shere%2$s', 'fotografie-blog' ),
                '<a href="javascript:wp.customize.section( \'fotografie_blog_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'fotografie_blog_testimonials', array(
            'panel'    => 'fotografie_theme_options',
            'title'    => esc_html__( 'Testimonials', 'fotografie-blog' ),
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
            'name'              => 'fotografie_blog_testimonial_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'active_callback'   => 'fotografie_blog_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'fotografie-blog' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'fotografie_blog_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_testimonial_option',
            'default'           => 'disabled',
            'sanitize_callback' => 'fotografie_sanitize_select',
            'active_callback'   => 'fotografie_blog_is_ect_testimonial_active',
            'choices'           => fotografie_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'fotografie-blog' ),
            'section'           => 'fotografie_blog_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Fotografie_Note_Control',
            'active_callback'   => 'fotografie_blog_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'fotografie-blog' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'fotografie_blog_testimonials',
            'type'              => 'description',
        )
    );

    fotografie_blog_register_option( $wp_customize, array(
            'name'              => 'fotografie_blog_testimonial_number',
            'default'           => '3',
            'sanitize_callback' => 'fotografie_sanitize_number_range',
            'active_callback'   => 'fotografie_blog_is_testimonial_active',
            'label'             => esc_html__( 'Number of items to show', 'fotografie-blog' ),
            'section'           => 'fotografie_blog_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'fotografie_blog_testimonial_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        fotografie_blog_register_option( $wp_customize, array(
                'name'              => 'fotografie_blog_testimonial_cpt_' . $i,
                'sanitize_callback' => 'fotografie_sanitize_post',
                'active_callback'   => 'fotografie_blog_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'fotografie-blog' ) . ' ' . $i ,
                'section'           => 'fotografie_blog_testimonials',
                'type'              => 'select',
                'choices'           => fotografie_blog_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'fotografie_blog_testimonial_options', 20 );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'fotografie_blog_is_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Fotografie Blog Pro 1.0
    */
    function fotografie_blog_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'fotografie_blog_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( fotografie_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'fotografie_blog_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Catch Store 1.0
    */
    function fotografie_blog_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

if ( ! function_exists( 'fotografie_blog_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Catch Store 1.0
    */
    function fotografie_blog_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;
