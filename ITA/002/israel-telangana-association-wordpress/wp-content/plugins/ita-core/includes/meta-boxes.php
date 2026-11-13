<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'ita_add_meta_boxes' );
function ita_add_meta_boxes() {
	add_meta_box( 'ita_event_details', 'Event details', 'ita_box_event', 'ita_event', 'normal', 'high' );
	add_meta_box( 'ita_event_gallery', 'Event photos', 'ita_box_gallery', 'ita_event', 'normal', 'default' );
	add_meta_box( 'ita_album_gallery', 'Album photos', 'ita_box_gallery', 'ita_album', 'normal', 'high' );
	add_meta_box( 'ita_member_details', 'Member details', 'ita_box_member', 'ita_member', 'side', 'default' );
	add_meta_box( 'ita_enquiry_details', 'Submission details', 'ita_box_enquiry', 'ita_enquiry', 'normal', 'high' );
}

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		$screen = get_current_screen();
		$ours   = $screen && ( in_array( $screen->post_type, array( 'ita_event', 'ita_album', 'ita_member' ), true ) || false !== strpos( $hook, 'ita-settings' ) );
		if ( ! $ours ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_style( 'ita-admin', ITA_CORE_URL . 'assets/admin.css', array(), ITA_CORE_VERSION );
		wp_enqueue_script( 'ita-admin', ITA_CORE_URL . 'assets/admin.js', array( 'jquery', 'jquery-ui-sortable' ), ITA_CORE_VERSION, true );
	}
);

function ita_box_event( $post ) {
	wp_nonce_field( 'ita_save_meta', 'ita_meta_nonce' );
	$start    = get_post_meta( $post->ID, '_ita_start', true );
	$end      = get_post_meta( $post->ID, '_ita_end', true );
	$location = get_post_meta( $post->ID, '_ita_location', true );
	$reg      = get_post_meta( $post->ID, '_ita_reg_url', true );
	$status   = get_post_meta( $post->ID, '_ita_status', true );
	$status   = $status ? $status : 'scheduled';
	?>
	<p class="description">The event title, description and poster (Featured image) use the normal editor on this page. Times use the website time zone (<?php echo esc_html( wp_timezone_string() ); ?>). Events move to "Past" automatically once the end time (or start time, if no end) has passed.</p>
	<table class="form-table ita-table">
		<tr><th><label for="ita_start">Start date &amp; time *</label></th>
			<td><input type="datetime-local" id="ita_start" name="ita_start" value="<?php echo esc_attr( $start ); ?>" required></td></tr>
		<tr><th><label for="ita_end">End date &amp; time</label></th>
			<td><input type="datetime-local" id="ita_end" name="ita_end" value="<?php echo esc_attr( $end ); ?>"></td></tr>
		<tr><th><label for="ita_location">Location</label></th>
			<td><input type="text" class="large-text" id="ita_location" name="ita_location" value="<?php echo esc_attr( $location ); ?>" placeholder="Venue name, city"></td></tr>
		<tr><th><label for="ita_reg_url">Registration link</label></th>
			<td><input type="url" class="large-text" id="ita_reg_url" name="ita_reg_url" value="<?php echo esc_attr( $reg ); ?>" placeholder="https://"></td></tr>
		<tr><th><label for="ita_status">Event status</label></th>
			<td><select id="ita_status" name="ita_status">
				<?php foreach ( ita_event_statuses() as $k => $label ) : ?>
					<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $status, $k ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select></td></tr>
	</table>
	<?php
}

function ita_box_gallery( $post ) {
	wp_nonce_field( 'ita_save_meta', 'ita_meta_nonce' );
	$ids = ita_gallery_ids( $post->ID );
	?>
	<div class="ita-gallery-box">
		<input type="hidden" name="ita_gallery" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">
		<ul class="ita-gallery-list">
			<?php foreach ( $ids as $id ) : ?>
				<li data-id="<?php echo esc_attr( $id ); ?>">
					<?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
					<button type="button" class="ita-gallery-remove" aria-label="Remove photo">&times;</button>
				</li>
			<?php endforeach; ?>
		</ul>
		<p><button type="button" class="button button-primary ita-gallery-add">Add / upload photos</button></p>
		<p class="description">Drag photos to reorder. Captions and alt text are edited in the Media Library (or in the dialog when you pick a photo). To replace a photo, remove it and add the new one.</p>
	</div>
	<?php
}

function ita_box_member( $post ) {
	wp_nonce_field( 'ita_save_meta', 'ita_meta_nonce' );
	$designation = get_post_meta( $post->ID, '_ita_designation', true );
	?>
	<p><label for="ita_designation"><strong>Designation</strong></label><br>
		<input type="text" class="widefat" id="ita_designation" name="ita_designation" value="<?php echo esc_attr( $designation ); ?>" placeholder="e.g. President"></p>
	<p class="description">Photo = Featured image. Short bio = Excerpt. Display order = "Order" in Page Attributes (lower numbers first).</p>
	<?php
}

