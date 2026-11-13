<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ITA_SEED_VERSION', '2' );

/** Import a bundled sample image into the media library. Returns attachment ID or 0. */
function ita_import_sample_image( $slug, $title, $caption = '' ) {
	$src = ITA_CORE_DIR . 'assets/sample/' . $slug . '.jpg';
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	$up   = wp_upload_dir();
	$dest = trailingslashit( $up['path'] ) . wp_unique_filename( $up['path'], 'ita-' . $slug . '.jpg' );
	if ( ! copy( $src, $dest ) ) {
		return 0;
	}
	$att = wp_insert_attachment(
		array(
			'post_mime_type' => 'image/jpeg',
			'post_title'     => $title,
			'post_excerpt'   => $caption,
			'post_status'    => 'inherit',
		),
		$dest
	);
	if ( ! $att || is_wp_error( $att ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $dest ) );
	update_post_meta( $att, '_wp_attachment_image_alt', $title );
	return (int) $att;
}

/** Primary menu: 5 top-level items, the rest in submenus. Safe to run again. */
function ita_build_menus() {
	$page = function ( $slug ) {
		$p = get_page_by_path( $slug );
		return $p ? $p->ID : 0;
	};
	$menu_ids = array();

	$primary = wp_get_nav_menu_object( 'Primary Menu' );
	$primary = $primary ? $primary->term_id : wp_create_nav_menu( 'Primary Menu' );
	if ( $primary && ! is_wp_error( $primary ) ) {
		foreach ( (array) wp_get_nav_menu_items( $primary ) as $old ) {
			wp_delete_post( $old->ID, true );
		}
		$pos = 0;
		$add = function ( $title, $type, $ref, $parent = 0 ) use ( $primary, &$pos ) {
			$args = array(
				'menu-item-title'     => $title,
				'menu-item-status'    => 'publish',
				'menu-item-position'  => ++$pos,
				'menu-item-parent-id' => $parent,
			);
			if ( 'page' === $type ) {
				if ( ! $ref ) {
					return 0;
				}
				$args += array( 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $ref );
			} else {
				$args += array( 'menu-item-type' => 'post_type_archive', 'menu-item-object' => $ref );
			}
			return (int) wp_update_nav_menu_item( $primary, 0, $args );
		};
		$add( 'Home', 'page', $page( 'home' ) );
		$about = $add( 'About Us', 'page', $page( 'about-us' ) );
		$add( 'Our Committee', 'archive', 'ita_member', $about );
		$add( 'Membership', 'page', $page( 'membership' ), $about );
		$add( 'News & Announcements', 'page', $page( 'news' ) );
		$events = $add( 'Recent Events', 'archive', 'ita_event' );
		$add( 'Photo Gallery', 'archive', 'ita_album', $events );
		$add( 'Contact Us', 'page', $page( 'contact-us' ) );
		$menu_ids['primary'] = $primary;
	}

	$footer = wp_get_nav_menu_object( 'Footer Menu' );
	$footer = $footer ? $footer->term_id : wp_create_nav_menu( 'Footer Menu' );
	if ( $footer && ! is_wp_error( $footer ) ) {
		if ( ! wp_get_nav_menu_items( $footer ) ) {
			foreach ( array( 'about-us' => 'About Us', 'news' => 'News & Announcements', 'contact-us' => 'Contact Us', 'privacy-policy' => 'Privacy Policy' ) as $slug => $label ) {
				if ( $page( $slug ) ) {
					wp_update_nav_menu_item(
						$footer,
						0,
						array(
							'menu-item-title'     => $label,
							'menu-item-status'    => 'publish',
							'menu-item-type'      => 'post_type',
							'menu-item-object'    => 'page',
							'menu-item-object-id' => $page( $slug ),
						)
					);
				}
			}
		}
		$menu_ids['footer'] = $footer;
	}
	update_option( 'ita_menu_ids', $menu_ids );
}

