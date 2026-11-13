<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post();
	$info = ita_event_info( get_the_ID() );
	$st   = ita_event_statuses();
	$ids  = ita_gallery_ids( get_the_ID() );
	?>
<div class="page-head"><div class="wrap"><h1><?php the_title(); ?></h1><p><?php echo esc_html( ita_event_when( $info ) ); ?></p></div></div>
<div class="content"><div class="wrap"><article class="entry">
	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'class' => 'poster' ) ); } ?>
	<div class="event-facts">
		<p><strong>When:</strong> <?php echo esc_html( ita_event_when( $info ) ); ?></p>
		<?php if ( $info['location'] ) : ?><p><strong>Where:</strong> <?php echo esc_html( $info['location'] ); ?></p><?php endif; ?>
		<p><strong>Status:</strong> <?php echo esc_html( 'scheduled' === $info['status'] ? ( $info['is_past'] ? 'Past event' : 'Upcoming' ) : $st[ $info['status'] ] ); ?></p>
		<?php if ( $info['reg_url'] && ! $info['is_past'] && 'scheduled' === $info['status'] ) : ?>
			<p><a class="btn" href="<?php echo esc_url( $info['reg_url'] ); ?>" target="_blank" rel="noopener">Register now</a></p>
		<?php endif; ?>
	</div>
	<?php the_content(); ?>
	<?php if ( $ids ) : ?><h2>Event photos</h2><?php ita_render_gallery( $ids ); endif; ?>
	<p><a href="<?php echo esc_url( get_post_type_archive_link( 'ita_event' ) ); ?>">← All events</a></p>
</article></div></div>
<?php
	// Event structured data for search engines.
	if ( $info['start_ts'] ) {
		$ld = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Event',
			'name'        => get_the_title(),
			'startDate'   => wp_date( 'c', $info['start_ts'] ),
			'eventStatus' => 'cancelled' === $info['status'] ? 'https://schema.org/EventCancelled' : ( 'postponed' === $info['status'] ? 'https://schema.org/EventPostponed' : 'https://schema.org/EventScheduled' ),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'url'         => get_permalink(),
		);
		if ( $info['end_ts'] ) { $ld['endDate'] = wp_date( 'c', $info['end_ts'] ); }
		if ( $info['location'] ) { $ld['location'] = array( '@type' => 'Place', 'name' => $info['location'] ); }
		if ( has_post_thumbnail() ) { $ld['image'] = get_the_post_thumbnail_url( null, 'large' ); }
		echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
endwhile;
get_footer();
