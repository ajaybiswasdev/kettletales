<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Shop Header -->
    <header class="shop-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-5">
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
                <div class="col-lg-8 col-md-7">
                    <nav class="shop-nav">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="shop-nav-link"><?php esc_html_e( 'Shop', 'kettletales' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="shop-nav-link"><?php esc_html_e( 'Home', 'kettletales' ); ?></a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>" class="shop-nav-link"><?php esc_html_e( 'My Account', 'kettletales' ); ?></a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="shop-nav-link"><?php esc_html_e( 'Sign in', 'kettletales' ); ?></a>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) . '?register=1' ); ?>" class="shop-nav-link shop-nav-btn"><?php esc_html_e( 'Sign up', 'kettletales' ); ?></a>
                        <?php endif; ?>
                        <div class="shop-cart">
                            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="shop-cart-link">
                                <i class="fas fa-shopping-bag"></i>
                                <span class="shop-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="page shop-page">
