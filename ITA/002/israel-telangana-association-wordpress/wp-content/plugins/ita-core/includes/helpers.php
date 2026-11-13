<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Read one option from the ITA settings page. */
function ita_opt( $key, $default = '' ) {
	$o = get_option( 'ita_options', array() );
	return ( isset( $o[ $key ] ) && '' !== $o[ $key ] ) ? $o[ $key ] : $default;
}

/** Attachment IDs of a gallery (event or album). */
function ita_gallery_ids( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$raw     = get_post_meta( $post_id, '_ita_gallery', true );
	if ( ! $raw ) {
		return array();
	}
	$ids = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
	return array_values(
		array_filter(
			$ids,
			function ( $id ) {
				return 'attachment' === get_post_type( $id );
			}
		)
	);
}

/** Cover image ID: featured image or first gallery photo. */
function ita_cover_id( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$thumb   = get_post_thumbnail_id( $post_id );
	if ( $thumb ) {
		return (int) $thumb;
	}
	$ids = ita_gallery_ids( $post_id );
	return $ids ? (int) $ids[0] : 0;
}

/** Structured data for one event. */
function ita_event_info( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$start   = get_post_meta( $post_id, '_ita_start', true );
	$end     = get_post_meta( $post_id, '_ita_end', true );
	$tz      = wp_timezone();
	$s_ts    = $start ? date_create_from_format( 'Y-m-d\TH:i', $start, $tz ) : false;
	$e_ts    = $end ? date_create_from_format( 'Y-m-d\TH:i', $end, $tz ) : false;
	$s_ts    = $s_ts ? $s_ts->getTimestamp() : 0;
	$e_ts    = $e_ts ? $e_ts->getTimestamp() : 0;
	$status  = get_post_meta( $post_id, '_ita_status', true );
	$eff     = $e_ts ? $e_ts : $s_ts;
	return array(
		'start'    => $start,
		'end'      => $end,
		'start_ts' => $s_ts,
		'end_ts'   => $e_ts,
		'location' => get_post_meta( $post_id, '_ita_location', true ),
		'reg_url'  => get_post_meta( $post_id, '_ita_reg_url', true ),
		'status'   => $status ? $status : 'scheduled',
		'is_past'  => $eff && $eff < time(),
	);
}

/** Human readable date/time range. */
function ita_event_when( $info ) {
	if ( empty( $info['start_ts'] ) ) {
		return '';
	}
	$s   = $info['start_ts'];
	$e   = $info['end_ts'];
	$out = wp_date( 'D, j M Y, g:i A', $s );
	if ( $e ) {
		if ( wp_date( 'Y-m-d', $s ) === wp_date( 'Y-m-d', $e ) ) {
			$out .= ' – ' . wp_date( 'g:i A', $e );
		} else {
			$out .= ' – ' . wp_date( 'D, j M Y, g:i A', $e );
		}
	}
	return $out;
}

/** Event status labels. */
function ita_event_statuses() {
	return array(
		'scheduled' => __( 'Scheduled', 'ita-core' ),
		'cancelled' => __( 'Cancelled', 'ita-core' ),
		'postponed' => __( 'Postponed', 'ita-core' ),
		'sold_out'  => __( 'Registration closed / full', 'ita-core' ),
	);
}

/** Upcoming (soonest first) or past (newest first) events. */
function ita_events_query( $which = 'upcoming', $args = array() ) {
	$now      = wp_date( 'Y-m-d\TH:i' );
	$defaults = array(
		'post_type'      => 'ita_event',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'meta_key'       => '_ita_start',
		'orderby'        => 'meta_value',
		'order'          => 'upcoming' === $which ? 'ASC' : 'DESC',
		'meta_query'     => array(
			array(
				'key'     => '_ita_end_eff',
				'value'   => $now,
				'compare' => 'upcoming' === $which ? '>=' : '<',
				'type'    => 'CHAR',
			),
		),
	);
	return new WP_Query( wp_parse_args( $args, $defaults ) );
}

/** Social links from settings: label => url. */
function ita_social_links() {
	$map   = array(
		'facebook'  => 'Facebook',
		'instagram' => 'Instagram',
		'youtube'   => 'YouTube',
		'x'         => 'X',
		'linkedin'  => 'LinkedIn',
		'whatsapp'  => 'WhatsApp',
	);
	$links = array();
	foreach ( $map as $key => $label ) {
		$url = ita_opt( $key );
		if ( $url ) {
			$links[ $label ] = $url;
		}
	}
	return $links;
}
