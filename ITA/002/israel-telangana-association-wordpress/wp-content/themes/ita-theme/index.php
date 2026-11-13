<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$title = is_search() ? 'Search results for “' . get_search_query() . '”' : ( is_archive() ? get_the_archive_title() : ( is_home() ? 'News & Announcements' : get_bloginfo( 'name' ) ) );
?>
<div class="page-head"><div class="wrap"><h1><?php echo esc_html( $title ); ?></h1></div></div>
<div class="content"><div class="wrap">
	<?php get_search_form(); ?>
	<?php
	$cats = get_categories( array( 'hide_empty' => true, 'exclude' => ( $t = get_term_by( 'slug', 'community-highlights', 'category' ) ) ? array( $t->term_id ) : array() ) );
	if ( $cats ) : ?>
		<ul class="cat-list">
			<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">All</a></li>
			<?php foreach ( $cats as $c ) : ?><li><a href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a></li><?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if ( have_posts() ) : ?>
		<div class="grid"><?php while ( have_posts() ) : the_post();
			if ( 'ita_event' === get_post_type() ) { get_template_part( 'template-parts/card', 'event' ); }
			elseif ( 'ita_album' === get_post_type() ) { get_template_part( 'template-parts/card', 'album' ); }
			elseif ( 'ita_member' === get_post_type() ) { get_template_part( 'template-parts/card', 'member' ); }
			else { get_template_part( 'template-parts/card', 'post' ); }
		endwhile; ?></div>
		<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?></div>
	<?php else : ?>
		<p>Nothing found. Try a different search or category.</p>
	<?php endif; ?>
</div></div>
<?php get_footer(); ?>
