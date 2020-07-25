<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Fotografie
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
    // Featured image
    if ( false != $atts['image'] ) {
        if( function_exists( 'essential_content_pro_get_featured_content_thumbnail_link' ) ) {
            echo essential_content_pro_get_featured_content_thumbnail_link( get_the_ID(), $atts['image_size'] );
        } else {
            echo essential_content_get_featured_content_thumbnail_link( get_the_ID(), 'ect-featured-content' );
        }
    }
    ?>
	<header class="featured-content-entry-header entry-header">
		<h2 class="featured-content-entry-title entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( the_title_attribute( ) ); ?>"><?php the_title(); ?></a></h2>
		<?php if ( false != $atts['display_types'] || false != $atts['display_tags'] || false != $atts['display_author'] ) : ?>
            <div class="featured-content-entry-meta entry-meta">
            <?php
            // Use Pro plugin's class
            if( class_exists( 'Essential_Content_Pro_Featured_Content' ) ) {
                if ( false != $atts['display_types'] ) {
                    echo Essential_Content_Pro_Featured_Content::get_content_type( get_the_ID() );
                }

                if ( false != $atts['display_tags'] ) {
                    echo Essential_Content_Pro_Featured_Content::get_content_tags( get_the_ID() );
                }

                if ( false != $atts['display_author'] ) {
                    echo Essential_Content_Pro_Featured_Content::get_content_author( get_the_ID() );
                }
            } else { // Use Free plugin's class
                if ( false != $atts['display_types'] ) {
                    echo Essential_Content_Featured_Content::get_content_type( get_the_ID() );
                }

                if ( false != $atts['display_tags'] ) {
                    echo Essential_Content_Featured_Content::get_content_tags( get_the_ID() );
                }

                if ( false != $atts['display_author'] ) {
                    echo Essential_Content_Featured_Content::get_content_author( get_the_ID() );
                }
            }
            ?>
            </div>
        <?php endif; ?>
	</header>
</article>
