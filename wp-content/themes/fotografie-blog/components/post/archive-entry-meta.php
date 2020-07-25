<?php
/**
 * Entry meta display
 *
 * @package Fotografie Blog Pro
 */

?>

<?php if ( 'post' === get_post_type() ) : ?>
	<div class="entry-meta category-date-meta">
		<?php fotografie_blog_entry_categories(); ?>
		<?php fotografie_date(); ?>
	</div><!-- .entry-meta -->
<?php endif;
