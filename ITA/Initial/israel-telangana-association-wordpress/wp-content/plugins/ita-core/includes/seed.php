<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Create a simple gradient placeholder JPG in the media library (needs PHP GD). */
function ita_make_placeholder( $name, $hex1, $hex2, $caption = '' ) {
	if ( ! function_exists( 'imagecreatetruecolor' ) ) {
		return 0;
	}
	$w  = 1200;
	$h  = 800;
	$im = imagecreatetruecolor( $w, $h );
	$c1 = sscanf( $hex1, '#%02x%02x%02x' );
	$c2 = sscanf( $hex2, '#%02x%02x%02x' );
	for ( $y = 0; $y < $h; $y++ ) {
		$t   = $y / $h;
		$col = imagecolorallocate( $im, (int) ( $c1[0] + ( $c2[0] - $c1[0] ) * $t ), (int) ( $c1[1] + ( $c2[1] - $c1[1] ) * $t ), (int) ( $c1[2] + ( $c2[2] - $c1[2] ) * $t ) );
		imageline( $im, 0, $y, $w, $y, $col );
	}
	imagealphablending( $im, true );
	$glow = imagecolorallocatealpha( $im, 255, 255, 255, 108 );
	for ( $i = 0; $i < 7; $i++ ) {
		imagefilledellipse( $im, 200 + $i * 150, 160 + ( $i % 3 ) * 200, 260 - $i * 20, 260 - $i * 20, $glow );
	}
	$up   = wp_upload_dir();
	$file = trailingslashit( $up['path'] ) . sanitize_file_name( $name ) . '.jpg';
	imagejpeg( $im, $file, 82 );
	imagedestroy( $im );
	$att = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/jpeg',
			'post_title'     => $name,
			'post_excerpt'   => $caption,
			'post_status'    => 'inherit',
		),
		$file
	);
	if ( ! $att || is_wp_error( $att ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $file ) );
	update_post_meta( $att, '_wp_attachment_image_alt', $name );
	return (int) $att;
}

