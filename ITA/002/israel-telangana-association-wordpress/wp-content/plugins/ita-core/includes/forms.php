<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Field definitions: key => [label, type, required, options]. */
function ita_form_defs( $type ) {
	$forms = array(
		'contact'    => array(
			'label'  => 'Contact',
			'fields' => array(
				'name'    => array( 'Full name', 'text', true ),
				'email'   => array( 'Email', 'email', true ),
				'phone'   => array( 'Phone', 'tel', false ),
				'subject' => array( 'Subject', 'text', true ),
				'message' => array( 'Message', 'textarea', true ),
			),
		),
		'membership' => array(
			'label'  => 'Membership',
			'fields' => array(
				'name'            => array( 'Full name', 'text', true ),
				'email'           => array( 'Email', 'email', true ),
				'phone'           => array( 'Phone / WhatsApp', 'tel', true ),
				'city_in_israel'  => array( 'City in Israel', 'text', true ),
				'home_district'   => array( 'Home district in Telangana', 'text', false ),
				'membership_type' => array( 'Membership type', 'select', true, array( 'Individual', 'Family', 'Student' ) ),
				'message'         => array( 'Anything you would like to tell us', 'textarea', false ),
				'consent'         => array( 'I agree that the association may contact me about my membership.', 'checkbox', true ),
			),
		),
	);
	return isset( $forms[ $type ] ) ? $forms[ $type ] : null;
}

add_shortcode( 'ita_contact_form', function () { return ita_render_form( 'contact' ); } );
add_shortcode( 'ita_membership_form', function () { return ita_render_form( 'membership' ); } );

add_shortcode(
	'ita_contact_info',
	function () {
		ob_start();
		echo '<div class="ita-contact-info">';
		if ( ita_opt( 'address' ) ) {
			echo '<p><strong>Address</strong><br>' . nl2br( esc_html( ita_opt( 'address' ) ) ) . '</p>';
		}
		if ( ita_opt( 'email' ) ) {
			echo '<p><strong>Email</strong><br><a href="mailto:' . esc_attr( antispambot( ita_opt( 'email' ) ) ) . '">' . esc_html( antispambot( ita_opt( 'email' ) ) ) . '</a></p>';
		}
		if ( ita_opt( 'phone' ) ) {
			echo '<p><strong>Phone</strong><br>' . esc_html( ita_opt( 'phone' ) ) . '</p>';
		}
		$links = ita_social_links();
		if ( $links ) {
			echo '<p class="ita-social">';
			foreach ( $links as $label => $url ) {
				echo '<a href="' . esc_url( $url ) . '" rel="noopener" target="_blank">' . esc_html( $label ) . '</a> ';
			}
			echo '</p>';
		}
		if ( ita_opt( 'map_embed' ) ) {
			echo '<iframe class="ita-map" src="' . esc_url( ita_opt( 'map_embed' ) ) . '" loading="lazy" title="Map" referrerpolicy="no-referrer-when-downgrade"></iframe>';
		}
		echo '</div>';
		return ob_get_clean();
	}
);

