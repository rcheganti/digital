<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<article class="card card--member">
	<div class="card-img"><?php echo ita_thumb( get_the_ID(), 'medium' ); // phpcs:ignore ?></div>
	<div class="card-body">
		<h3><?php the_title(); ?></h3>
		<div class="designation"><?php echo esc_html( get_post_meta( get_the_ID(), '_ita_designation', true ) ); ?></div>
		<?php if ( has_excerpt() ) : ?><p class="card-meta"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
	</div>
</article>
