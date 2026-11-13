<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_dashboard_setup',
	function () {
		wp_add_dashboard_widget( 'ita_quick', 'Israel Telangana Association – Quick actions', 'ita_dashboard_widget' );
	}
);

function ita_dashboard_widget() {
	$new = wp_count_posts( 'ita_enquiry' );
	$n   = isset( $new->publish ) ? (int) $new->publish : 0;
	echo '<p><a class="button button-primary" href="' . esc_url( admin_url( 'post-new.php?post_type=ita_event' ) ) . '">Add event</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'post-new.php' ) ) . '">Add news / announcement</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'post-new.php?post_type=ita_album' ) ) . '">Add photo album</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'post-new.php?post_type=ita_member' ) ) . '">Add committee member</a></p>';
	echo '<ul><li><a href="' . esc_url( admin_url( 'edit.php?post_type=ita_enquiry' ) ) . '">' . esc_html( $n ) . ' enquiries / applications</a></li>';
	echo '<li><a href="' . esc_url( admin_url( 'admin.php?page=ita-settings' ) ) . '">Homepage banner, contact details &amp; social links</a></li>';
	echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">Menus</a></li></ul>';
}
