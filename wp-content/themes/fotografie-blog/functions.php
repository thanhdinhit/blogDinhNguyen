<?php
/**
 * Components functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fotografie Blog Pro
 */

if ( ! function_exists( 'fotografie_blog_setup' ) ) :
	/**
	 * Loads the child theme textdomain and update notifier.
	 */
	function fotografie_blog_setup() {
	    load_child_theme_textdomain( 'fotografie-blog', get_stylesheet_directory() . '/languages' );

		register_nav_menus( array(
			'menu-1'  => esc_html__( 'Primary Menu', 'fotografie-blog' ),
		) );

		/** Override Parent Image Sizes */
		set_post_thumbnail_size( 1083, 542, true );

		add_image_size( 'fotografie-hero-image', 725, 725, true );
	}
endif;
add_action( 'after_setup_theme', 'fotografie_blog_setup', 11 );

if ( ! function_exists( 'fotografie_blog_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function fotografie_blog_scripts() {
		/* If using a child theme, auto-load the parent theme style. */
		if ( is_child_theme() ) {
			wp_enqueue_style( 'fotografie-style', trailingslashit( esc_url( get_template_directory_uri() ) ) . 'style.css' );
		}

		/* Always load active theme's style.css. */
		wp_enqueue_style( 'fotografie-blog-style', get_stylesheet_uri() );

		wp_enqueue_script( 'fotografie-blog-global', get_stylesheet_directory_uri() . '/assets/js/global.min.js', array( 'jquery' ), '1.0', true );

		//Slider Scripts
		$enable_slider      = get_theme_mod( 'fotografie_blog_slider_option', 'disabled' );
		$enable_testimonial = get_theme_mod( 'fotografie_blog_testimonial_option', 'disabled' );

		//Slider Scripts
		if ( fotografie_check_section( $enable_slider ) || fotografie_check_section( $enable_testimonial ) ) {
			wp_enqueue_script( 'jquery-cycle2', get_stylesheet_directory_uri() . '/assets/js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

			/**
			 * Condition checks for additional slider transition plugins
			 */
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'fotografie_blog_scripts' );

if ( ! function_exists( 'fotografie_blog_entry_categories' ) ) :
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function fotografie_blog_entry_categories() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'fotografie-blog' ) );
		if ( $categories_list && fotografie_categorized_blog() ) {
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html__( 'Categories: ', 'fotografie-blog' ) . '</span>' . $categories_list . '</span>'; // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'fotografie_blog_entry_author' ) ) :
	/**
	 * Prints HTML with meta information for the author.
	 */
	function fotografie_blog_entry_author() {
		$byline = sprintf(
			/* translators: used between spans and before author */
			esc_html_x( '%1$sby%2$s%3$s', 'post author', 'fotografie-blog' ),
			'<span class="screen-reader-text">',
			' </span>',
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'fotografie_blog_entry_comment' ) ) :
	/**
	 * Prints HTML with meta information for the comment.
	 */
	function fotografie_blog_entry_comment() {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'fotografie-blog' ), esc_html__( '1 Comment', 'fotografie-blog' ), esc_html__( '% Comments', 'fotografie-blog' ) );
		echo '</span>';
	}
endif;

