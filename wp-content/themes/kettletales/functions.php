<?php
/**
 * Kettle Tales Theme Functions
 *
 * @package KettleTales
 */

define( 'KETTLETALES_VERSION', '1.1.0' );
define( 'KETTLETALES_DIR', get_template_directory() );
define( 'KETTLETALES_URI', get_template_directory_uri() );

require_once KETTLETALES_DIR . '/inc/theme-setup.php';
require_once KETTLETALES_DIR . '/inc/enqueue.php';
require_once KETTLETALES_DIR . '/inc/woocommerce.php';
require_once KETTLETALES_DIR . '/inc/customizer.php';

/**
 * Disable WooCommerce Coming Soon mode
 */
add_action( 'init', function () {
    if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_set_coming_soon' ) ) {
        update_option( 'woocommerce_coming_soon', 'no' );
    }
    // Also remove the Coming Soon block theme support
    remove_theme_support( 'woocommerce-coming-soon' );
} );

// Remove the coming soon redirect
add_action( 'template_redirect', function () {
    if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_is_coming_soon_page' ) && wc_is_coming_soon_page() ) {
        // Allow normal template loading
        return;
    }
}, 1 );

/**
 * Configure SMTP for email delivery (must run after WP Mail SMTP plugin)
 */
add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.gmail.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465;
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->Username   = 'ajay.biswas0@gmail.com';
    $phpmailer->Password   = 'ffda zmso gkns iqdt';
    $phpmailer->CharSet    = 'UTF-8';
    $phpmailer->From       = 'ajay.biswas0@gmail.com';
    $phpmailer->FromName   = 'Kettle Tales';
}, 99 );

add_filter( 'wp_mail_from', function( $email ) {
    return 'ajay.biswas0@gmail.com';
}, 1 );

add_filter( 'wp_mail_from_name', function( $name ) {
    return 'Kettle Tales';
}, 1 );
