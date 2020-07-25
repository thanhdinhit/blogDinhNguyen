<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Fotografie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="hentry">
	<?php
    	// Featured image
    	if( function_exists( 'essential_content_pro_get_portfolio_thumbnail_link' ) ) {
	    	echo essential_content_pro_get_portfolio_thumbnail_link( get_the_ID(), $atts['image_size'] );
	    } else {
	    	echo essential_content_get_portfolio_thumbnail_link( get_the_ID(), 'ect-jetpack-portfolio' );
	    }
    ?>
	<header class="portfolio-entry-header entry-header">
		<h2 class="portfolio-entry-title entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( the_title_attribute( ) ); ?>"><?php the_title(); ?></a></h2>

		<?php if ( false != $atts['display_types'] || false != $atts['display_tags'] || false != $atts['display_author'] ) : ?>
	        <div class="portfolio-entry-meta entry-meta">
		        <?php
		        if( class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) ) {
			        if ( false != $atts['display_types'] ) {
			            echo Essential_Content_Pro_Jetpack_Portfolio::get_project_type( get_the_ID() );
			        }

			        if ( false != $atts['display_tags'] ) {
			            echo Essential_Content_Pro_Jetpack_Portfolio::get_project_tags( get_the_ID() );
			        }

			        if ( false != $atts['display_author'] ) {
			            echo Essential_Content_Pro_Jetpack_Portfolio::get_project_author( get_the_ID() );
			        }
			    } else {
			    	if ( false != $atts['display_types'] ) {
			            echo Essential_Content_Jetpack_Portfolio::get_project_type( get_the_ID() );
			        }

			        if ( false != $atts['display_tags'] ) {
			            echo Essential_Content_Jetpack_Portfolio::get_project_tags( get_the_ID() );
			        }

			        if ( false != $atts['display_author'] ) {
			            echo Essential_Content_Jetpack_Portfolio::get_project_author( get_the_ID() );
			        }
			    }
		        ?>
	        </div>
	    <?php endif; ?>
	</header>
</article>
