<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); ?>
<div class="page-head"><div class="wrap">
	<h1><?php the_title(); ?></h1>
	<?php if ( 'post' === get_post_type() ) : ?><p><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time><?php $c = get_the_category(); echo $c ? ' · ' . esc_html( $c[0]->name ) : ''; ?></p>
	<?php elseif ( 'ita_member' === get_post_type() ) : ?><p><?php echo esc_html( get_post_meta( get_the_ID(), '_ita_designation', true ) ); ?></p><?php endif; ?>
</div></div>
<div class="content"><div class="wrap"><article class="entry">
	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large', array( 'class' => 'poster' ) ); } ?>
	<?php the_content(); ?>
	<?php if ( 'post' === get_post_type() ) { the_post_navigation(); } ?>
</article></div></div>
<?php endwhile;
get_footer();
