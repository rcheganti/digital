<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Light-touch hardening. For full protection also use a security plugin and HTTPS. */
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );
add_filter( 'login_errors', function () { return 'Incorrect login details.'; } );

// Block user enumeration via ?author=N and the public REST users list.
add_action(
	'template_redirect',
	function () {
		if ( ! is_admin() && isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}
);
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( ! is_user_logged_in() ) {
			unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	}
);

// Keep non-staff out of the dashboard.
add_action(
	'admin_init',
	function () {
		if ( wp_doing_ajax() || ! is_user_logged_in() ) {
			return;
		}
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'upload_files' ) && ! current_user_can( 'edit_ita_events' ) ) {
			wp_safe_redirect( home_url( '/' ) );
			exit;
		}
	}
);
