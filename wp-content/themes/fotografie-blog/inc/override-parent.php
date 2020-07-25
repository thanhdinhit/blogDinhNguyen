<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Fotografie Blog Pro
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * Override Parent functions
 * @param array $classes Classes for the body element.
 * @return array
 */
function fotografie_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	// Adds a class of (full-width|box) to blogs.
	if ( 'boxed' === get_theme_mod( 'fotografie_layout_type' ) ) {
		$classes[] = 'boxed-layout';
	} else {
		$classes[] = 'fluid-layout';
	}

	// Adds a class with respect to layout selected.
	$layout  = fotografie_get_theme_layout();

	$sidebar = fotografie_blog_get_sidebar_id();

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	return $classes;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Override Parent function
 */
function fotografie_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fotografie_content_width', 1000 );
}

/**
 * Set up the WordPress core custom header feature.
 *
 * Overwriting parent theme custom header
 */
function fotografie_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'fotografie_custom_header_args', array(
		'default-image'      => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
		'default-text-color' => 'ffffff',
		'width'              => 1920,
		'height'             => 1080,
		'flex-height'        => true,
		'flex-width'         => true,
		'wp-head-callback'   => 'fotografie_header_style',
		'video'              => true,
	) ) );

	register_default_headers( array(
		'blond' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header.jpg',
			'description'   => esc_html__( 'Blond', 'fotografie-blog' ),
		),
		'closeup' => array(
			'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/header2-thumb.jpg',
			'url'           => get_stylesheet_directory_uri() . '/assets/images/header2.jpg',
			'description'   => esc_html__( 'Closeup', 'fotografie-blog' ),
		),
	) );
}

/**
 * Register Google fonts for Fotografie Pro.
 *
 * Create your own fotografie_fonts_url() function to override in a child theme.
 *
 * Override Parent Function
 *
 * @since Fotografie Blog Pro 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function fotografie_fonts_url() {
	$fonts_url = '';

		/* Translators: If there are characters in your language that are not
		* supported by Montserrat, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$raleway = _x( 'on', 'Raleway: on or off', 'fotografie-blog' );

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$source_sans = _x( 'on', 'Source Sans Pro font: on or off', 'fotografie-blog' );

		if ( 'off' !== $raleway || 'off' !== $source_sans ) {
			$font_families = array();

			if ( 'off' !== $raleway ) {
			$font_families[] = 'Raleway:300,300i,400,400i,700,700i';
			}

			if ( 'off' !== $source_sans ) {
			$font_families[] = 'Source Sans Pro:300,300i,400,400i,700,700i';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
}

/**
 * Add slider.
 *
 * @uses action hook fotografie_before_content.
 *
 * @since Fotografie Blog Pro 1.0
 */
function fotografie_featured_slider() {
	$enable_slider = get_theme_mod( 'fotografie_blog_slider_option', 'disabled' );

	if ( fotografie_check_section( $enable_slider ) ) {
		$transition_effect = 'fade';
		$transition_length = 1;
		$transition_delay  = 4;
		$image_loader      = true;

		$output = '
			<div id="feature-slider" class="section">
				<div class="wrapper">
					<div class="cycle-slideshow"
						data-cycle-log="false"
						data-cycle-pause-on-hover="true"
						data-cycle-swipe="true"
						data-cycle-auto-height=container
						data-cycle-fx="' . esc_attr( $transition_effect ) . '"
						data-cycle-speed="' . esc_attr( $transition_length * 1000 ) . '"
						data-cycle-timeout="' . esc_attr( $transition_delay * 1000 ) . '"
						data-cycle-loader=false
						data-cycle-slides="> article"
						>

						<!-- prev/next links -->
						<button class="cycle-prev" aria-label="Previous"><span class="screen-reader-text">' . esc_html__( 'Previous Slide', 'fotografie-blog' ) . '</span>
						</button>

						<button class="cycle-next" aria-label="Next"><span class="screen-reader-text">' . esc_html__( 'Next Slide', 'fotografie-blog' ) . '</span></button>

						<!-- empty element for pager links -->
						<div class="cycle-pager"></div>';
						// Select Slider
			$output .= fotografie_post_page_category_slider();

		$output .= '
					</div><!-- .cycle-slideshow -->
				</div><!-- .wrapper -->
			</div><!-- #feature-slider -->';

		echo $output;
	} // End if().
}

/**
 * Page Post Category Slider
 */
