<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Hard Cell
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!--meta name="viewport" content="width=device-width, initial-scale=1"-->
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'hardcell-awesome-cooltheme' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-wrapper">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Hard Cell Logo" /></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div><!-- .site-branding -->
		</div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php _e( 'Primary Menu', 'hardcell-awesome-cooltheme' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		
		<div class="cart-account site-wrapper">
			<ul>
				<li><a class="cart" href="<?php echo esc_url( home_url( '/' ) ); ?>cart/">View Cart</a></li>
				<li><a class="account" href="<?php echo esc_url( home_url( '/' ) ); ?>my-account/">My Account</a></li>
			</ul>
			<?php get_search_form(); ?>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
