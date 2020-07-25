<?php
/**
 * Footer meta for archive pages
 * Display author and comment
 * @package Fotografie Blog Pro
 */

?>

<?php if ( ! is_single() && ! post_password_required() ) : ?>
	<footer class="entry-footer entry-meta">
		<?php fotografie_blog_entry_author(); ?>
		<?php if ( comments_open() || get_comments_number() ) :
			fotografie_blog_entry_comment(); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
<?php endif;

