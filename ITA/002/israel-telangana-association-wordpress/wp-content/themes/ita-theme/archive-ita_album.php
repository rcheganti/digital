<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="page-head"><div class="wrap"><h1>Photo Gallery</h1><p>Moments from our events and celebrations.</p></div></div>
<div class="content"><div class="wrap">
	<?php if ( have_posts() ) : ?>
		<div class="grid"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/card', 'album' ); endwhile; ?></div>
		<div class="pagination"><?php the_posts_pagination(); ?></div>
	<?php else : ?><p>No albums yet.</p><?php endif; ?>
</div></div>
<?php get_footer(); ?>
