<?php
/**
 * Template for displaying search forms
 *
 * @package Fotografie
 */

$search_text = get_theme_mod( 'fotografie_search_text', esc_html__( 'Enter keyword&hellip;', 'fotografie' ) );
?>


<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'fotografie' ); ?></span>

		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( $search_text, 'placeholder', 'fotografie' ); ?>" value="<?php the_search_query(); ?>" name="s" />
	</label>

	<button type="submit" class="search-submit"><span class="search-button-text"><?php echo esc_html_x( 'Search', 'submit button', 'fotografie' ); ?></span></button>
</form>
