<?php
/**
 * The template for displaying featured content
 *
 * @package Fotografie Blog Pro
 */

$enable_content = get_theme_mod( 'fotografie_blog_featured_content_option', 'disabled' );

if ( ! fotografie_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$featured_posts = fotografie_blog_get_featured_posts();

if ( empty( $featured_posts ) ) {
	return;
}

$title     = get_option( 'featured_content_title', esc_html__( 'Featured Content', 'fotografie-blog' ) );
$sub_title = get_option( 'featured_content_content' );

$layout    = 'layout-three';
?>

<div id="featured-content-section" class="section layout-three">
	<div class="wrapper">
		<?php if ( '' !== $title || $sub_title ) : ?>
			<div class="blog-section-headline section-heading-wrap">
				<?php if ( '' !== $title ) : ?>
					<div class="page-title-wrapper">
						<h2 class="page-title section-title"><?php echo wp_kses_post( $title ); ?></h2>
					</div><!-- .page-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="taxonomy-description-wrapper">
						<p class="taxonomy-description section-subtitle"><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .taxonomy-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<div class="featured-content-wrapper layout-three">

			<?php
				foreach ( $featured_posts as $post ) {
					setup_postdata( $post );

					// Include the featured content template.
					get_template_part( 'components/features/featured-content/content', 'featured' );
				}

				wp_reset_postdata();
			?>
		</div><!-- .featured-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
