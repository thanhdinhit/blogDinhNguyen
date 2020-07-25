<?php
/**
 * Header Media display
 *
 * @package Corporate Fotografie Pro
 */

if ( ! function_exists( 'fotografie_blog_header_media' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own fotografie_blog_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_header_media() {
		global $post, $wp_query;
		$enable = get_theme_mod( 'fotografie_blog_header_media_option', 'entire-site-page-post' );

		// Get Page ID outside Loop
		$page_id = absint( $wp_query->get_queried_object_id() );

		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'fotografie-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			} elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				fotografie_blog_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				fotografie_blog_featured_image();
			}
		} elseif ( 'exclude-home' === $enable ) {
			// Check Excluding Homepage
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			} else {
				fotografie_blog_featured_image();
			}
		} elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			} elseif ( is_page() || is_single() ) {
				fotografie_blog_featured_page_post_image();
			} else {
				fotografie_blog_featured_image();
			}
		} elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			fotografie_blog_featured_image();
		} elseif ( 'entire-site-page-post' === $enable ) {
			// Check Entire Site (Post/Page)
			if ( is_page() || is_single() || ( is_home() && $page_for_posts === $page_id ) ) {
				fotografie_blog_featured_page_post_image();
			} else {
				fotografie_blog_featured_image();
			}
		} elseif ( 'pages-posts' === $enable ) {
			// Check Page/Post
			if ( is_page() || is_single() ) {
				fotografie_blog_featured_page_post_image();
			}
		}
	} // fotografie_blog_header_media
endif;

if ( ! function_exists( 'fotografie_blog_header_media_status' ) ) :
	/**
	 * Return true to display header media, otherwise false.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_header_media_status() {
		global $post, $wp_query;
		$enable = get_theme_mod( 'fotografie_blog_header_media_option', 'entire-site-page-post' );

		// Get Page ID outside Loop
		$page_id = absint( $wp_query->get_queried_object_id() );

		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'fotografie-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			} elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				return true;
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return true;
			}
		} elseif ( 'exclude-home' === $enable ) {
			// Check Excluding Homepage
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			} else {
				return true;
			}
		} elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) {
				return false;
			} elseif ( is_page() || is_single() ) {
				return true;
			} else {
				return true;
			}
		} elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return true;
		} elseif ( 'entire-site-page-post' === $enable ) {
			// Check Entire Site (Post/Page)
			if ( is_page() || is_single() || ( is_home() && $page_for_posts === $page_id ) ) {
				return true;
			} else {
				return true;
			}
		} elseif ( 'pages-posts' === $enable ) {
			// Check Page/Post
			if ( is_page() || is_single() ) {
				return true;
			}
		}

		return false;
	} // fotografie_blog_header_media
endif;

if ( ! function_exists( 'fotografie_blog_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own fotografie_blog_featured_image(), and that function will be used instead.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_featured_image() {
		if ( has_custom_header() ) {
			the_custom_header_markup();
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) {
			$jetpack_portfolio_featured_image = get_option( 'jetpack_portfolio_featured_image' );
			if ( '' !== $jetpack_portfolio_featured_image ) {
				echo wp_get_attachment_image( (int) $jetpack_portfolio_featured_image, 'fotografie-header-image' );
			}
		}
	} // fotografie_blog_featured_image
endif;

if ( ! function_exists( 'fotografie_blog_featured_image_status' ) ) :
	/**
	 * Return true if featured image is enabled, else false.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_featured_image_status() {
		if ( has_custom_header() ) {
			return true;
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) {
			$jetpack_portfolio_featured_image = get_option( 'jetpack_portfolio_featured_image' );
			if ( '' !== $jetpack_portfolio_featured_image ) {
				return true;
			}
		}

		return false;
	} // fotografie_blog_featured_image
endif;

if ( ! function_exists( 'fotografie_blog_featured_page_post_image' ) ) :
	/**
	 * Return true if featured image is enabled, else false.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_featured_page_post_image() {
		if ( is_front_page() && is_home() ) {
			fotografie_blog_featured_image();

			return;
		}

		if ( is_singular( 'product' ) &&  get_theme_mod( 'fotografie_blog_header_media_disable_on_products' ) ) {
			// Disable header image on single products page is option is set in theme options.
			return false;
		}

		if ( has_post_thumbnail() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
				if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'fotografie-blog-header-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'fotografie-blog-header-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				echo '<!-- Header Image Disabled from Metabox -->';
				return false;
			} else { ?>
			<div id="wp-custom-header" class="wp-custom-header">
				<img src="<?php the_post_thumbnail_url( 'fotografie-header-image' ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" class="custom-header">
			</div><!-- #wp-custom-header -->
			<?php
			}
		} else {
			fotografie_blog_featured_image();
		}
	} // fotografie_blog_featured_page_post_image
endif;

if ( ! function_exists( 'fotografie_blog_featured_page_post_image_status' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own fotografie_blog_featured_page_post_image(), and that function will be used instead.
	 *
	 * @since Fotografie Blog Pro 1.0
	 */
	function fotografie_blog_featured_page_post_image_status() {
		if ( is_front_page() && is_home() ) {
			return fotografie_blog_featured_image_status();
		}

		if ( is_singular( 'product' ) &&  get_theme_mod( 'fotografie_blog_header_media_disable_on_products' ) ) {
			// Disable header image on single products page is option is set in theme options.
			return false;
		}

		if ( has_post_thumbnail() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
				if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'fotografie-blog-header-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'fotografie-blog-header-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				return false;
			} 

			return true;
		} else {
			return fotografie_blog_featured_image_status();
		}
	} // fotografie_blog_featured_page_post_image
endif;
