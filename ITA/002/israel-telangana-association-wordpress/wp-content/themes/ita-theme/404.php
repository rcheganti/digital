<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="page-head"><div class="wrap"><h1>Page not found</h1></div></div>
<div class="content"><div class="wrap">
	<p>Sorry, we could not find that page. Try searching or go back to the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">home page</a>.</p>
	<?php get_search_form(); ?>
</div></div>
<?php get_footer(); ?>
