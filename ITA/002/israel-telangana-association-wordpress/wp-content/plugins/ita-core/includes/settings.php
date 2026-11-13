<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ita_settings_fields() {
	return array(
		'Homepage banner (hero)'  => array(
			'hero_title'    => array( 'Banner heading', 'text', 'Welcome to the Israel Telangana Association' ),
			'hero_text'     => array( 'Banner message', 'textarea', '' ),
			'hero_btn_text' => array( 'Button text', 'text', 'See upcoming events' ),
			'hero_btn_url'  => array( 'Button link', 'url', '' ),
			'hero_image'    => array( 'Banner background image', 'media', '' ),
		),
		'Introduction'            => array(
			'intro_title' => array( 'Introduction heading', 'text', '' ),
			'intro_text'  => array( 'Introduction text', 'textarea', '' ),
		),
		'Contact details'         => array(
			'email'        => array( 'Public email', 'email', '' ),
			'phone'        => array( 'Phone', 'text', '' ),
			'address'      => array( 'Address', 'textarea', '' ),
			'map_embed'    => array( 'Google Maps embed URL (optional)', 'url', '' ),
			'notify_email' => array( 'Send form notifications to', 'email', '' ),
		),
		'Social media'            => array(
			'facebook'  => array( 'Facebook URL', 'url', '' ),
			'instagram' => array( 'Instagram URL', 'url', '' ),
			'youtube'   => array( 'YouTube URL', 'url', '' ),
			'x'         => array( 'X (Twitter) URL', 'url', '' ),
			'linkedin'  => array( 'LinkedIn URL', 'url', '' ),
			'whatsapp'  => array( 'WhatsApp group / chat link', 'url', '' ),
		),
		'Footer'                  => array(
			'footer_text' => array( 'Footer about text', 'textarea', '' ),
		),
	);
}

add_action(
	'admin_menu',
	function () {
		add_menu_page( 'ITA Settings', 'ITA Settings', 'manage_options', 'ita-settings', 'ita_render_settings', 'dashicons-admin-site-alt3', 3 );
	}
);

add_action(
	'admin_init',
	function () {
		register_setting( 'ita_settings', 'ita_options', array( 'sanitize_callback' => 'ita_sanitize_options' ) );
	}
);

function ita_sanitize_options( $input ) {
	$out = array();
	foreach ( ita_settings_fields() as $fields ) {
		foreach ( $fields as $key => $def ) {
			$v = isset( $input[ $key ] ) ? $input[ $key ] : '';
			switch ( $def[1] ) {
				case 'url':
					$out[ $key ] = esc_url_raw( $v );
					break;
				case 'email':
					$out[ $key ] = sanitize_email( $v );
					break;
				case 'textarea':
					$out[ $key ] = sanitize_textarea_field( $v );
					break;
				case 'media':
					$out[ $key ] = absint( $v ) ? absint( $v ) : '';
					break;
				default:
					$out[ $key ] = sanitize_text_field( $v );
			}
		}
	}
	return $out;
}

function ita_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$o = get_option( 'ita_options', array() );
	?>
	<div class="wrap">
		<h1>Israel Telangana Association – Site Settings</h1>
		<p>Everything shown here appears on the public website. Use <strong>Appearance → Menus</strong> for navigation, <strong>Pages</strong> for About Us text, and the other left-menu items for events, gallery and committee.</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'ita_settings' ); ?>
			<?php foreach ( ita_settings_fields() as $section => $fields ) : ?>
				<div class="ita-settings-section">
					<h2><?php echo esc_html( $section ); ?></h2>
					<table class="form-table">
						<?php foreach ( $fields as $key => $def ) :
							$val = isset( $o[ $key ] ) ? $o[ $key ] : '';
							$id  = 'ita_' . $key;
							$nm  = 'ita_options[' . $key . ']';
							?>
							<tr>
								<th><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $def[0] ); ?></label></th>
								<td>
									<?php if ( 'textarea' === $def[1] ) : ?>
										<textarea class="large-text" rows="4" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $nm ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
									<?php elseif ( 'media' === $def[1] ) : ?>
										<div class="ita-media-field">
											<input type="hidden" name="<?php echo esc_attr( $nm ); ?>" value="<?php echo esc_attr( $val ); ?>">
											<div class="ita-media-preview"><?php echo $val ? wp_get_attachment_image( (int) $val, 'medium' ) : ''; ?></div>
											<button class="button ita-media-pick">Choose image</button>
											<button class="button-link ita-media-clear">Remove</button>
										</div>
									<?php else : ?>
										<input type="<?php echo esc_attr( $def[1] ); ?>" class="regular-text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $nm ); ?>" value="<?php echo esc_attr( $val ); ?>">
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			<?php endforeach; ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
