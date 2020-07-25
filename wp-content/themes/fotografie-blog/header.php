<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fotografie Blog Pro
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' );  ?>

<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fotografie-blog' ); ?></a>

		<header id="masthead" class="site-header" role="banner">

			<div class="site-header-main">
				<div class="wrapper">

					<?php get_template_part( 'components/header/site', 'branding' ); ?>

					<?php get_template_part( 'components/navigation/navigation', 'top' ); ?>

				</div><!-- .wrapper -->
			</div><!-- .site-header-main -->

		</header>

		<div class="below-site-header">

			<div id="site-content-wrapper" class="site-content-contain">

				<?php fotografie_blog_sections(); ?>

				<div id="content" class="site-content">