if ( ! function_exists( 'fotografie_blog_header_media_text' ) ) :
	/**
	 * Display Header Media Text
	 * @return void
	 */
	function fotografie_blog_header_media_text() {
		$content_alignment = get_theme_mod( 'fotografie_blog_header_media_content_alignment', 'content-align-center' );

		$title    = get_theme_mod( 'fotografie_blog_header_media_title', esc_html__( 'Header Media', 'fotografie-blog' ) );
		$text     = get_theme_mod( 'fotografie_blog_header_media_text', esc_html__( 'This is Header Media Text.', 'fotografie-blog' ) );
		$url      = get_theme_mod( 'fotografie_blog_header_media_button_url', '#' );
		$url_text = get_theme_mod( 'fotografie_blog_header_media_button_text', esc_html__( 'Explore', 'fotografie-blog' ) );
		$base     = get_theme_mod( 'fotografie_blog_header_media_button_base' );
		$target   = '_self';

		if ( '' != $url ) {
			//support for qtranslate custom link
			if ( function_exists( 'qtrans_convertURL' ) ) {
				$url = qtrans_convertURL( $url );
			}

			//Checking Link Target
			if ( $base ) {
				$target = '_blank';
			}
		}

		$enable_homepage_logo = get_theme_mod( 'fotografie_blog_header_media_logo_option', 'homepage' );

		$header_media_logo = get_theme_mod( 'fotografie_blog_header_media_logo', trailingslashit( esc_url( get_stylesheet_directory_uri() ) ) . 'assets/images/header-media-logo.png' );

		if ( '' !== $title || '' !== $text || '' !== $url || fotografie_check_section( $enable_homepage_logo ) ) : ?>
			<div class="custom-header-content section header-media-section <?php echo esc_attr( $content_alignment ); ?>">
				<?php
				if ( fotografie_check_section( 'homepage' ) && $header_media_logo ) {
				?>
					<div class="site-header-logo">
						<img src="<?php echo esc_url( $header_media_logo ); ?>" title="<?php echo esc_url( home_url( '/' ) ); ?>" />
					</div><!-- .site-header-logo -->
				<?php } ?>

				<div class="custom-header-content-wrapper">
					<?php if ( '' !== $title ) : ?>
						<h2 class="entry-title section-title"><?php echo wp_kses_post( $title ); ?></h2>
					<?php endif; ?>

					<p class="site-header-text"><?php echo wp_kses_post( $text ); ?>
					
					<?php if( $url_text ) : ?>	
						<span class="header-button"><a href="<?php echo esc_url( $url ); ?>" target="<?php echo $target; // WPCS: XSS OK. ?>" class="button"><?php echo wp_kses_data( $url_text ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $title ); ?></span></a></span>
					<?php endif; ?>

				</div><!-- .custom-header-content-wrapper -->
			</div>
		<?php endif;
	}
endif; // fotografie_blog_header_media_text().

if ( ! function_exists( 'fotografie_blog_custom_background_parameters' ) ) :
	/**
	 * Change Custom background default color
	 * @param  array $params parent theme Custom Background parameters
	 * @return array Modified child theme Custom Background Parameters
	 */
	function fotografie_blog_custom_background_parameters( $params ) {
		$params['default-color'] = '#1a1a1a';
		return $params;
	}
endif;
add_filter( 'fotografie_custom_background_args', 'fotografie_blog_custom_background_parameters' );

if ( ! function_exists( 'fotografie_blog_custom_header_parameters' ) ) :
	/**
	 * Change Custom header default color
	 * @param  array $params parent theme Custom Background parameters
	 * @return array Modified child theme Custom Background Parameters
	 */
	function fotografie_blog_custom_header_parameters( $params ) {
		$params['default-text-color'] = '#ffffff';
		return $params;
	}
endif;
add_filter( 'fotografie_custom_header_args', 'fotografie_blog_custom_header_parameters' );

/**
 * Load Customizer Options
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/customizer.php';

/**
 * Override Parent Functions
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/override-parent.php';

/**
 * Load Upgrade to pro button
 */
require trailingslashit( get_stylesheet_directory() ) . 'class-customize.php';

/**
 * Add metabox
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/metabox/metabox.php';

/**
 * Service include
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/service.php';

/**
 * Header Media Include
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/header-media.php';

/**
 * Template Functions
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/template-functions.php';

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function fotografie_blog_register_required_plugins() {

	$plugins = array(
			// Catch Web Tools.
			array(
				'name' => 'Catch Web Tools', // Plugin Name, translation not required.
				'slug' => 'catch-web-tools',
			),
			// Catch IDs
			array(
				'name' => 'Catch IDs', // Plugin Name, translation not required.
				'slug' => 'catch-ids',
			),
			// To Top.
			array(
				'name' => 'To top', // Plugin Name, translation not required.
				'slug' => 'to-top',
			),
			// Catch Gallery.
			array(
				'name' => 'Catch Gallery', // Plugin Name, translation not required.
				'slug' => 'catch-gallery',
			),
		);

		if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
			$plugins[] = array(
				'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
				'slug' => 'catch-infinite-scroll',
			);
		}

		if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
			$plugins[] = array(
				'name' => 'Essential Content Types', // Plugin Name, translation not required.
				'slug' => 'essential-content-types',
			);
		}

		if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
			$plugins[] = array(
				'name' => 'Essential Widgets', // Plugin Name, translation not required.
				'slug' => 'essential-widgets',
			);
		}

		if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
			$plugins[] = array(
				'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
				'slug' => 'catch-instagram-feed-gallery-widget',
			);
		}
		if ( ! class_exists( 'Catch_Breadcrumb_Pro' ) ) {
			$plugins[] = array(
				'name' => 'Catch Breadcrumb', // Plugin Name, translation not required.
				'slug' => 'catch-breadcrumb',
			);
		}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'fotografie-blog',        // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'fotografie_blog_register_required_plugins' );