function ita_render_form( $type ) {
	$def = ita_form_defs( $type );
	if ( ! $def ) {
		return '';
	}
	$status = '';
	if ( isset( $_GET['ita_form'], $_GET['ita_status'] ) && sanitize_key( wp_unslash( $_GET['ita_form'] ) ) === $type ) { // phpcs:ignore WordPress.Security.NonceVerification
		$status = sanitize_key( wp_unslash( $_GET['ita_status'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
	}
	$ts = time();
	ob_start();
	echo '<div class="ita-form-wrap" id="ita-form-' . esc_attr( $type ) . '">';
	if ( 'sent' === $status ) {
		echo '<div class="ita-notice ita-notice--ok" role="status">Thank you! Your message has been received. We will get back to you soon.</div>';
	} elseif ( $status ) {
		$msgs = array(
			'invalid' => 'Please fill in all required fields with valid details.',
			'wait'    => 'Please wait a few seconds and try again.',
			'limit'   => 'Too many submissions from your connection. Please try again later.',
		);
		echo '<div class="ita-notice ita-notice--err" role="alert">' . esc_html( isset( $msgs[ $status ] ) ? $msgs[ $status ] : 'Something went wrong. Please try again.' ) . '</div>';
	}
	echo '<form class="ita-form" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="ita_submit_form">';
	echo '<input type="hidden" name="ita_form_type" value="' . esc_attr( $type ) . '">';
	echo '<input type="hidden" name="ita_ts" value="' . esc_attr( $ts ) . '">';
	echo '<input type="hidden" name="ita_tok" value="' . esc_attr( wp_hash( 'ita' . $ts ) ) . '">';
	wp_nonce_field( 'ita_form_' . $type, 'ita_nonce' );
	echo '<div class="ita-hp" aria-hidden="true" style="position:absolute;left:-9999px"><label>Leave this empty<input type="text" name="ita_website" tabindex="-1" autocomplete="off"></label></div>';
	foreach ( $def['fields'] as $key => $f ) {
		$id  = 'ita_' . $type . '_' . $key;
		$req = ! empty( $f[2] );
		echo '<p class="ita-field ita-field--' . esc_attr( $f[1] ) . '">';
		if ( 'checkbox' === $f[1] ) {
			echo '<label><input type="checkbox" id="' . esc_attr( $id ) . '" name="f_' . esc_attr( $key ) . '" value="yes"' . ( $req ? ' required' : '' ) . '> ' . esc_html( $f[0] ) . '</label>';
		} else {
			echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $f[0] ) . ( $req ? ' <span aria-hidden="true">*</span>' : '' ) . '</label>';
			if ( 'textarea' === $f[1] ) {
				echo '<textarea id="' . esc_attr( $id ) . '" name="f_' . esc_attr( $key ) . '" rows="5"' . ( $req ? ' required' : '' ) . '></textarea>';
			} elseif ( 'select' === $f[1] ) {
				echo '<select id="' . esc_attr( $id ) . '" name="f_' . esc_attr( $key ) . '"' . ( $req ? ' required' : '' ) . '>';
				foreach ( $f[3] as $opt ) {
					echo '<option>' . esc_html( $opt ) . '</option>';
				}
				echo '</select>';
			} else {
				echo '<input type="' . esc_attr( $f[1] ) . '" id="' . esc_attr( $id ) . '" name="f_' . esc_attr( $key ) . '"' . ( $req ? ' required' : '' ) . '>';
			}
		}
		echo '</p>';
	}
	echo '<p><button type="submit" class="ita-btn">' . ( 'membership' === $type ? 'Submit application' : 'Send message' ) . '</button></p>';
	echo '</form></div>';
	return ob_get_clean();
}

add_action( 'admin_post_nopriv_ita_submit_form', 'ita_handle_form' );
add_action( 'admin_post_ita_submit_form', 'ita_handle_form' );

function ita_handle_form() {
	$type = isset( $_POST['ita_form_type'] ) ? sanitize_key( wp_unslash( $_POST['ita_form_type'] ) ) : '';
	$def  = ita_form_defs( $type );
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'ita_status', 'ita_form' ), $back );
	$go   = function ( $code ) use ( $back, $type ) {
		wp_safe_redirect( add_query_arg( array( 'ita_status' => $code, 'ita_form' => $type ), $back ) . '#ita-form-' . $type );
		exit;
	};
	if ( ! $def ) {
		$go( 'error' );
	}
	if ( ! isset( $_POST['ita_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ita_nonce'] ) ), 'ita_form_' . $type ) ) {
		$go( 'error' );
	}
	// Honeypot: bots fill it in. Pretend success.
	if ( ! empty( $_POST['ita_website'] ) ) {
		$go( 'sent' );
	}
	// Time trap: form must be open at least 3 seconds, at most 2 days.
	$ts  = isset( $_POST['ita_ts'] ) ? absint( $_POST['ita_ts'] ) : 0;
	$tok = isset( $_POST['ita_tok'] ) ? sanitize_text_field( wp_unslash( $_POST['ita_tok'] ) ) : '';
	if ( ! $ts || ! hash_equals( wp_hash( 'ita' . $ts ), $tok ) || time() - $ts > 2 * DAY_IN_SECONDS ) {
		$go( 'error' );
	}
	if ( time() - $ts < 3 ) {
		$go( 'wait' );
	}
	// Rate limit: 5 submissions per hour per IP.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x';
	$rk  = 'ita_rl_' . md5( $ip );
	$cnt = (int) get_transient( $rk );
	if ( $cnt >= 5 ) {
		$go( 'limit' );
	}

	$values = array();
	foreach ( $def['fields'] as $key => $f ) {
		$raw = isset( $_POST[ 'f_' . $key ] ) ? wp_unslash( $_POST[ 'f_' . $key ] ) : '';
		if ( 'textarea' === $f[1] ) {
			$v = sanitize_textarea_field( $raw );
		} elseif ( 'email' === $f[1] ) {
			$v = sanitize_email( $raw );
		} elseif ( 'select' === $f[1] ) {
			$v = in_array( $raw, $f[3], true ) ? $raw : '';
		} elseif ( 'checkbox' === $f[1] ) {
			$v = 'yes' === $raw ? 'Yes' : '';
		} else {
			$v = sanitize_text_field( $raw );
		}
		if ( ! empty( $f[2] ) && '' === $v ) {
			$go( 'invalid' );
		}
		if ( 'email' === $f[1] && '' !== $v && ! is_email( $v ) ) {
			$go( 'invalid' );
		}
		$values[ $key ] = mb_substr( $v, 0, 5000 );
	}

	set_transient( $rk, $cnt + 1, HOUR_IN_SECONDS );

	$body = '';
	foreach ( $values as $key => $v ) {
		$body .= $def['fields'][ $key ][0] . ': ' . $v . "\n";
	}
	$title = '[' . $def['label'] . '] ' . $values['name'] . ( ! empty( $values['subject'] ) ? ' – ' . $values['subject'] : '' );
	$id    = wp_insert_post(
		array(
			'post_type'    => 'ita_enquiry',
			'post_status'  => 'publish',
			'post_title'   => wp_strip_all_tags( $title ),
			'post_content' => $body,
		)
	);
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, '_ita_type', $type );
		foreach ( $values as $key => $v ) {
			update_post_meta( $id, '_ita_f_' . $key, $v );
		}
	}

	$to      = ita_opt( 'notify_email', get_option( 'admin_email' ) );
	$headers = array( 'Reply-To: ' . $values['name'] . ' <' . $values['email'] . '>' );
	wp_mail( $to, '[' . get_bloginfo( 'name' ) . '] New ' . strtolower( $def['label'] ) . ' enquiry from ' . $values['name'], $body . "\n\nView in dashboard: " . admin_url( 'edit.php?post_type=ita_enquiry' ), $headers );

	$go( 'sent' );
}
