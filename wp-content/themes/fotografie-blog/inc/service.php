<?php
/**
 * The template for displaying Services
 *
 * @package Fotografie Blog Pro
 */



if ( ! function_exists( 'fotografie_blog_service_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook fotografie_blog_before_content.
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_service_display() {
		$output = '';

		// get data value from options
		$enable_content = get_theme_mod( 'fotografie_blog_service_option', 'disabled' );

		if ( fotografie_check_section( $enable_content ) ) {
			$content_select = 'ect-service';
			$layout        	= 'layout-three';
			$headline     = get_option( 'ect_service_title', esc_html__( 'Services ', 'fotografie-blog' ) );
			$subheadline = get_option( 'ect_service_content' );
			$classes[] = 'section';
			$classes[] = $content_select;
			$classes[] = $layout;

			$output = '
				<div id="service-content-section" class="' . esc_attr( implode( ' ', $classes ) ) . '">
					<div class="wrapper">';

						if ( ! empty( $headline ) || ! empty( $subheadline ) ) {
							$output .= '<div class="blog-section-headline section-heading-wrap">';

							if ( ! empty( $headline ) ) {
								$output .= '<div class="page-title-wrapper"><h2 class="page-title section-title">' . wp_kses_post( $headline ) . '</h2></div>';
							}

							if ( ! empty( $subheadline ) ) {
								$output .= '<div class="taxonomy-description-wrapper"><p class="taxonomy-description section-subtitle">' . wp_kses_post( $subheadline ) . '</p></div>';
							}

							$output .= '
							</div><!-- .section-heading-wrapper -->';
						}
						$output .= '
							<div class="service-content-wrapper section-content-wrapper ' . esc_attr( $layout ). '">';
									$output .= fotografie_blog_post_page_category_service();

						$output .= '
							</div><!-- .service-content-wrapper -->
					</div><!-- .wrapper -->
			</div><!-- #service-content-section -->';

		}

		echo $output;
	}
endif;
add_action( 'fotografie_blog_service', 'fotografie_blog_service_display', 10 );


if ( ! function_exists( 'fotografie_blog_post_page_category_service' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @param $options: fotografie_blog_theme_options from customizer
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_post_page_category_service() {
		global $post;

		$quantity   = get_theme_mod( 'fotografie_blog_service_number', 6 );
		$post_list  = array();// list of valid post/page ids
		$output     = '';

		$args = array(
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);

		//Get valid number of posts
			$args['post_type'] = 'ect-service';

			for ( $i = 1; $i <= $quantity; $i++ ) {
				$post_id = '';

					$post_id = get_theme_mod( 'fotografie_blog_service_cpt_' . $i );

				if ( $post_id && '' !== $post_id ) {
					// Polylang Support.
					if ( class_exists( 'Polylang' ) ) {
						$post_id = pll_get_post( $post_id, pll_current_language() );
					}

					$post_list = array_merge( $post_list, array( $post_id ) );

				}
			}

			$args['post__in'] = $post_list;

		$args['posts_per_page'] = $quantity;

		$loop     = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$i = absint( $loop->current_post + 1 );

			$output .= '
				<article id="service-post-' . $i . '" class="status-publish has-post-thumbnail hentry ect-service">';

				// Default value if there is no first image
				$image = '<img class="wp-post-image" src="' . trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg" >';

				if ( has_post_thumbnail() ) {
					$image = get_the_post_thumbnail( $post->ID, 'fotografie-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
				}
				else {
					// Get the first image in page, returns false if there is no image.
					$first_image = fotografie_get_first_image( $post->ID, 'fotografie-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

					// Set value of image as first image if there is an image present in the page.
					if ( $first_image ) {
						$image = $first_image;
					}
				}

				$output .= '
					<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
						'. $image . '
					</a>
					<div class="entry-container">';

					$output .= the_title( '<header class="entry-header"><h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></header><!-- .entry-header -->', false );
					//Show Excerpt
					$output .= '
						<div class="entry-summary"><p>' . get_the_excerpt() . '</p></div><!-- .entry-summary -->';
				$output .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-' . $i . ' -->';
			} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // fotografie_blog_post_page_category_service
