<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$info = ita_event_info( get_the_ID() );
?>
<article class="card card--event">
	<a class="card-img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo ita_thumb( get_the_ID() ); // phpcs:ignore ?></a>
	<div class="card-body">
		<?php if ( 'scheduled' !== $info['status'] ) : $st = ita_event_statuses(); ?>
			<span class="badge badge--warn"><?php echo esc_html( $st[ $info['status'] ] ); ?></span>
		<?php elseif ( $info['is_past'] ) : ?>
			<span class="badge badge--past">Past event</span>
		<?php else : ?>
			<span class="badge">Upcoming</span>
		<?php endif; ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="card-meta"><?php echo esc_html( ita_event_when( $info ) ); ?></div>
		<?php if ( $info['location'] ) : ?><div class="card-meta">📍 <?php echo esc_html( $info['location'] ); ?></div><?php endif; ?>
	</div>
</article>
