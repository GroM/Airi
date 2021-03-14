<?php
/**
 * Template part for Menu style 2
 *
 * @package Airi
 */

$airi_options = airi_get_extended1_options();
// var_dump($airi_options);
?>

<header id="masthead" class="site-header">
	
	<div class="<?php echo esc_attr( airi_menu_container() ); ?>">
		<div class="row">
			<div class="site-branding col-md-4 col-sm-6 col-9">
				<?php airi_site_branding(); ?>
			</div><!-- .site-branding -->

			<div class="header-mobile-menu col-md-8 col-sm-6 col-3">
				<button class="mobile-menu-toggle" aria-controls="primary-menu">
					<span class="mobile-menu-toggle_lines"></span>
					<span class="sr-only"><?php esc_html_e( 'Toggle mobile menu', 'airi' ); ?></span>
				</button>
			</div>

			<div class="top-bar col-xl-8 col-12">
				<div class="row">
					<div class="ms-auto col-auto contact-item">
						<i class="fa fa-envelope"></i><a href="mailto:<?php echo antispambot( $airi_options['email_address'] ); ?>"><?php echo antispambot( $airi_options['email_address'] ); ?></a>
					</div>
					<div class="col-auto contact-item">
						<i class="fa fa-phone"></i><a href="tel:<?php echo esc_attr( $airi_options['phone_number'] ); ?>"><?php echo esc_html( $airi_options['phone_number'] ); ?></a>
					</div>
					<div class="col-auto header-social contact-item">
						<?php foreach ( $airi_options['header_social'] as $airi_social ) : ?>
							<a target="_blank" href="<?php echo esc_url( $airi_social['link_url'] ); ?>"><i class="fa <?php echo esc_attr( $airi_social['icon'] ); ?>"></i></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<nav id="site-navigation" class="main-navigation mt-3">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
				?>
				<?php airi_header_cart_search(); ?>
			</nav><!-- #site-navigation -->

		</div>
	</div>
	<div class="header-search-form">
		<?php get_search_form(); ?>
	</div>	

</header><!-- #masthead -->