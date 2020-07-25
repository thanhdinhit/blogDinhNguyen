<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fotografie_Blog
 */

if ( ! function_exists( 'fotografie_blog_get_featured_posts' ) ) :
	/**
	 * Support JetPack featured content
	 */
	function fotografie_blog_get_featured_posts() {
		$type   = 'featured-content';
		$number = get_theme_mod( 'fotografie_blog_featured_content_number', 3 );

		$post_list    = array();

		$args = array(
			'posts_per_page'      => $number,
			'post_type'           => 'post',
			'ignore_sticky_posts' => 1, // ignore sticky posts.
		);

		// Get valid number of posts.
		if ( 'post' === $type || 'page' === $type || 'featured-content' === $type ) {
    		$args['post_type'] = $type;

			for ( $i = 1; $i <= $number; $i++ ) {
				$post_id = '';

				if ( 'post' === $type ) {
					$post_id = get_theme_mod( 'fotografie_blog_featured_content_post_' . $i );
				} elseif ( 'page' === $type ) {
					$post_id = get_theme_mod( 'fotografie_blog_featured_content_page_' . $i );
				} elseif ( 'featured-content' === $type ) {
					$post_id = get_theme_mod( 'fotografie_blog_featured_content_cpt_' . $i );
				}

				if ( $post_id && '' !== $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );
				}
			}

			$args['post__in'] = $post_list;
			$args['orderby']  = 'post__in';
		} elseif ( 'category' === $type && $cat = get_theme_mod( 'fotografie_blog_featured_content_select_category' ) ) {
			$args['category__in'] = $cat;
		}

		$featured_posts = get_posts( $args );

		return $featured_posts;
	}
endif;

if ( ! function_exists( 'fotografie_blog_get_sidebar_id' ) ) :
	function fotografie_blog_get_sidebar_id() {
		$sidebar = '';

		$layout = fotografie_get_theme_layout();

		if ( 'no-sidebar' === $layout ) {
			return $sidebar;
		}

		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$sidebar = 'sidebar-1'; // Primary Sidebar.
		}

		return $sidebar;
	}
endif;

/**
 * Adds custom overlay for Header Media
 */
function fotografie_blog_header_media_image_overlay_css() {
	$overlay = get_theme_mod( 'fotografie_blog_header_media_image_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
		$css = '.custom-header-overlay {
			background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
	    } '; // Dividing by 100 as the option is shown as % for user
}

	wp_add_inline_style( 'fotografie-blog-style', $css );
}
add_action( 'wp_enqueue_scripts', 'fotografie_blog_header_media_image_overlay_css', 11 );

if ( ! function_exists( 'fotografie_blog_sections' ) ) :
	/**
	 * Display Sections on header and footer with respect to the section option set in fotografie_blog_sections_sort
	 */
	function fotografie_blog_sections( $selector = 'header' ) {

				get_template_part( 'components/header/header', 'media' );
				fotografie_featured_slider();
				get_template_part( 'components/features/portfolio/display', 'portfolio' );
				get_template_part( 'components/features/hero-content/content', 'hero' );
				get_template_part( 'components/features/featured-content/display', 'featured' );
				get_template_part( 'components/features/testimonial/display', 'testimonial' );
				get_template_part( 'components/features/service/content', 'service' );
	}
endif;