<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

$hero_id  = (int) ita_opt( 'hero_image' );
$hero_img = $hero_id ? wp_get_attachment_image_url( $hero_id, 'ita-hero' ) : '';
$btn_url  = ita_opt( 'hero_btn_url' );
if ( ! $btn_url && function_exists( 'ita_events_query' ) ) {
	$btn_url = get_post_type_archive_link( 'ita_event' );
}
$missing = ! defined( 'ITA_CORE_VERSION' );
$contact = get_page_by_path( 'contact-us' );
?>
<section class="hero<?php echo $hero_img ? ' has-img' : ''; ?>"<?php echo $hero_img ? ' style="background-image:url(' . esc_url( $hero_img ) . ')"' : ''; ?>>
	<div class="wrap">
		<?php if ( has_custom_logo() ) { echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'medium', false, array( 'class' => 'hero-logo', 'alt' => esc_attr( get_bloginfo( 'name' ) ) ) ); } ?>
		<h1><?php echo esc_html( ita_opt( 'hero_title', get_bloginfo( 'name' ) ) ); ?></h1>
		<?php if ( ita_opt( 'hero_text' ) ) : ?><p><?php echo esc_html( ita_opt( 'hero_text' ) ); ?></p><?php endif; ?>
		<div class="btns">
			<?php if ( $btn_url ) : ?><a class="btn btn--alt" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( ita_opt( 'hero_btn_text', 'Learn more' ) ); ?></a><?php endif; ?>
			<?php $about = get_page_by_path( 'about-us' ); if ( $about ) : ?><a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( $about ) ); ?>">About us</a><?php endif; ?>
		</div>
	</div>
</section>

<?php if ( $missing ) : ?>
	<div class="wrap section"><p class="notice-box">Please activate the <strong>ITA Core</strong> plugin to show events, gallery and committee.</p></div>
<?php else : ?>

<?php if ( ita_opt( 'intro_text' ) ) : ?>
<section class="section section--white">
	<div class="wrap">
		<div class="section-head"><h2><?php echo esc_html( ita_opt( 'intro_title', 'About us' ) ); ?></h2></div>
		<p class="intro"><?php echo esc_html( ita_opt( 'intro_text' ) ); ?></p>
		<p>
			<?php if ( $about ) : ?><a class="btn" href="<?php echo esc_url( get_permalink( $about ) ); ?>">About Us</a><?php endif; ?>
			<a class="btn btn--alt" href="<?php echo esc_url( get_post_type_archive_link( 'ita_event' ) ); ?>">Events</a>
			<a class="btn btn--alt" href="<?php echo esc_url( get_post_type_archive_link( 'ita_album' ) ); ?>">Gallery</a>
			<?php $contact = get_page_by_path( 'contact-us' ); if ( $contact ) : ?><a class="btn btn--alt" href="<?php echo esc_url( get_permalink( $contact ) ); ?>">Contact Us</a><?php endif; ?>
		</p>
	</div>
</section>
<?php endif; ?>

<?php
// Latest news & announcements (excludes highlights).
$hl_term = get_term_by( 'slug', 'community-highlights', 'category' );
$news    = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => false,
		'category__not_in'    => $hl_term ? array( $hl_term->term_id ) : array(),
	)
);
if ( $news->have_posts() ) : ?>
<section class="section">
	<div class="wrap">
		<div class="section-head"><h2>Latest News &amp; Announcements</h2><a class="more-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">All news →</a></div>
		<div class="grid"><?php while ( $news->have_posts() ) : $news->the_post(); get_template_part( 'template-parts/card', 'post' ); endwhile; wp_reset_postdata(); ?></div>
	</div>
</section>
<?php endif; ?>

<?php $up = ita_events_query( 'upcoming', array( 'posts_per_page' => 3 ) ); ?>
<section class="section section--white">
	<div class="wrap">
		<div class="section-head"><h2>Upcoming Events</h2><a class="more-link" href="<?php echo esc_url( get_post_type_archive_link( 'ita_event' ) ); ?>#upcoming">All events →</a></div>
		<?php if ( $up->have_posts() ) : ?>
			<div class="grid"><?php while ( $up->have_posts() ) : $up->the_post(); get_template_part( 'template-parts/card', 'event' ); endwhile; wp_reset_postdata(); ?></div>
		<?php else : ?><p>No upcoming events right now. Please check back soon.</p><?php endif; ?>
	</div>
