<?php
/**
 * Theme Setup
 *
 * @package KettleTales
 */

function kettletales_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );

    add_image_size( 'kettletales-product', 600, 600, true );
    add_image_size( 'kettletales-hero', 1920, 1080, true );

    register_nav_menus( array(
        'primary'   => esc_html__( 'Primary Menu', 'kettletales' ),
        'hamburger' => esc_html__( 'Hamburger Menu', 'kettletales' ),
        'footer'    => esc_html__( 'Footer Menu', 'kettletales' ),
    ) );

    load_theme_textdomain( 'kettletales', KETTLETALES_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'kettletales_setup' );

function kettletales_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'kettletales_content_width', 1400 );
}
add_action( 'after_setup_theme', 'kettletales_content_width', 0 );

function kettletales_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'kettletales' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'kettletales' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area', 'kettletales' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area.', 'kettletales' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'kettletales_widgets_init' );
