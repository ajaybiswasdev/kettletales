<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) : ?>

    <!-- Shop Header -->
    <header class="shop-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5 col-6">
                    <div class="logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php if ( has_custom_logo() ) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/TeaLabel.png' ); ?>" class="logo-img" alt="<?php bloginfo( 'name' ); ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 col-6 text-end">
                    <nav class="shop-nav">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="shop-nav-link shop-nav-desktop"><?php esc_html_e( 'Shop', 'kettletales' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shop-nav-link shop-nav-desktop"><?php esc_html_e( 'Home', 'kettletales' ); ?></a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="shop-nav-link shop-nav-desktop"><?php esc_html_e( 'My Account', 'kettletales' ); ?></a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="shop-nav-link shop-nav-desktop"><?php esc_html_e( 'Sign in', 'kettletales' ); ?></a>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) . '?register=1' ); ?>" class="shop-nav-link shop-nav-btn shop-nav-desktop"><?php esc_html_e( 'Sign up', 'kettletales' ); ?></a>
                        <?php endif; ?>
                        <div class="shop-cart">
                            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shop-cart-link">
                                <i class="fas fa-shopping-bag"></i>
                                <span class="shop-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                        </div>
                        <button class="shop-menu-toggle" aria-label="Toggle menu">
                            <i class="fas fa-bars"></i>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="shop-mobile-menu">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="shop-mobile-link"><?php esc_html_e( 'Shop', 'kettletales' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shop-mobile-link"><?php esc_html_e( 'Home', 'kettletales' ); ?></a>
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="shop-mobile-link"><?php esc_html_e( 'My Account', 'kettletales' ); ?></a>
                <?php else : ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="shop-mobile-link"><?php esc_html_e( 'Sign in', 'kettletales' ); ?></a>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) . '?register=1' ); ?>" class="shop-mobile-link shop-mobile-btn"><?php esc_html_e( 'Sign up', 'kettletales' ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </header>

<?php else : ?>

    <!-- Header -->
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4">
                    <div class="logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php if ( has_custom_logo() ) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/TeaLabel.png' ); ?>" class="logo-img" alt="<?php bloginfo( 'name' ); ?>">
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 text-end">
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Header (visible only on <=991px, replaces header + topbar) -->
    <header class="kt-mobile-header">
        <div class="kt-mobile-header-inner">
            <div class="kt-mobile-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/TeaLabel.png' ); ?>" class="kt-mobile-logo-img" alt="<?php bloginfo( 'name' ); ?>">
                </a>
            </div>
            <div class="kt-mobile-nav">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="kt-mobile-link"><?php esc_html_e( 'My Account', 'kettletales' ); ?></a>
                <?php else : ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="kt-mobile-link"><?php esc_html_e( 'Sign in', 'kettletales' ); ?></a>
                <?php endif; ?>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="kt-mobile-cart" aria-label="<?php esc_attr_e( 'View Cart', 'kettletales' ); ?>">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="shop-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
                <button class="menu-toggle" aria-label="Toggle menu">
                    &#9776;
                </button>
            </div>
        </div>
    </header>

    <!-- Right Side Menu -->
    <nav class="side-menu">
        <?php if ( has_nav_menu( 'hamburger' ) ) : ?>
            <?php wp_nav_menu( array(
                'theme_location' => 'hamburger',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => false,
                'depth'          => 1,
            ) ); ?>
        <?php else : ?>
            <ul>
                <li><a href="#home"><?php esc_html_e( 'Home', 'kettletales' ); ?></a></li>
                <li><a href="#collections"><?php esc_html_e( 'Himalayan Collection', 'kettletales' ); ?> &#127807;</li>
                <li><a href="#assam"><?php esc_html_e( 'Signature Collection', 'kettletales' ); ?> &#127807;</li>
                <li><a href="#wellness"><?php esc_html_e( 'Wellness Collection', 'kettletales' ); ?> &#127807;</li>
                <li><a href="#story"><?php esc_html_e( 'Our Story', 'kettletales' ); ?></a></li>
                <li><a href="#quality"><?php esc_html_e( 'Quality & Sourcing', 'kettletales' ); ?></a></li>
                <li><a href="#contact"><?php esc_html_e( 'Contact', 'kettletales' ); ?></a></li>
            </ul>
        <?php endif; ?>
        <span class="menu-line"></span>
    </nav>
    <div class="kt-hero-topbar">
        <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="kt-hero-topbar-link"><?php esc_html_e( 'My Account', 'kettletales' ); ?></a>
        <?php else : ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="kt-hero-topbar-link"><?php esc_html_e( 'Sign in', 'kettletales' ); ?></a>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) . '?register=1' ); ?>" class="kt-hero-topbar-link kt-hero-topbar-btn"><?php esc_html_e( 'Sign up', 'kettletales' ); ?></a>
        <?php endif; ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="kt-hero-cart" aria-label="<?php esc_attr_e( 'View Cart', 'kettletales' ); ?>">
            <i class="fas fa-shopping-bag"></i>
            <span class="shop-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <button class="menu-toggle" aria-label="Toggle menu">
            &#9776;
        </button>
    </div>
    <div class="menu-overlay"></div>

<?php endif; ?>
<div class="page">
