<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); ?>
<div class="page-head"><div class="wrap"><h1><?php the_title(); ?></h1></div></div>
<div class="content"><div class="wrap"><article class="entry"><?php the_content(); ?></article></div></div>
<?php endwhile;
get_footer();