function fotografie_post_page_category_slider() {
	$quantity     = get_theme_mod( 'fotografie_blog_slider_number', 4 );
	$no_of_post   = 0; // for number of posts
	$post_list    = array();// list of valid post/page ids
	$output     = '';

	$args = array(
		'post_type'           => 'any',
		'orderby'             => 'post__in',
		'ignore_sticky_posts' => 1, // ignore sticky posts
	);

	//Get valid number of posts
		for ( $i = 1; $i <= $quantity; $i++ ) {
			$post_id = '';

				$post_id = get_theme_mod( 'fotografie_blog_slider_page_' . $i );

			if ( $post_id && '' !== $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}

		$args['post__in'] = $post_list;

	if ( ! $no_of_post ) {
		return;
	}

	$args['posts_per_page'] = $no_of_post;

	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) :
		$loop->the_post();

		$title_attribute = the_title_attribute( 'echo=0' );

		if ( 0 === $loop->current_post ) {
			$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displayblock';
		} else {
			$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displaynone';
		}

		// Default value if there is no featurd image or first image.
		$image_url = trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb-1920x1080.jpg';

		if ( has_post_thumbnail() ) {
			$image_url = get_the_post_thumbnail_url( get_the_ID(), 'fotografie-slider' );
		} else {
			// Get the first image in page, returns false if there is no image.
			$first_image_url = fotografie_get_first_image( get_the_ID(), 'fotografie-slider', '', true );

			// Set value of image as first image if there is an image present in the page.
			if ( $first_image_url ) {
				$image_url = $first_image_url;
			}
		}

		$output .= '
		<article class="' . $classes . '">';
			$output .= '
			<div class="slider-image-wrapper">
				<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
						<img src="' . esc_url( $image_url ) . '" class="wp-post-image" alt="' . $title_attribute . '">
					</a>
			</div><!-- .slider-image-wrapper -->

			<div class="slider-content-wrapper">
				<div class="entry-container">
					<header class="entry-header">
						<h2 class="entry-title">
							<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">' . the_title( '<span>','</span>', false ) . '</a>
						</h2>
					</header>
						';

			$excerpt = get_the_excerpt();

			$output .= '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';

					$output .= '
				</div><!-- .entry-container -->
			</div><!-- .slider-content-wrapper -->
		</article><!-- .slides -->';
	endwhile;

	wp_reset_postdata();

	return $output;
}

/**
 * Register widgetized area
 *
 * @since Fotografie Blog Pro 1.0
 */
function fotografie_widgets_init() {
	//Primary Sidebar
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fotografie-blog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'fotografie-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'fotografie-blog' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'fotografie-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'fotografie-blog' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'fotografie-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'fotografie-blog' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'fotografie-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	if ( class_exists( 'Catch_Instagram_Feed_Gallery_Widget' ) ||  class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Instagram', 'fotografie-blog' ),
			'id'            => 'sidebar-instagram',
			'description'   => esc_html__( 'Appears above footer. This sidebar is only for Widget from plugin Catch Instagram Feed Gallery Widget and Catch Instagram Feed Gallery Widget Pro', 'fotografie-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );
	}
}
add_action( 'widgets_init', 'fotografie_widgets_init' );

/**
 * Template for Featured Image in Archive Content
 *
 * @since Fotografie Blog Pro 1.0
 */
function fotografie_blog_content_image() {
	if ( has_post_thumbnail() && ! get_theme_mod( 'fotografie_blog_single_image_position' ) && fotografie_jetpack_featured_image_display() && is_singular() ) {
		global $post, $wp_query;

		// Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();

		if ( $post ) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;

				$individual_featured_image = get_post_meta( $parent, 'fotografie-blog-single-image', true );
			} else {
				$individual_featured_image = get_post_meta( $page_id, 'fotografie-blog-single-image', true );
			}
		}

		if ( empty( $individual_featured_image ) ) {
			$individual_featured_image = 'default';
		}

		if ( 'disable' === $individual_featured_image ) {
			echo '<!-- Page/Post Single Image Disabled from Metabox Options-->';
			return false;
		} else {
			$class = array();

			$image_size = get_theme_mod( 'fotografie_blog_single_layout', 'disabled' );

			if ( 'disabled' === $image_size ) {
				echo '<!-- Page/Post Single Image Disabled from Theme Options-->';
				return false;
			}

			if ( 'default' !== $individual_featured_image ) {
				$image_size = $individual_featured_image;
				$class[]    = 'from-metabox';
			}

			$class[] = $image_size;
			?>
			<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
				<?php the_post_thumbnail( $image_size ); ?>
			</div>
	   	<?php
		}
	} // End if().
}
