<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
	<div class="wrap header-in">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) { echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => esc_attr( get_bloginfo( 'name' ) ) ) ); } ?>
			<span class="brand-name"><?php bloginfo( 'name' ); ?><small><?php bloginfo( 'description' ); ?></small></span>
		</a>
		<button class="nav-toggle" aria-controls="site-nav" aria-expanded="false">Menu</button>
		<nav class="main-nav" id="site-nav" aria-label="Primary">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => function () {
						echo '<ul><li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li></ul>';
					},
				)
			);
			?>
		</nav>
	</div>
</header>
<main id="main">
