<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Fotografie
 */

?>

<section class="no-results not-found">
	<header class="page-header entry-header">
		<h1 class="page-title entry-title"><?php esc_html_e( 'Nothing Found', 'fotografie' ); ?></h1>
	</header>
	<div class="page-content entry-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php
			printf(
				esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'fotografie' ),
				'<a href="' . esc_url( admin_url( 'post-new.php' ) ) . '">',
			'</a>' );
			?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fotografie' ); ?></p>
			<?php
				get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fotografie' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div>
</section><!-- .no-results -->
