<?php
/**
 * Enqueue scripts and styles
 *
 * @package KettleTales
 */

function kettletales_scripts() {
    $theme_uri = KETTLETALES_URI;

    // Google Fonts
    wp_enqueue_style( 'kettletales-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lavishly+Yours&display=swap',
        array(),
        null
    );

    // Bootstrap CSS
    wp_enqueue_style( 'bootstrap',
        $theme_uri . '/assets/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Font Awesome
    wp_enqueue_style( 'fontawesome',
        $theme_uri . '/assets/css/fontawesome.min.css',
        array(),
        '5.15.4'
    );

    // Slick CSS
    wp_enqueue_style( 'slick',
        $theme_uri . '/assets/css/slick.css',
        array(),
        '1.8.1'
    );
    wp_enqueue_style( 'slick-theme',
        $theme_uri . '/assets/css/slick-theme.css',
        array( 'slick' ),
        '1.8.1'
    );

    // Theme main stylesheet
    wp_enqueue_style( 'kettletales-main',
        $theme_uri . '/assets/css/kettletales.css',
        array( 'bootstrap', 'fontawesome', 'slick' ),
        KETTLETALES_VERSION
    );

    // Theme metadata stylesheet (WordPress requirement)
    wp_enqueue_style( 'kettletales-style',
        get_stylesheet_uri(),
        array( 'kettletales-main' ),
        KETTLETALES_VERSION
    );

    // Dynamic inline CSS for theme directory URLs
    $dynamic_css = kettletales_get_dynamic_css();
    wp_add_inline_style( 'kettletales-main', $dynamic_css );

    // jQuery
    wp_enqueue_script( 'jquery' );

    // Bootstrap JS
    wp_enqueue_script( 'bootstrap',
        $theme_uri . '/assets/js/bootstrap.bundle.min.js',
        array( 'jquery' ),
        '5.3.3',
        true
    );

    // Slick JS
    wp_enqueue_script( 'slick',
        $theme_uri . '/assets/js/slick.min.js',
        array( 'jquery' ),
        '1.8.1',
        true
    );

    // GSAP
    wp_enqueue_script( 'gsap',
        $theme_uri . '/assets/js/gsap.min.js',
        array(),
        '3.12.7',
        true
    );
    wp_enqueue_script( 'gsap-scrolltrigger',
        $theme_uri . '/assets/js/ScrollTrigger.min.js',
        array( 'gsap' ),
        '3.12.7',
        true
    );
    wp_enqueue_script( 'gsap-scrollto',
        $theme_uri . '/assets/js/ScrollToPlugin.min.js',
        array( 'gsap' ),
        '3.12.7',
        true
    );

    // Jarallax
    wp_enqueue_script( 'jarallax',
        $theme_uri . '/assets/js/jarallax.min.js',
        array(),
        '2.0.0',
        true
    );

    // Theme main script
    wp_enqueue_script( 'kettletales-main',
        $theme_uri . '/assets/js/main.js',
        array( 'jquery', 'slick', 'gsap', 'gsap-scrolltrigger', 'gsap-scrollto', 'jarallax' ),
        KETTLETALES_VERSION,
        true
    );

    wp_localize_script( 'kettletales-main', 'kt_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
    ) );

    // WooCommerce scripts on shop pages + homepage (for quick add-to-cart)
    if ( function_exists( 'is_woocommerce' ) && ( is_product() || is_cart() || is_checkout() || is_account_page() || is_shop() || is_product_taxonomy() || is_front_page() ) ) {
        wp_enqueue_script( 'wc-add-to-cart-variation' );
        wp_enqueue_script( 'wc-single-product' );
    }

    // WooCommerce cart fragments for AJAX cart count updates
    if ( function_exists( 'WC' ) && ! is_admin() ) {
        wp_enqueue_script( 'wc-cart-fragments' );
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'kettletales_scripts' );

/**
 * Generate dynamic CSS with theme directory URLs
 */
function kettletales_get_dynamic_css() {
    $theme_uri = KETTLETALES_URI;

    return "
        .tea-slider .slick-arrow.slick-prev {
            background: url('{$theme_uri}/assets/images/prev-arrow.png') no-repeat center;
        }
        .tea-slider .slick-arrow.slick-next {
            background: url('{$theme_uri}/assets/images/next-arrow.png') no-repeat center;
        }
        .quality-section .quality-section-top h2::after {
            background: url('{$theme_uri}/assets/images/dash.png') no-repeat center;
        }
    ";
}