function ita_seed_content() {
	$done = get_option( 'ita_seeded' );
	if ( $done ) {
		// Content already created by an earlier version: only refresh the menu structure.
		if ( ITA_SEED_VERSION !== (string) $done ) {
			ita_build_menus();
			update_option( 'ita_seeded', ITA_SEED_VERSION );
		}
		return;
	}
	update_option( 'ita_seeded', ITA_SEED_VERSION );

	update_option( 'blogname', 'Israel Telangana Association' );
	update_option( 'blogdescription', 'Our Telangana community in Israel' );
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	// ---- Images (bundled illustrations; replace with real photos) ----
	$captions = array(
		'hero'        => array( 'Charminar-inspired evening skyline', 'Illustration: evening skyline' ),
		'bathukamma'  => array( 'Bathukamma floral stack', 'The Bathukamma, a stack of seasonal flowers, is the heart of the festival.' ),
		'diwali'      => array( 'Diwali diyas', 'Rows of diyas lit for the Diwali gathering.' ),
		'sports'      => array( 'Community sports day', 'Cricket on the community sports day.' ),
		'sankranti'   => array( 'Sankranti kites', 'Kites fill the sky during Sankranti.' ),
		'formation'   => array( 'Telangana Formation Day', 'Flag hoisting on Telangana Formation Day.' ),
		'ugadi'       => array( 'Ugadi kalasam and mango-leaf toran', 'A kalasam and mango-leaf toran welcome the new year.' ),
		'community'   => array( 'Community members together', 'Members of the association at a gathering.' ),
		'kids'        => array( 'Children performing', 'Children dancing at the cultural evening.' ),
		'food'        => array( 'Traditional Telangana thali', 'A traditional thali served at community dinners.' ),
	);
	$img = array();
	foreach ( $captions as $slug => $c ) {
		$img[ $slug ] = ita_import_sample_image( $slug, $c[0], $c[1] );
	}
	$pick = function ( array $slugs ) use ( $img ) {
		return array_values( array_filter( array_map( function ( $s ) use ( $img ) { return isset( $img[ $s ] ) ? $img[ $s ] : 0; }, $slugs ) ) );
	};

	update_option(
		'ita_options',
		array(
			'hero_title'    => 'Welcome to the Israel Telangana Association',
			'hero_text'     => 'A home away from home for the Telangana community in Israel – celebrating our culture, our festivals and each other.',
			'hero_btn_text' => 'See upcoming events',
			'hero_btn_url'  => '',
			'hero_image'    => $img['hero'] ? $img['hero'] : '',
			'intro_title'   => 'Who we are',
			'intro_text'    => 'The Israel Telangana Association brings together families, students and professionals from Telangana living in Israel. Through festivals, cultural evenings, sports days and community support, we keep our traditions alive and make every newcomer feel at home.',
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

	// ---- Categories ----
	$cats = array();
	foreach ( array( 'News' => 'news', 'Announcements' => 'announcements', 'Community Highlights' => 'community-highlights' ) as $name => $slug ) {
		$term = term_exists( $slug, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
		$cats[ $slug ] = is_array( $term ) ? (int) $term['term_id'] : 0;
	}

	// ---- Pages ----
	$pages = array(
		'home'           => array( 'Home', '' ),
		'about-us'       => array( 'About Us', ita_about_html() ),
		'news'           => array( 'News & Announcements', '' ),
		'contact-us'     => array( 'Contact Us', "<p>We would love to hear from you. Send us a message using the form, or reach us using the details below. We usually reply within two working days.</p>\n[ita_contact_form]\n<h2>Contact details</h2>\n[ita_contact_info]" ),
		'membership'     => array( 'Membership', "<p>Join the Israel Telangana Association and be part of our community. Members receive invitations to all events, news updates and can volunteer on committees.</p>\n<h2>Membership types</h2>\n<ul><li><strong>Individual</strong> – for students and working professionals.</li><li><strong>Family</strong> – covers spouse and children.</li><li><strong>Student</strong> – discounted membership for students.</li></ul>\n<p>Fill in the short form below and our team will contact you.</p>\n[ita_membership_form]" ),
		'privacy-policy' => array( 'Privacy Policy', '<p>This is a sample privacy policy. We collect only the details you submit through our contact and membership forms, use them only to respond to you and to manage membership, and do not share them with third parties. You may ask us to delete your details at any time by writing to the e-mail address on the Contact page.</p><p>Please replace this text with the association\'s official policy.</p>' ),
	);
	$ids = array();
	foreach ( $pages as $slug => $p ) {
		$existing     = get_page_by_path( $slug );
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

	// ---- News & announcements ----
	$posts = array(
		array(
			'Annual General Body Meeting – save the date',
			'announcements',
			-2,
			'community',
			'All members are invited to the Annual General Body Meeting of the Israel Telangana Association.',
			"<p>All members are invited to the Annual General Body Meeting of the Israel Telangana Association. This is the place to hear about the year's activities, review the accounts and share your ideas for the coming year.</p>\n<h3>Agenda</h3>\n<ul><li>President's report and year in review</li><li>Treasurer's report and audited accounts</li><li>Election of the new executive committee</li><li>Open discussion and member suggestions</li></ul>\n<p>The venue and exact time will be shared with members by email. Light refreshments will be served after the meeting.</p>",
		),
		array(
			'Registrations open for the Diwali community gathering',
			'announcements',
			-5,
			'diwali',
			'Registrations are now open for our Diwali gathering with food, music and games for all ages.',
			"<p>Registrations are now open for our Diwali community gathering. Come and celebrate the festival of lights with food, music, rangoli and games for all ages.</p>\n<p>Seats are limited, so please register early using the link on the event page. Volunteers are welcome to help with decoration, food service and children's activities – write to us through the Contact page.</p>",
		),
		array(
			'Bathukamma celebrations bring the community together',
			'news',
			-17,
			'bathukamma',
			'More than two hundred members and friends joined our Bathukamma and Dasara celebrations.',
			"<p>More than two hundred members and friends joined our Bathukamma and Dasara celebrations. Women and girls arranged beautiful flower stacks, and the evening filled with folk songs and dance around the Bathukamma.</p>\n<p>The evening ended with a community dinner of traditional Telangana dishes. Our heartfelt thanks to all volunteers, donors and the cultural team who made the celebration a success. Photos are available in the Photo Gallery.</p>",
		),
		array(
			'Welcome to our new website',
			'news',
			-25,
			'hero',
			'We are happy to launch the new website of the Israel Telangana Association.',
			"<p>We are happy to launch the new website of the Israel Telangana Association. Here you can follow association news, see upcoming events, browse photo albums from past celebrations, meet the committee and get in touch with us.</p>\n<p>If you would like to join the association or volunteer for a programme, please use the Membership and Contact pages.</p>",
		),
	);
	foreach ( $posts as $p ) {
		$pid = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $p[0],
				'post_content'  => $p[5],
				'post_excerpt'  => $p[4],
				'post_category' => array( $cats[ $p[1] ] ),
				'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( $p[2] . ' days' ) ),
			)
		);
		if ( $pid && ! empty( $img[ $p[3] ] ) ) {
			set_post_thumbnail( $pid, $img[ $p[3] ] );
		}
	}

	$highlights = array(
		array( 'Cultural programmes for children and youth', 'kids', 'Dance, music and language activities that keep our young community connected to Telangana traditions.', "<p>Dance, music and language activities keep our children and youth connected to Telangana traditions. Every year young members perform at our festival evenings and learn about their heritage in a friendly, fun environment.</p>" ),
		array( 'Helping new arrivals settle in Israel', 'community', 'Volunteers guide students and families with housing, paperwork and community introductions.', "<p>Moving to a new country is not easy. Our volunteers guide students and families with housing, paperwork, schools and community introductions, so no one has to start alone.</p>" ),
		array( 'Festivals for everyone', 'food', 'From Ugadi to Bathukamma and Sankranti, we celebrate every festival together with friends from all communities.', "<p>From Ugadi to Bathukamma, Diwali and Sankranti, we celebrate every festival together – with traditional food, music and friends from all communities and backgrounds.</p>" ),
	);
	foreach ( $highlights as $i => $p ) {
		$pid = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $p[0],
				'post_content'  => $p[3],
				'post_excerpt'  => $p[2],
				'post_category' => array( $cats['community-highlights'] ),
				'post_date'     => wp_date( 'Y-m-d H:i:s', strtotime( '-' . ( 40 + $i ) . ' days' ) ),
			)
		);
		if ( $pid && ! empty( $img[ $p[1] ] ) ) {
			set_post_thumbnail( $pid, $img[ $p[1] ] );
		}
	}

	// ---- Events (relative dates so both lists always have samples) ----
	$events = array(
		array( 'Diwali Community Gathering', '+14 days', 'Community Hall, Tel Aviv', 'diwali', array( 'diwali', 'community', 'food', 'kids' ), true,
			"<p>Join us for an evening of lights, music, food and games for the whole family.</p>\n<h3>Programme</h3>\n<ul><li>6:00 PM – Welcome and diya lighting</li><li>6:30 PM – Cultural performances by children</li><li>7:30 PM – Community dinner</li><li>8:30 PM – Music and games</li></ul>\n<p>Entry is free for members. Please register in advance so we can plan the food." ),
		array( 'Community Sports Day', '+35 days', 'Sports Park, Petah Tikva', 'sports', array( 'sports', 'community', 'food' ), true,
			"<p>Cricket, volleyball and races for all ages, followed by a shared lunch.</p>\n<p>Teams will be formed on the day; bring comfortable clothes, water and sunscreen. Volunteers for scoring and first-aid are welcome.</p>" ),
		array( 'Sankranti Celebrations', '+80 days', 'Community Hall, Tel Aviv', 'sankranti', array( 'sankranti', 'food', 'community', 'kids' ), true,
			"<p>Kite making, traditional food and cultural performances to welcome Sankranti.</p>\n<p>There will be a kite-making workshop for children, a rangoli competition and a sweets stall. All are welcome.</p>" ),
		array( 'Bathukamma & Dasara Celebrations', '-18 days', 'Cultural Centre, Tel Aviv', 'bathukamma', array( 'bathukamma', 'community', 'kids', 'food' ), false,
			"<p>A colourful evening of Bathukamma, folk songs and dance with the community.</p>\n<p>More than two hundred members and friends celebrated together. Thank you to everyone who brought flowers, helped decorate and joined the dance.</p>" ),
		array( 'Telangana Formation Day', '-150 days', 'Community Hall, Tel Aviv', 'formation', array( 'formation', 'community', 'kids', 'sports' ), false,
			"<p>Flag hoisting, cultural programmes and a community dinner marked Telangana Formation Day.</p>\n<p>The programme included speeches by the committee, songs by the children's choir and a quiz on Telangana history.</p>" ),
		array( 'Ugadi Cultural Evening', '-220 days', 'Cultural Centre, Tel Aviv', 'ugadi', array( 'ugadi', 'food', 'kids', 'community' ), false,
			"<p>Ugadi pachadi, music and a children's talent show welcomed the new year.</p>\n<p>The panchangam reading and the traditional six-taste pachadi were shared with all guests.</p>" ),
	);
	foreach ( $events as $e ) {
		$ts    = strtotime( $e[1] );
		$start = wp_date( 'Y-m-d', $ts ) . 'T18:00';
		$end   = wp_date( 'Y-m-d', $ts ) . 'T21:30';
		$plain = wp_strip_all_tags( explode( '</p>', $e[6] )[0] );
		$pid   = wp_insert_post(
			array(
				'post_type'    => 'ita_event',
				'post_status'  => 'publish',
				'post_title'   => $e[0],
				'post_content' => $e[6] . ( substr( $e[6], -4 ) === '</p>' || substr( $e[6], -5 ) === '</ul>' ? '' : '</p>' ),
				'post_excerpt' => $plain,
				'meta_input'   => array(
					'_ita_start'   => $start,
					'_ita_end'     => $end,
					'_ita_end_eff' => $end,
					'_ita_location' => $e[2],
					'_ita_reg_url' => $e[5] ? 'https://example.com/register' : '',
					'_ita_status'  => 'scheduled',
					'_ita_gallery' => implode( ',', $pick( $e[4] ) ),
				),
			)
		);
		if ( $pid && ! empty( $img[ $e[3] ] ) ) {
			set_post_thumbnail( $pid, $img[ $e[3] ] );
		}
	}

	// ---- Albums ----
	$albums = array(
		array( 'Bathukamma & Dasara Celebrations', 'Photos from our Bathukamma and Dasara evening.', 'bathukamma', array( 'bathukamma', 'kids', 'community', 'food', 'ugadi' ) ),
		array( 'Telangana Formation Day', 'Moments from Telangana Formation Day.', 'formation', array( 'formation', 'community', 'kids', 'sports' ) ),
		array( 'Festival of Lights', 'Diwali and Sankranti moments.', 'diwali', array( 'diwali', 'sankranti', 'community', 'food' ) ),
	);
	foreach ( $albums as $a ) {
		$pid = wp_insert_post(
			array(
				'post_type'    => 'ita_album',
				'post_status'  => 'publish',
				'post_title'   => $a[0],
				'post_content' => '<p>' . $a[1] . '</p>',
				'post_excerpt' => $a[1],
				'meta_input'   => array( '_ita_gallery' => implode( ',', $pick( $a[3] ) ) ),
			)
		);
		if ( $pid && ! empty( $img[ $a[2] ] ) ) {
			set_post_thumbnail( $pid, $img[ $a[2] ] );
		}
	}

	// ---- Committee (sample people – replace with the real committee) ----
	$members = array(
		array( 'Ravi Kumar (sample)', 'President', 'Leads the association and represents it in the community. Replace this sample profile with the real biography.' ),
		array( 'Lakshmi Devi (sample)', 'Vice President', 'Supports the President and coordinates cultural programmes. Replace this sample profile.' ),
		array( 'Suresh Reddy (sample)', 'General Secretary', 'Manages day-to-day operations, communication and meetings. Replace this sample profile.' ),
		array( 'Anitha Rao (sample)', 'Joint Secretary', 'Assists with events, volunteers and member services. Replace this sample profile.' ),
		array( 'Venkat Goud (sample)', 'Treasurer', 'Looks after the accounts, membership fees and budgets. Replace this sample profile.' ),
		array( 'Sravani Naik (sample)', 'Cultural Secretary', 'Plans festivals, performances and youth activities. Replace this sample profile.' ),
	);
	foreach ( $members as $i => $m ) {
		$pid = wp_insert_post(
			array(
				'post_type'    => 'ita_member',
				'post_status'  => 'publish',
				'post_title'   => $m[0],
				'post_content' => '<p>' . $m[2] . '</p>',
				'post_excerpt' => $m[2],
				'menu_order'   => $i + 1,
				'meta_input'   => array( '_ita_designation' => $m[1] ),
			)
		);
		$av = ita_import_sample_image( 'avatar-' . ( $i + 1 ), $m[0], 'Sample portrait' );
		if ( $pid && $av ) {
			set_post_thumbnail( $pid, $av );
		}
	}

	ita_build_menus();
}

