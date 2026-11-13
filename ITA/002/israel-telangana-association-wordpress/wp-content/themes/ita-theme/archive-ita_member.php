<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header(); ?>
<div class="page-head"><div class="wrap"><h1>Our Committee</h1><p>The office bearers and committee members serving our community.</p></div></div>
<div class="content"><div class="wrap">
	<?php if ( have_posts() ) : ?>
		<div class="grid"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/card', 'member' ); endwhile; ?></div>
	<?php else : ?><p>No committee members added yet.</p><?php endif; ?>
</div></div>
<?php get_footer(); ?>
