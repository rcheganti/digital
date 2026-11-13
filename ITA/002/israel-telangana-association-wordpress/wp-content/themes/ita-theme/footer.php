<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
</main>
<footer class="site-footer">
	<div class="wrap footer-cols">
		<div>
			<h3><?php bloginfo( 'name' ); ?></h3>
			<p><?php echo esc_html( ita_opt( 'footer_text', get_bloginfo( 'description' ) ) ); ?></p>
		</div>
		<div>
			<h3>Quick links</h3>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
		<div>
			<h3>Contact</h3>
			<?php if ( ita_opt( 'email' ) ) : ?><p><a href="mailto:<?php echo esc_attr( antispambot( ita_opt( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( ita_opt( 'email' ) ) ); ?></a></p><?php endif; ?>
			<?php if ( ita_opt( 'phone' ) ) : ?><p><?php echo esc_html( ita_opt( 'phone' ) ); ?></p><?php endif; ?>
			<?php if ( function_exists( 'ita_social_links' ) ) : ?>
				<p class="social"><?php foreach ( ita_social_links() as $label => $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a><?php endforeach; ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="wrap footer-bottom">
		<span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</span>
		<?php if ( get_privacy_policy_url() ) : ?><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a><?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