function ita_about_html() {
	return '<h2>Who we are</h2>
<p>The Israel Telangana Association is a community organisation of people from Telangana living in Israel – families, students, researchers and professionals who share a language, a cuisine and a love for our festivals. We welcome friends from every community.</p>
<h2>Our history</h2>
<p>The association began as a small circle of friends who gathered to celebrate Ugadi and Bathukamma together far from home. As more families arrived, those gatherings grew into an organised community with an elected committee, regular events and a growing membership. (Replace this sample text with the association\'s real history and key milestones.)</p>
<h2>Mission</h2>
<p>To preserve and promote Telangana culture, language and traditions among the community in Israel, and to support every member in times of need.</p>
<h2>Vision</h2>
<p>A close-knit, supportive community that is proud of its roots, contributes positively to life in Israel and builds lasting friendships with its neighbours.</p>
<h2>Objectives</h2>
<ul><li>Celebrate Telangana festivals and cultural events.</li><li>Support new arrivals, students and families.</li><li>Build friendship and cooperation with other communities in Israel.</li><li>Encourage children and youth to stay connected with their culture and language.</li><li>Organise sports, learning and networking activities.</li></ul>
<h2>Community activities and achievements</h2>
<ul><li>Annual celebrations of Ugadi, Bathukamma &amp; Dasara, Diwali and Sankranti.</li><li>Telangana Formation Day programme every June.</li><li>Cultural programmes and talent shows for children and youth.</li><li>Welcome and support service for new arrivals and students.</li><li>Community sports day and family get-togethers.</li></ul>
<p>Meet the people who lead the association on the <a href="' . esc_url( get_post_type_archive_link( 'ita_member' ) ) . '">Committee page</a>.</p>';
}
