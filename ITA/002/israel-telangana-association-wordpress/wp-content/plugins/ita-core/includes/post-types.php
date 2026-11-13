<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'ita_register_post_types' );

function ita_register_post_types() {
	register_post_type(
		'ita_event',
		array(
			'labels'          => array(
				'name'               => 'Events',
				'singular_name'      => 'Event',
				'add_new_item'       => 'Add New Event',
				'edit_item'          => 'Edit Event',
				'all_items'          => 'All Events',
				'search_items'       => 'Search Events',
				'not_found'          => 'No events found.',
				'menu_name'          => 'Events',
			),
			'public'          => true,
			'has_archive'     => 'events',
			'rewrite'         => array( 'slug' => 'events', 'with_front' => false ),
			'menu_icon'       => 'dashicons-calendar-alt',
			'menu_position'   => 5,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
			'show_in_rest'    => true,
			'capability_type' => array( 'ita_event', 'ita_events' ),
			'map_meta_cap'    => true,
		)
	);

	register_post_type(
		'ita_album',
		array(
			'labels'          => array(
				'name'          => 'Photo Albums',
				'singular_name' => 'Photo Album',
				'add_new_item'  => 'Add New Album',
				'edit_item'     => 'Edit Album',
				'all_items'     => 'All Albums',
				'menu_name'     => 'Photo Gallery',
			),
			'public'          => true,
			'has_archive'     => 'gallery',
			'rewrite'         => array( 'slug' => 'gallery', 'with_front' => false ),
			'menu_icon'       => 'dashicons-format-gallery',
			'menu_position'   => 6,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
			'show_in_rest'    => true,
			'capability_type' => array( 'ita_album', 'ita_albums' ),
			'map_meta_cap'    => true,
		)
	);

	register_post_type(
		'ita_member',
		array(
			'labels'          => array(
				'name'          => 'Committee',
				'singular_name' => 'Committee Member',
				'add_new_item'  => 'Add Committee Member',
				'edit_item'     => 'Edit Committee Member',
				'all_items'     => 'All Members',
				'menu_name'     => 'Committee',
			),
			'public'          => true,
			'has_archive'     => 'committee',
			'rewrite'         => array( 'slug' => 'committee', 'with_front' => false ),
			'menu_icon'       => 'dashicons-groups',
			'menu_position'   => 7,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'show_in_rest'    => true,
			'capability_type' => array( 'ita_member', 'ita_members' ),
			'map_meta_cap'    => true,
		)
	);

	register_post_type(
		'ita_enquiry',
		array(
			'labels'              => array(
				'name'          => 'Enquiries',
				'singular_name' => 'Enquiry',
				'all_items'     => 'All Enquiries',
				'menu_name'     => 'Enquiries',
				'not_found'     => 'No enquiries yet.',
			),
			'public'              => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'menu_icon'           => 'dashicons-email-alt',
			'menu_position'       => 8,
			'supports'            => array( 'title' ),
			'capability_type'     => array( 'ita_enquiry', 'ita_enquiries' ),
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
		)
	);
}

/* Default news categories are created by the seeder; the front end uses native posts. */

/* Events archive: show PAST events (newest first) with pagination; upcoming are queried separately in the template. */
add_action( 'pre_get_posts', 'ita_event_archive_query' );
function ita_event_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'ita_event' ) ) {
		return;
	}
	$query->set( 'posts_per_page', 9 );
	$query->set( 'meta_key', '_ita_start' );
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'order', 'DESC' );
	$query->set(
		'meta_query',
		array(
			array(
				'key'     => '_ita_end_eff',
				'value'   => wp_date( 'Y-m-d\TH:i' ),
				'compare' => '<',
				'type'    => 'CHAR',
			),
		)
	);
}

add_action( 'pre_get_posts', 'ita_other_archives_query' );
function ita_other_archives_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'ita_member' ) ) {
		$query->set( 'posts_per_page', 60 );
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
	if ( $query->is_post_type_archive( 'ita_album' ) ) {
		$query->set( 'posts_per_page', 12 );
	}
}
