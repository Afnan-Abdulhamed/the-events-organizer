<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * 
 * @package events-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/assets/styles/app.css'?>">
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'events-theme' ); ?></a>

	<header id="masthead" class="site-header header navbar navbar-expand-md">
		<div class="site-branding container">
			<!-- logo  -->
			<a class="navbar-brand logo" href="#">
				 <img src=" <?php echo get_template_directory_uri()?> /assets/images/logo.png"> 
        	</a>
			
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'events-theme' ); ?></button>
			<?php
			// wp_nav_menu( array(
			// 	'theme_location' => 'menu-1',
			// 	'menu_id'        => 'primary-menu',
			// 	'menu_class' => 'nav navbar-nav menu',
			// ) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