function ita_seed_content() {
	if ( get_option( 'ita_seeded' ) ) {
		return;
	}
	update_option( 'ita_seeded', 1 );

	update_option( 'blogname', 'Israel Telangana Association' );
	update_option( 'blogdescription', 'Our Telangana community in Israel' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	// Settings (editable later under ITA Settings).
	update_option(
		'ita_options',
		array(
			'hero_title'    => 'Welcome to the Israel Telangana Association',
			'hero_text'     => 'A home away from home for the Telangana community in Israel – celebrating our culture, festivals and each other.',
			'hero_btn_text' => 'See upcoming events',
			'hero_btn_url'  => '',
			'intro_title'   => 'Who we are',
			'intro_text'    => 'The Israel Telangana Association brings together families, students and professionals from Telangana living in Israel. We organise festivals, cultural evenings, community support and networking events throughout the year.',
			'email'         => 'info@example.com',
			'phone'         => '+972 00 000 0000',
			'address'       => "Tel Aviv, Israel\n(replace with the official address)",
			'notify_email'  => get_option( 'admin_email' ),
			'facebook'      => 'https://www.facebook.com/',
			'instagram'     => 'https://www.instagram.com/',
			'youtube'       => 'https://www.youtube.com/',
			'footer_text'   => 'Celebrating Telangana culture and supporting our community in Israel.',
		)
	);

	// Categories.
	$cats = array();
	foreach ( array( 'News' => 'news', 'Announcements' => 'announcements', 'Community Highlights' => 'community-highlights' ) as $name => $slug ) {
		$term = term_exists( $slug, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
		$cats[ $slug ] = is_array( $term ) ? (int) $term['term_id'] : 0;
	}

	// Placeholder images.
	$pairs = array(
		array( '#c2185b', '#f4a300' ),
		array( '#0b5d4b', '#7bc67e' ),
		array( '#6a1b9a', '#f06292' ),
		array( '#e65100', '#ffd54f' ),
		array( '#004d61', '#26a69a' ),
		array( '#8e0038', '#ff8a65' ),
		array( '#33691e', '#fdd835' ),
		array( '#283593', '#ec407a' ),
	);
	$imgs  = array();
	foreach ( $pairs as $i => $p ) {
		$imgs[] = ita_make_placeholder( 'ita-sample-' . ( $i + 1 ), $p[0], $p[1], 'Sample photo ' . ( $i + 1 ) . ' – replace with a real photo' );
	}
	$img = function ( $i ) use ( $imgs ) {
		$v = $imgs[ $i % count( $imgs ) ];
		return $v ? $v : 0;
	};

	// Pages.
	$pages = array(
		'home'       => array( 'Home', '' ),
		'about-us'   => array( 'About Us', ita_about_html() ),
		'news'       => array( 'News & Announcements', '' ),
		'contact-us' => array( 'Contact Us', "<p>We would love to hear from you. Send us a message using the form or reach us using the details below.</p>\n[ita_contact_form]\n<h2>Contact details</h2>\n[ita_contact_info]" ),
		'membership' => array( 'Membership', "<p>Join the Israel Telangana Association and be part of our community. Fill in the short form below and our team will contact you.</p>\n[ita_membership_form]" ),
		'privacy-policy' => array( 'Privacy Policy', '<p>This is a sample privacy policy. We collect only the details you submit through our contact and membership forms, use them only to respond to you, and do not share them with third parties. Please replace this text with the association\'s official policy.</p>' ),
	);
	$ids = array();
	foreach ( $pages as $slug => $p ) {
		$existing = get_page_by_path( $slug );
		$ids[ $slug ] = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $p[0],
				'post_name'    => $slug,
				'post_content' => $p[1],
			)
		);
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['home'] );
	update_option( 'page_for_posts', $ids['news'] );
	update_option( 'wp_page_for_privacy_policy', $ids['privacy-policy'] );

	// News & announcements.
	$posts = array(
		array( 'Annual General Body Meeting – save the date', 'announcements', -2, 'All members are invited to the Annual General Body Meeting. We will review the year, present accounts and elect the new committee. Details of venue and time will be shared with members by email.' ),
		array( 'Registrations open for the Diwali community gathering', 'announcements', -5, 'Registrations are now open for our Diwali gathering with food, music and games for all ages. Please register early as seats are limited.' ),
		array( 'Bathukamma celebrations bring the community together', 'news', -17, 'More than two hundred members and friends joined our Bathukamma and Dasara celebrations. Thank you to all volunteers who made the evening special.' ),
		array( 'Welcome to our new website', 'news', -25, 'We are happy to launch the new Israel Telangana Association website, where you can follow news, events, photos and meet our committee.' ),
	);
	foreach ( $posts as $i => $p ) {
		$pid = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $p[0],
				'post_content'  => '<p>' . $p[3] . '</p>',
				'post_excerpt'  => $p[3],
				'post_category' => array( $cats[ $p[1] ] ),
				'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( $p[2] . ' days' ) ),
			)
		);
		if ( $pid && $img( $i ) ) {
			set_post_thumbnail( $pid, $img( $i ) );
		}
	}

	$highlights = array(
		array( 'Cultural programmes for children and youth', 'Dance, music and language activities that keep our young community connected to Telangana traditions.' ),
		array( 'Helping new arrivals settle in Israel', 'Our volunteers guide students and families with housing, paperwork and community introductions.' ),
		array( 'Festivals for everyone', 'From Ugadi to Bathukamma and Sankranti, we celebrate every festival together with friends from all communities.' ),
	);
	foreach ( $highlights as $i => $p ) {
		$pid = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $p[0],
				'post_content'  => '<p>' . $p[1] . '</p>',
				'post_excerpt'  => $p[1],
				'post_category' => array( $cats['community-highlights'] ),
				'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( '-' . ( 40 + $i ) . ' days' ) ),
			)
		);
		if ( $pid && $img( $i + 4 ) ) {
			set_post_thumbnail( $pid, $img( $i + 4 ) );
		}
	}

	// Events: relative dates so the sample always shows both upcoming and past.
	$events = array(
		array( 'Diwali Community Gathering', '+14 days', 'Community Hall, Tel Aviv', 'Join us for an evening of lights, music, food and games for the whole family.' ),
		array( 'Community Sports Day', '+35 days', 'Sports Park, Petah Tikva', 'Cricket, volleyball and races for all ages, followed by a shared lunch.' ),
		array( 'Sankranti Celebrations', '+80 days', 'Community Hall, Tel Aviv', 'Kite making, traditional food and cultural performances to welcome Sankranti.' ),
		array( 'Bathukamma & Dasara Celebrations', '-18 days', 'Cultural Centre, Tel Aviv', 'A colourful evening of Bathukamma, folk songs and dance with the community.' ),
		array( 'Telangana Formation Day', '-150 days', 'Community Hall, Tel Aviv', 'Flag hoisting, cultural programmes and a community dinner to mark Telangana Formation Day.' ),
		array( 'Ugadi Cultural Evening', '-220 days', 'Cultural Centre, Tel Aviv', 'Ugadi pachadi, music and a children\'s talent show.' ),
	);
	$album_photo_ids = array();
	foreach ( $imgs as $a ) {
		if ( $a ) {
			$album_photo_ids[] = $a;
		}
	}
	foreach ( $events as $i => $e ) {
		$start_ts = strtotime( $e[1] );
		$start    = wp_date( 'Y-m-d', $start_ts ) . 'T18:00';
		$end      = wp_date( 'Y-m-d', $start_ts ) . 'T21:30';
		$gal      = array_slice( $album_photo_ids, ( $i + 1 ) % 4, 4 );
		$pid      = wp_insert_post(
			array(
				'post_type'    => 'ita_event',
				'post_status'  => 'publish',
				'post_title'   => $e[0],
				'post_content' => '<p>' . $e[3] . '</p><p>Everyone is welcome. Please bring your family and friends.</p>',
				'post_excerpt' => $e[3],
				'meta_input'   => array(
					'_ita_start'    => $start,
					'_ita_end'      => $end,
					'_ita_end_eff'  => $end,
					'_ita_location' => $e[2],
					'_ita_reg_url'  => $i < 3 ? 'https://example.com/register' : '',
					'_ita_status'   => 'scheduled',
					'_ita_gallery'  => implode( ',', $gal ),
				),
			)
		);
		if ( $pid && $img( $i ) ) {
			set_post_thumbnail( $pid, $img( $i ) );
		}
	}

	// Albums.
	$albums = array(
		array( 'Bathukamma & Dasara Celebrations', 'Photos from our Bathukamma evening.', array_slice( $album_photo_ids, 0, 5 ) ),
		array( 'Telangana Formation Day', 'Moments from Formation Day.', array_slice( $album_photo_ids, 2, 5 ) ),
	);
	foreach ( $albums as $i => $a ) {
		$pid = wp_insert_post(
			array(
				'post_type'    => 'ita_album',
				'post_status'  => 'publish',
				'post_title'   => $a[0],
				'post_content' => '<p>' . $a[1] . '</p>',
				'post_excerpt' => $a[1],
				'meta_input'   => array( '_ita_gallery' => implode( ',', $a[2] ) ),
			)
		);
		if ( $pid && $img( $i + 1 ) ) {
			set_post_thumbnail( $pid, $img( $i + 1 ) );
		}
	}

	// Committee (sample people – replace with the real committee).
	$members = array(
		array( 'Sample President', 'President' ),
		array( 'Sample Vice President', 'Vice President' ),
		array( 'Sample General Secretary', 'General Secretary' ),
		array( 'Sample Joint Secretary', 'Joint Secretary' ),
		array( 'Sample Treasurer', 'Treasurer' ),
		array( 'Sample Cultural Secretary', 'Cultural Secretary' ),
	);
	foreach ( $members as $i => $m ) {
		wp_insert_post(
			array(
				'post_type'    => 'ita_member',
				'post_status'  => 'publish',
				'post_title'   => $m[0],
				'post_excerpt' => 'Short biography goes here. Replace this sample profile from Committee in the dashboard.',
				'menu_order'   => $i + 1,
				'meta_input'   => array( '_ita_designation' => $m[1] ),
			)
		);
	}

	// Menus. Theme locations are assigned by the theme once it is active.
	$menu_ids = array();
	$primary  = wp_get_nav_menu_object( 'Primary Menu' );
	$primary  = $primary ? $primary->term_id : wp_create_nav_menu( 'Primary Menu' );
	if ( $primary && ! is_wp_error( $primary ) ) {
		$items = array(
			array( 'page', $ids['home'], 'Home' ),
			array( 'page', $ids['about-us'], 'About Us' ),
			array( 'page', $ids['news'], 'News & Announcements' ),
			array( 'archive', 'ita_event', 'Recent Events' ),
			array( 'archive', 'ita_album', 'Gallery' ),
			array( 'archive', 'ita_member', 'Committee' ),
			array( 'page', $ids['membership'], 'Membership' ),
			array( 'page', $ids['contact-us'], 'Contact Us' ),
		);
		foreach ( $items as $n => $it ) {
			$args = array(
				'menu-item-title'    => $it[2],
				'menu-item-status'   => 'publish',
				'menu-item-position' => $n + 1,
			);
			if ( 'page' === $it[0] ) {
				$args += array( 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $it[1] );
			} else {
				$args += array( 'menu-item-type' => 'post_type_archive', 'menu-item-object' => $it[1] );
			}
			wp_update_nav_menu_item( $primary, 0, $args );
		}
		$menu_ids['primary'] = $primary;
	}
	$footer = wp_get_nav_menu_object( 'Footer Menu' );
	$footer = $footer ? $footer->term_id : wp_create_nav_menu( 'Footer Menu' );
	if ( $footer && ! is_wp_error( $footer ) ) {
		$fitems = array(
			array( 'About Us', $ids['about-us'] ),
			array( 'News & Announcements', $ids['news'] ),
			array( 'Contact Us', $ids['contact-us'] ),
			array( 'Privacy Policy', $ids['privacy-policy'] ),
		);
		foreach ( $fitems as $n => $it ) {
			wp_update_nav_menu_item(
				$footer,
				0,
				array(
					'menu-item-title'     => $it[0],
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $n + 1,
					'menu-item-type'      => 'post_type',
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $it[1],
				)
			);
		}
		$menu_ids['footer'] = $footer;
	}
	update_option( 'ita_menu_ids', $menu_ids );
}

function ita_about_html() {
	return '<h2>Who we are</h2>
<p>The Israel Telangana Association is a community organisation of people from Telangana living in Israel. (Replace this text with the association\'s own introduction and history.)</p>
<h2>Our history</h2>
<p>Founded by a small group of friends who wanted to celebrate festivals together, the association has grown into a vibrant community. Add key milestones and years here.</p>
<h2>Mission</h2>
<p>To preserve and promote Telangana culture, language and traditions among the community in Israel.</p>
<h2>Vision</h2>
<p>A close-knit, supportive community that is proud of its roots and contributes positively to life in Israel.</p>
<h2>Objectives</h2>
<ul><li>Celebrate Telangana festivals and cultural events.</li><li>Support new arrivals, students and families.</li><li>Build friendship with other communities in Israel.</li><li>Encourage children and youth to stay connected with their culture.</li></ul>
<h2>Community activities and achievements</h2>
<p>List cultural programmes, charity drives, sports days and other achievements here.</p>';
}
