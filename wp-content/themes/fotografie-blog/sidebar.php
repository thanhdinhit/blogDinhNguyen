<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fotografie Blog Pro
 */

$sidebar = fotografie_blog_get_sidebar_id();

if ( '' === $sidebar ) {
	return;
}

?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- #secondary -->
