<?php
/**
 * Fotografie Blog Pro Theme Customizer
 *
 * @package Fotografie Blog Pro
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fotografie_blog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'fotografie_layout_type' )->default = 'fluid';
	$wp_customize->remove_section( 'Fotografie_Important_Links' );
	$wp_customize->remove_section( 'upgrade_button' );
	$wp_customize->remove_section( 'featured_content' );
	$wp_customize->remove_section( 'fotografie_breadcrumb_options' );
	$wp_customize->remove_control( 'fotografie_portfolio_number' );
	$wp_customize->remove_control( 'fotografie_portfolio_option' );

	$wp_customize->get_setting( 'header_image' )->transport = 'refresh';

	$wp_customize->add_setting( 'fotografie_blog_header_media_option', array(
		'default'           => 'entire-site-page-post',
		'sanitize_callback' => 'fotografie_sanitize_select',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_option', array(
		'choices'           => array(
			'homepage'               => esc_html__( 'Homepage / Frontpage', 'fotografie-blog' ),
			'exclude-home'           => esc_html__( 'Excluding Homepage', 'fotografie-blog' ),
			'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'fotografie-blog' ),
			'entire-site'            => esc_html__( 'Entire Site', 'fotografie-blog' ),
			'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'fotografie-blog' ),
			'pages-posts'            => esc_html__( 'Pages and Posts', 'fotografie-blog' ),
			'disable'                => esc_html__( 'Disabled', 'fotografie-blog' ),
		),
		'label'             => esc_html__( 'Enable on ', 'fotografie-blog' ),
		'section'           => 'header_image',
		'type'              => 'select',
		'priority'          => 1,
	) );

	/* Overlay Option for Header Media */
	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_header_media_image_opacity',
			'default'           => '20',
			'sanitize_callback' => 'fotografie_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'fotografie-blog' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_header_media_content_alignment',
			'default'           => 'content-align-center',
			'sanitize_callback' => 'fotografie_sanitize_select',
			'choices'           => array(
				'content-align-center' => esc_html__( 'Center', 'fotografie-blog' ),
				'content-align-right'  => esc_html__( 'Right', 'fotografie-blog' ),
				'content-align-left'   => esc_html__( 'Left', 'fotografie-blog' ),
			),
			'label'             => esc_html__( 'Content Alignment', 'fotografie-blog' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_header_media_logo',
			'default'           => trailingslashit( esc_url( get_stylesheet_directory_uri() ) ) . 'assets/images/header-media-logo.png',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'fotografie-blog' ),
			'section'           => 'header_image',
		)
	);

	fotografie_blog_register_option( $wp_customize, array(
			'name'              => 'fotografie_blog_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'fotografie_sanitize_select',
			'active_callback'   => 'fotografie_blog_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'fotografie-blog' ),
				'entire-site'            => esc_html__( 'Entire Site', 'fotografie-blog' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'fotografie-blog' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	$wp_customize->add_setting( 'fotografie_blog_header_media_title', array(
		'default'			=> esc_html__( 'Header Media', 'fotografie-blog' ),
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_title', array(
		'label'		=> esc_html__( 'Header Media Title', 'fotografie-blog' ),
		'section'   => 'header_image',
        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'fotografie_blog_header_media_text', array(
		'default'			=> esc_html__( 'This is Header Media Text.', 'fotografie-blog' ),
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_text', array(
		'label'    => esc_html__( 'Header Media Text', 'fotografie-blog' ),
		'section'  => 'header_image',
		'type'     => 'textarea',
	) );

	$wp_customize->add_setting( 'fotografie_blog_header_media_button_text', array(
		'default'			=> esc_html__( 'Explore', 'fotografie-blog' ),
		'sanitize_callback' => 'wp_kses_data',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_button_text', array(
		'label'		=> esc_html__( 'Header Media Link Text', 'fotografie-blog' ),
		'section'   => 'header_image',
        'type'	  	=> 'url',
	) );

	$wp_customize->add_setting( 'fotografie_blog_header_media_button_url', array(
		'default'			=> '#',
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_button_url', array(
		'label'    => esc_html__( 'Header Media Link URL', 'fotografie-blog' ),
		'section'  => 'header_image',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'fotografie_blog_header_media_button_base', array(
		'sanitize_callback' => 'fotografie_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fotografie_blog_header_media_button_base', array(
		'label'    	=> esc_html__( 'Check to Open Link in New Window/Tab', 'fotografie-blog' ),
		'section'  	=> 'header_image',
		'type'     	=> 'checkbox',
	) );

	// Important Links.
	class Fotografie_Blog_Important_Links extends WP_Customize_Control {
		public $type = 'important-links';

		public function render_content() {
			// Add Theme instruction, Support Forum, Changelog, Donate link, Review, Facebook, Twitter, Google+, Pinterest links.
			$important_links = array(
				'theme_instructions' => array(
					'link'  => esc_url( 'https://catchthemes.com/theme-instructions/fotografie-blog-pro/' ),
					'text'  => esc_html__( 'Theme Instructions', 'fotografie-blog' ),
					),
				'support' => array(
					'link'  => esc_url( 'https://catchthemes.com/support/' ),
					'text'  => esc_html__( 'Support', 'fotografie-blog' ),
					),
				'changelog' => array(
					'link'  => esc_url( 'https://catchthemes.com/changelogs/fotografie-blog-pro-theme/' ),
					'text'  => esc_html__( 'Changelog', 'fotografie-blog' ),
					),
				'facebook' => array(
					'link'  => esc_url( 'https://www.facebook.com/catchthemes/' ),
					'text'  => esc_html__( 'Facebook', 'fotografie-blog' ),
					),
				'twitter' => array(
					'link'  => esc_url( 'https://twitter.com/catchthemes/' ),
					'text'  => esc_html__( 'Twitter', 'fotografie-blog' ),
					),
				'gplus' => array(
					'link'  => esc_url( 'https://plus.google.com/+Catchthemes/' ),
					'text'  => esc_html__( 'Google+', 'fotografie-blog' ),
					),
				'pinterest' => array(
					'link'  => esc_url( 'http://www.pinterest.com/catchthemes/' ),
					'text'  => esc_html__( 'Pinterest', 'fotografie-blog' ),
					),
			);

			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . $important_link['text'] . ' </a></p>'; // WPCS: XSS OK.
			}
		}
	}

	/* Hero Content Selector */
	$wp_customize->add_setting( 'fotografie_blog_single_image_position', array(
		'sanitize_callback' => 'fotografie_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'fotografie_blog_single_image_position', array(
		'label'           => esc_html__( 'Use Featured Image as Header image in Single Page/Posts', 'fotografie-blog' ),
		'section'         => 'fotografie_blog_theme_options',
		'type'            => 'checkbox',
	) );

	/* Add option to JetPack Portfolio Section */
	/* Portfolio Number */
	$wp_customize->add_setting( 'fotografie_blog_portfolio_option', array(
		'default'           => 'homepage',
		'sanitize_callback' => 'fotografie_sanitize_select',
	) );

	$wp_customize->add_section( 'fotografie_blog_important_links', array(
		'priority'      => 999,
		'title'         => esc_html__( 'Important Links', 'fotografie-blog' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'fotografie_blog_important_links', array(
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new Fotografie_Blog_Important_Links( $wp_customize, 'fotografie_blog_important_links', array(
		'label'     => esc_html__( 'Important Links', 'fotografie-blog' ),
		'section'   => 'fotografie_blog_important_links',
	) ) );
	//Important Links End

	class Fotografie_Blog_Sortable_Custom_Control extends WP_Customize_Control {
		public $type = 'sortable';

		public $sortable_sections =array();

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 * @uses WP_Customize_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    Optional. Arguments to override class property defaults.
		 */
		public function __construct( $manager, $id, $args = array() ) {

			// Calls the parent __construct
			parent::__construct( $manager, $id, $args );

			// Set Sortable Sections
			$sortable_sections = fotografie_blog_get_sortable_sections();
			$this->sortable_sections = apply_filters( 'customizer_sortable_sections', $sortable_sections, $id );

		}

		/**
		* Render the control's content.
		*/
		public function render_content() {
			$sortable_sections = $this->sortable_sections;
			$sortable_sections = array_merge( array_flip( explode( ',', $this->value() ) ), $sortable_sections );
		?>
			<ul class="custom-sortable">
				<?php
				foreach ( $sortable_sections as $key => $value ) {
					echo '<li id="' . esc_attr( $key ) . '" >';
					echo '<span class="label">' . esc_html( $value['label'] ) . '</span>';
					if ( isset( $value['section'] ) ) {
						echo '<a href="javascript:wp.customize.section( \'' . esc_attr( $value['section'] ) . '\' ).focus();">' . esc_html__( 'Edit', 'fotografie-blog' ) . '</a>';
					}
					echo '</li>';
				}
			    ?>
			</ul>

			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
		<?php
		}
	}
}
add_action( 'customize_register', 'fotografie_blog_customize_register', 20 );

/**
 * Include Theme Options
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/theme-options.php';

/**
 * Include Hero Content
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/hero-content.php';

/**
 * Include Featured Slider
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/featured-slider.php';

/**
 * Include Featured Content
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/featured-content.php';

/**
 * Include Services
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/service.php';

/**
 * Include Testimonial
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/testimonial.php';

/**
 * Include Portfolio
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/portfolio.php';

/**
 * Include Customizer Helper Functions
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/helpers.php';

/**
 * Include Active Callback functions
 */
require trailingslashit( get_stylesheet_directory() ) . 'inc/customizer/active-callbacks.php';

/**
 * Function to reset date with respect to condition
 */
function fotografie_blog_reset_data() {
	if ( get_theme_mod( 'fotografie_blog_reset_all_settings' ) ) {
		remove_theme_mods();

		return;
	}
}
add_action( 'customize_save_after', 'fotografie_blog_reset_data' );

/**
 * Alphabetically sort theme options sections
 *
 * Override Parent function
 *
 * @param  wp_customize object $wp_customize wp_customize object.
 */
function fotografie_sort_sections_list( $wp_customize ) {
	foreach ( $wp_customize->sections() as $section_key => $section_object ) {
		if ( ( false !==  strpos( $section_key, 'fotografie_' ) || false !==  strpos( $section_key, 'fotografie_blog_' ) ) && 'fotografie_reset_all' !== $section_key ) {
			$options[] = $section_key;
		}
	}

	foreach ( $options as $option ) {
		$sections[$option] =  $wp_customize->get_section( $option )->title;
	}

	asort( $sections );

	$priority = 1;
	foreach ( $sections as $key=> $value ) {
		$wp_customize->get_section( $key )->priority = $priority++;
	}
}

/**
 * Remove action of parent theme and add it in child theme so that the hook executes later
 * @return [type] [description]
 */
function fotografie_blog_sort_sections_list() {
	remove_action( 'customize_register', 'fotografie_sort_sections_list' );
	add_action( 'customize_register', 'fotografie_sort_sections_list', 20 );
}
add_action( 'init', 'fotografie_blog_sort_sections_list' );

if ( ! function_exists( 'fotografie_blog_customize_preview_js' ) ) :
	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	function fotografie_blog_customize_preview_js() {
		wp_enqueue_script( 'fotografie-blog-customize-preview', get_stylesheet_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview' ), '20171219', true );
	}
endif;
add_action( 'customize_preview_init', 'fotografie_blog_customize_preview_js' );

if( ! function_exists( 'fotografie_blog_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since Fotografie Blog Pro 1.0
	*/
	function fotografie_blog_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'fotografie_blog_header_media_logo' )->value();
		if( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