function ita_box_enquiry( $post ) {
	$meta = get_post_meta( $post->ID );
	echo '<table class="widefat striped"><tbody>';
	foreach ( $meta as $key => $vals ) {
		if ( 0 !== strpos( $key, '_ita_f_' ) ) {
			continue;
		}
		$label = ucwords( str_replace( '_', ' ', substr( $key, 7 ) ) );
		echo '<tr><th style="width:200px">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $vals[0] ) ) . '</td></tr>';
	}
	echo '<tr><th>Received</th><td>' . esc_html( get_the_date( 'j M Y, g:i A', $post ) ) . '</td></tr>';
	echo '</tbody></table>';
}

add_action( 'save_post', 'ita_save_meta', 10, 2 );
function ita_save_meta( $post_id, $post ) {
	if ( ! isset( $_POST['ita_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ita_meta_nonce'] ) ), 'ita_save_meta' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$dt = function ( $key ) {
		$v = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		return preg_match( '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $v ) ? $v : '';
	};

	if ( 'ita_event' === $post->post_type ) {
		$start = $dt( 'ita_start' );
		$end   = $dt( 'ita_end' );
		if ( $end && $start && $end < $start ) {
			$end = '';
		}
		update_post_meta( $post_id, '_ita_start', $start );
		update_post_meta( $post_id, '_ita_end', $end );
		update_post_meta( $post_id, '_ita_end_eff', $end ? $end : $start );
		update_post_meta( $post_id, '_ita_location', isset( $_POST['ita_location'] ) ? sanitize_text_field( wp_unslash( $_POST['ita_location'] ) ) : '' );
		update_post_meta( $post_id, '_ita_reg_url', isset( $_POST['ita_reg_url'] ) ? esc_url_raw( wp_unslash( $_POST['ita_reg_url'] ) ) : '' );
		$status = isset( $_POST['ita_status'] ) ? sanitize_key( wp_unslash( $_POST['ita_status'] ) ) : 'scheduled';
		update_post_meta( $post_id, '_ita_status', array_key_exists( $status, ita_event_statuses() ) ? $status : 'scheduled' );
	}

	if ( in_array( $post->post_type, array( 'ita_event', 'ita_album' ), true ) && isset( $_POST['ita_gallery'] ) ) {
		$ids = array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['ita_gallery'] ) ) ) ) );
		update_post_meta( $post_id, '_ita_gallery', implode( ',', $ids ) );
	}

	if ( 'ita_member' === $post->post_type ) {
		update_post_meta( $post_id, '_ita_designation', isset( $_POST['ita_designation'] ) ? sanitize_text_field( wp_unslash( $_POST['ita_designation'] ) ) : '' );
	}
}

/* Admin list columns */
add_filter(
	'manage_ita_event_posts_columns',
	function ( $cols ) {
		$new = array();
		foreach ( $cols as $k => $v ) {
			$new[ $k ] = $v;
			if ( 'title' === $k ) {
				$new['ita_when']   = 'When';
				$new['ita_where']  = 'Location';
				$new['ita_state']  = 'Upcoming / Past';
			}
		}
		return $new;
	}
);
add_action(
	'manage_ita_event_posts_custom_column',
	function ( $col, $id ) {
		$info = ita_event_info( $id );
		if ( 'ita_when' === $col ) {
			echo esc_html( ita_event_when( $info ) );
		} elseif ( 'ita_where' === $col ) {
			echo esc_html( $info['location'] );
		} elseif ( 'ita_state' === $col ) {
			echo $info['start_ts'] ? ( $info['is_past'] ? 'Past' : '<strong>Upcoming</strong>' ) : '—';
		}
	},
	10,
	2
);
add_filter(
	'manage_edit-ita_event_sortable_columns',
	function ( $c ) {
		$c['ita_when'] = 'ita_when';
		return $c;
	}
);
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() && $q->is_main_query() && 'ita_when' === $q->get( 'orderby' ) ) {
			$q->set( 'meta_key', '_ita_start' );
			$q->set( 'orderby', 'meta_value' );
		}
	}
);

add_filter(
	'manage_ita_enquiry_posts_columns',
	function () {
		return array(
			'cb'        => '<input type="checkbox">',
			'title'     => 'Enquiry',
			'ita_type'  => 'Type',
			'ita_email' => 'Email',
			'ita_phone' => 'Phone',
			'date'      => 'Received',
		);
	}
);
add_action(
	'manage_ita_enquiry_posts_custom_column',
	function ( $col, $id ) {
		if ( 'ita_type' === $col ) {
			echo esc_html( ucfirst( get_post_meta( $id, '_ita_type', true ) ) );
		} elseif ( 'ita_email' === $col ) {
			$e = get_post_meta( $id, '_ita_f_email', true );
			echo $e ? '<a href="mailto:' . esc_attr( $e ) . '">' . esc_html( $e ) . '</a>' : '';
		} elseif ( 'ita_phone' === $col ) {
			echo esc_html( get_post_meta( $id, '_ita_f_phone', true ) );
		}
	},
	10,
	2
);
