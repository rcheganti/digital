<?php
/**
 * Plugin Name: ITA Core – Israel Telangana Association
 * Description: Events, photo albums, committee, enquiry forms, site settings, roles and sample content for the Israel Telangana Association website.
 * Version: 1.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author: Israel Telangana Association
 * License: GPL-2.0-or-later
 * Text Domain: ita-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ITA_CORE_VERSION', '1.0.0' );
define( 'ITA_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ITA_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once ITA_CORE_DIR . 'includes/helpers.php';
require_once ITA_CORE_DIR . 'includes/post-types.php';
require_once ITA_CORE_DIR . 'includes/roles.php';
require_once ITA_CORE_DIR . 'includes/meta-boxes.php';
require_once ITA_CORE_DIR . 'includes/settings.php';
require_once ITA_CORE_DIR . 'includes/forms.php';
require_once ITA_CORE_DIR . 'includes/security.php';
require_once ITA_CORE_DIR . 'includes/dashboard.php';
require_once ITA_CORE_DIR . 'includes/seed.php';

register_activation_hook( __FILE__, 'ita_core_activate' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

function ita_core_activate() {
	ita_register_post_types();
	ita_register_roles();
	if ( ! get_option( 'timezone_string' ) ) {
		update_option( 'timezone_string', 'Asia/Jerusalem' );
	}
	ita_seed_content();
	flush_rewrite_rules();
}
