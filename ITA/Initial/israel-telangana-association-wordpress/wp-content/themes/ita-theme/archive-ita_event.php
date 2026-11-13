<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$up = ita_events_query( 'upcoming', array( 'posts_per_page' => 50 ) );
?>
<div class="page-head"><div class="wrap"><h1>Events</h1><p>Upcoming and recent events of the Israel Telangana Association.</p></div></div>
<div class="content"><div class="wrap">
	<h2 id="upcoming">Upcoming Events</h2>
	<?php if ( $up->have_posts() ) : ?>
		<div class="grid"><?php while ( $up->have_posts() ) : $up->the_post(); get_template_part( 'template-parts/card', 'event' ); endwhile; wp_reset_postdata(); ?></div>
	<?php else : ?><p>No upcoming events at the moment. Please check back soon.</p><?php endif; ?>

	<h2 id="past" style="margin-top:56px">Recent Events</h2>
	<?php if ( have_posts() ) : ?>
		<div class="grid"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/card', 'event' ); endwhile; ?></div>
		<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?></div>
	<?php else : ?><p>No past events yet.</p><?php endif; ?>
</div></div>
<?php get_footer(); ?>
