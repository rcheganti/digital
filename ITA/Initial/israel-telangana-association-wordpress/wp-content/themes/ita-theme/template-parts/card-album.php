<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$count = count( ita_gallery_ids( get_the_ID() ) );
?>
<article class="card card--album">
	<a class="card-img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true"><?php echo ita_thumb( get_the_ID() ); // phpcs:ignore ?></a>
	<div class="card-body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="card-meta"><?php echo esc_html( $count ); ?> photo<?php echo 1 === $count ? '' : 's'; ?></div>
	</div>
</article>