</section>

<?php $past = ita_events_query( 'past', array( 'posts_per_page' => 3 ) ); if ( $past->have_posts() ) : ?>
<section class="section">
	<div class="wrap">
		<div class="section-head"><h2>Recent Events</h2><a class="more-link" href="<?php echo esc_url( get_post_type_archive_link( 'ita_event' ) ); ?>#past">All recent events →</a></div>
		<div class="grid"><?php while ( $past->have_posts() ) : $past->the_post(); get_template_part( 'template-parts/card', 'event' ); endwhile; wp_reset_postdata(); ?></div>
	</div>
</section>
<?php endif; ?>

<?php $hl = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'category_name' => 'community-highlights' ) );
if ( $hl->have_posts() ) : ?>
<section class="section section--tint">
	<div class="wrap">
		<div class="section-head"><h2>Community Activities &amp; Highlights</h2></div>
		<div class="grid"><?php while ( $hl->have_posts() ) : $hl->the_post(); get_template_part( 'template-parts/card', 'post' ); endwhile; wp_reset_postdata(); ?></div>
	</div>
</section>
<?php endif; ?>

<?php $albums = new WP_Query( array( 'post_type' => 'ita_album', 'posts_per_page' => 3 ) );
if ( $albums->have_posts() ) : ?>
<section class="section section--white">
	<div class="wrap">
		<div class="section-head"><h2>Photo Gallery</h2><a class="more-link" href="<?php echo esc_url( get_post_type_archive_link( 'ita_album' ) ); ?>">All albums →</a></div>
		<div class="grid"><?php while ( $albums->have_posts() ) : $albums->the_post(); get_template_part( 'template-parts/card', 'album' ); endwhile; wp_reset_postdata(); ?></div>
	</div>
</section>
<?php endif; ?>

<?php $members = new WP_Query( array( 'post_type' => 'ita_member', 'posts_per_page' => 6, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) );
if ( $members->have_posts() ) : ?>
<section class="section">
	<div class="wrap">
		<div class="section-head"><h2>Our Committee</h2><a class="more-link" href="<?php echo esc_url( get_post_type_archive_link( 'ita_member' ) ); ?>">Meet the team →</a></div>
		<div class="grid"><?php while ( $members->have_posts() ) : $members->the_post(); get_template_part( 'template-parts/card', 'member' ); endwhile; wp_reset_postdata(); ?></div>
	</div>
</section>
<?php endif; ?>

<section class="section contact-strip">
	<div class="wrap">
		<div class="section-head"><h2 style="color:#fff">Get in touch</h2></div>
		<div class="contact-cols">
			<?php if ( ita_opt( 'address' ) ) : ?><div><h3 style="color:#fff">Address</h3><p><?php echo nl2br( esc_html( ita_opt( 'address' ) ) ); ?></p></div><?php endif; ?>
			<div><h3 style="color:#fff">Contact</h3>
				<?php if ( ita_opt( 'email' ) ) : ?><p><a href="mailto:<?php echo esc_attr( antispambot( ita_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( ita_opt( 'email' ) ) ); ?></a></p><?php endif; ?>
				<?php if ( ita_opt( 'phone' ) ) : ?><p><?php echo esc_html( ita_opt( 'phone' ) ); ?></p><?php endif; ?>
				<?php if ( ! empty( $contact ) ) : ?><p><a class="btn btn--alt" href="<?php echo esc_url( get_permalink( $contact ) ); ?>">Send us a message</a></p><?php endif; ?>
			</div>
			<div><h3 style="color:#fff">Follow us</h3><p class="social"><?php foreach ( ita_social_links() as $label => $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a><?php endforeach; ?></p></div>
		</div>
	</div>
</section>

<?php endif; ?>
<?php get_footer(); ?>
