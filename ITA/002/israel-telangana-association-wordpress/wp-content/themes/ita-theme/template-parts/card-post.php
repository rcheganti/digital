<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<article class="card card--post">
	<a class="card-img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo ita_thumb( get_the_ID() ); // phpcs:ignore ?></a>
	<div class="card-body">
		<?php $cats = get_the_category(); if ( $cats ) : ?><span class="badge"><?php echo esc_html( $cats[0]->name ); ?></span><?php endif; ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="card-meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></div>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
	</div>
</article>
