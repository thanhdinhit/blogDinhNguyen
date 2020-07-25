<?php
/**
 * Featured/Header Media Template
 *
 * @package Fotografie Blog Pro
 */

if ( ! fotografie_blog_header_media_status() ) {
	return;
}
?>

<div class="custom-header">
	<div class="custom-header-media">
		<?php fotografie_blog_header_media(); ?>

		<?php fotografie_blog_header_media_text(); ?>
	</div><!-- .custom-header-media -->
	<div class="custom-header-overlay"></div><!-- .custom-header-overlay -->
</div><!-- .custom-header -->
