<?php
/**
 * The template for displaying portfolio items
 *
 * @package Catch_Store
 */
?>

<?php
$enable = get_theme_mod( 'fotografie_blog_portfolio_option', 'disabled' );

if ( ! fotografie_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

	$headline   = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'fotografie-blog' ) );
	$subheadline = get_option( 'jetpack_portfolio_content' );

$classes[] = 'section';

$classes[] = 'layout-three';
?>
<div id="portfolio-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $headline || $subheadline ) : ?>
			<div class="blog-section-headline section-heading-wrap">
			<?php if ( $headline ) : ?>
				<div class="page-title-wrapper">
						<h2 class="page-title section-title"><?php echo wp_kses_post( $headline ); ?></h2>
				</div><!-- .section-title-wrapper -->
			<?php endif; ?>

			<?php if ( $subheadline ) : ?>
				<div class="taxonomy-description-wrapper">
					<?php
	                $subheadline = apply_filters( 'the_content', $subheadline );
	                echo str_replace( ']]>', ']]&gt;', $subheadline );
	                ?>
				</div><!-- .taxonomy-description-wrapper -->
			<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="portfolio-wrapper <?php echo esc_attr( $layout ); ?>">
			<?php
			get_template_part( 'components/features/portfolio/post-types', 'portfolio' );
			?>
		</div><!-- .portfolio-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #portfolio-content-section -->
