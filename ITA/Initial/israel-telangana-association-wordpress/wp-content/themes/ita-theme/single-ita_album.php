<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); $ids = ita_gallery_ids( get_the_ID() ); ?>
<div class="page-head"><div class="wrap"><h1><?php the_title(); ?></h1><p><?php echo esc_html( count( $ids ) ); ?> photos</p></div></div>
<div class="content"><div class="wrap">
	<div class="entry"><?php the_content(); ?></div>
	<?php ita_render_gallery( $ids ); ?>
	<p><a href="<?php echo esc_url( get_post_type_archive_link( 'ita_album' ) ); ?>">← All albums</a></p>
</div></div>
<?php endwhile;
get_footer();
