<?php
/*
 * Template Name: No Sidebar
 *
 * Template Post Type: post, page
 *
 * The template for displaying Page/Post with No Sidebar.
 *
 * @package Fotografie Blog Pro
 */

get_header(); ?>

	<div class="wrapper singular-section">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php
				while ( have_posts() ) : the_post();

					if ( 'page' === get_post_type() ) {
						get_template_part( 'components/page/content', 'page' );
					} else {
						get_template_part( 'components/post/content', 'single' );
					}

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile; // End of the loop.
				?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .wrapper -->
<?php
get_footer();
