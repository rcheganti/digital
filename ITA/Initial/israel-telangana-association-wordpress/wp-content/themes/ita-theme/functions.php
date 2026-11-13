<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ITA_THEME_VERSION', '1.0.0' );

if ( ! function_exists( 'ita_opt' ) ) {
	function ita_opt( $key, $default = '' ) {
		return $default;
	}
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 120, 'flex-width' => true, 'flex-height' => true ) );
		add_image_size( 'ita-card', 720, 480, true );
		add_image_size( 'ita-hero', 1800, 900, true );
		register_nav_menus(
			array(
				'primary' => 'Primary menu',
				'footer'  => 'Footer menu',
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'ita-theme', get_stylesheet_uri(), array(), ITA_THEME_VERSION );
		wp_enqueue_script( 'ita-theme', get_template_directory_uri() . '/assets/main.js', array(), ITA_THEME_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
);

// Assign the menus created by the ITA Core plugin to this theme's locations (once).
add_action(
	'init',
	function () {
		$loc = get_theme_mod( 'nav_menu_locations' );
		$ids = get_option( 'ita_menu_ids' );
		if ( is_array( $ids ) && ( empty( $loc['primary'] ) && empty( $loc['footer'] ) ) ) {
			set_theme_mod(
				'nav_menu_locations',
				array(
					'primary' => isset( $ids['primary'] ) ? (int) $ids['primary'] : 0,
					'footer'  => isset( $ids['footer'] ) ? (int) $ids['footer'] : 0,
				)
			);
		}
	}
);

// News page shows news and announcements, not "Community Highlights" posts.
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() || ! $q->is_home() ) {
			return;
		}
		$term = get_term_by( 'slug', 'community-highlights', 'category' );
		if ( $term ) {
			$q->set( 'category__not_in', array( $term->term_id ) );
		}
		$q->set( 'posts_per_page', 9 );
	}
);

/** Thumbnail or a coloured placeholder. */
function ita_thumb( $post_id = null, $size = 'ita-card' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$cover   = function_exists( 'ita_cover_id' ) ? ita_cover_id( $post_id ) : get_post_thumbnail_id( $post_id );
	if ( $cover ) {
		return wp_get_attachment_image( $cover, $size, false, array( 'alt' => esc_attr( get_the_title( $post_id ) ) ) );
	}
	return '<span class="ph" aria-hidden="true">' . esc_html( mb_substr( wp_strip_all_tags( get_the_title( $post_id ) ), 0, 1 ) ) . '</span>';
}

/** Lightbox gallery of attachment IDs. */
function ita_render_gallery( $ids ) {
	if ( ! $ids ) {
		return;
	}
	echo '<div class="gallery-grid">';
	foreach ( $ids as $id ) {
		$full    = wp_get_attachment_image_url( $id, 'large' );
		$caption = wp_get_attachment_caption( $id );
		if ( ! $full ) {
			continue;
		}
		echo '<a href="' . esc_url( $full ) . '" data-lightbox="1" data-caption="' . esc_attr( $caption ) . '">';
		echo wp_get_attachment_image( $id, 'ita-card', false, array( 'alt' => esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) ) ) );
		echo '</a>';
	}
	echo '</div>';
}

/** SEO + social meta (skipped when a dedicated SEO plugin is active). */
add_action(
	'wp_head',
	function () {
		if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
			return;
		}
		$title = wp_get_document_title();
		$desc  = get_bloginfo( 'description' );
		$img   = '';
		$type  = 'website';
		$url   = is_singular() ? get_permalink() : home_url( add_query_arg( array() ) );
		if ( is_singular() ) {
			$p    = get_queried_object();
			$desc = has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $p->post_content ) ), 30 );
			$desc = $desc ? $desc : get_bloginfo( 'description' );
			$tid  = function_exists( 'ita_cover_id' ) ? ita_cover_id( $p->ID ) : get_post_thumbnail_id( $p->ID );
			$img  = $tid ? wp_get_attachment_image_url( $tid, 'large' ) : '';
			$type = 'post' === $p->post_type ? 'article' : 'website';
		}
		if ( ! $img ) {
			$img = ita_opt( 'hero_image' ) ? wp_get_attachment_image_url( (int) ita_opt( 'hero_image' ), 'large' ) : '';
		}
		$desc = wp_strip_all_tags( $desc );
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
		if ( $img ) {
			echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
		}
		echo '<meta name="twitter:card" content="' . ( $img ? 'summary_large_image' : 'summary' ) . '">' . "\n";
	},
	5
);

// Friendly notice if the companion plugin is missing.
add_action(
	'admin_notices',
	function () {
		if ( ! defined( 'ITA_CORE_VERSION' ) && current_user_can( 'activate_plugins' ) ) {
			echo '<div class="notice notice-warning"><p><strong>ITA Theme:</strong> please install and activate the <em>ITA Core</em> plugin (events, gallery, committee, forms).</p></div>';
		}
	}
);
