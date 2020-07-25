<?php
/**
 * Active callbacks for Theme/Customzer Options
 *
 * @package Fotografie Blog Pro
 */

if ( ! function_exists( 'fotografie_blog_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_hero_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option( 'page_for_posts' );

		$enable = $control->manager->get_setting( 'fotografie_blog_hero_content_visibility' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable  || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;

if( ! function_exists( 'fotografie_blog_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_slider_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'fotografie_blog_slider_option' )->value();

		//return true only if previwed page on customizer matches the type of slider option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;

if( ! function_exists( 'fotografie_blog_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_featured_content_active( $control ) {
		global $wp_query;

		$page_id = $wp_query->get_queried_object_id();

		// Front page display in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		$enable = $control->manager->get_setting( 'fotografie_blog_featured_content_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( 'entire-site' == $enable || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enable ) );
	}
endif;

if ( ! function_exists( 'fotografie_blog_is_ect_featured_content_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Fotografie Blog Pro 1.0
    */
    function fotografie_blog_is_ect_featured_content_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;
if ( ! function_exists( 'fotografie_blog_is_ect_featured_content_active' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Fotografie Blog Pro 1.0
    */
    function fotografie_blog_is_ect_featured_content_active( $control ) {
        return ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;

if( ! function_exists( 'fotografie_blog_is_homepage_posts_enabled' ) ) :
	/**
	* Return true if hommepage posts/content is enabled
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_homepage_posts_enabled( $control ) {
		return ( ! $control->manager->get_setting( 'fotografie_blog_disable_homepage_posts' )->value() );
	}
endif;
