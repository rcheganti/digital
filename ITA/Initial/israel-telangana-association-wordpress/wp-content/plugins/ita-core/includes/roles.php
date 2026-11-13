<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ita_caps_for( $plural ) {
	return array(
		"edit_{$plural}",
		"edit_others_{$plural}",
		"publish_{$plural}",
		"read_private_{$plural}",
		"delete_{$plural}",
		"delete_private_{$plural}",
		"delete_published_{$plural}",
		"delete_others_{$plural}",
		"edit_private_{$plural}",
		"edit_published_{$plural}",
	);
}

function ita_register_roles() {
	$content_types = array( 'ita_events', 'ita_albums', 'ita_members' );
	$enquiry_types = array( 'ita_enquiries' );

	foreach ( array( 'administrator', 'editor' ) as $role_name ) {
		$role = get_role( $role_name );
		if ( ! $role ) {
			continue;
		}
		foreach ( array_merge( $content_types, $enquiry_types ) as $plural ) {
			foreach ( ita_caps_for( $plural ) as $cap ) {
				$role->add_cap( $cap );
			}
		}
	}

	// Event Manager: manages their own events and albums only.
	$own = array();
	foreach ( array( 'ita_events', 'ita_albums' ) as $plural ) {
		$own = array_merge(
			$own,
			array( "edit_{$plural}", "publish_{$plural}", "edit_published_{$plural}", "delete_{$plural}", "delete_published_{$plural}" )
		);
	}
	$caps = array(
		'read'         => true,
		'upload_files' => true,
	);
	foreach ( $own as $cap ) {
		$caps[ $cap ] = true;
	}
	remove_role( 'ita_event_manager' );
	add_role( 'ita_event_manager', 'Event Manager', $caps );

	update_option( 'ita_caps_version', ITA_CORE_VERSION );
}

// Keep capabilities in sync after plugin updates.
add_action(
	'admin_init',
	function () {
		if ( get_option( 'ita_caps_version' ) !== ITA_CORE_VERSION ) {
			ita_register_roles();
		}
	}
);
