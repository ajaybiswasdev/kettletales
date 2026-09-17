<?php
require 'C:/xampp/htdocs/kettletales/wp-load.php';

// Find which template WC is loading for single product
$path = WC()->template_path();
echo "WC template path: " . $path . "\n";

// Check if the content-single-product template exists in WC templates
$wc_template = WP_PLUGIN_DIR . '/woocommerce/templates/content-single-product.php';
echo "WC default template: " . (file_exists($wc_template) ? $wc_template : 'NOT FOUND') . "\n";

// Check the theme template
$theme_template = get_stylesheet_directory() . '/woocommerce/content-single-product.php';
echo "Theme template: " . (file_exists($theme_template) ? $theme_template : 'NOT FOUND') . "\n";

// Check what template_redirect is doing
echo "\nIs product: " . (is_product() ? 'YES' : 'NO') . "\n";
echo "Is singular: " . (is_singular('product') ? 'YES' : 'NO') . "\n";

// Check what template WordPress is loading
$template = get_page_template();
echo "Page template: " . ($template ? $template : 'DEFAULT') . "\n";

echo "\nTemplate hierarchy:\n";
if (is_product()) {
    echo "  single-product-{slug}.php\n";
    echo "  single-product.php\n";
    echo "  product-{slug}.php\n";
    echo "  product.php\n";
    echo "  singular.php\n";
    echo "  index.php\n";
}

// Check for woocommerce.php
$wc_wrapper = get_stylesheet_directory() . '/woocommerce.php';
echo "\nwoocommerce.php wrapper: " . (file_exists($wc_wrapper) ? $wc_wrapper : 'NOT FOUND') . "\n";

// Check the WP template being used
echo "WP template: " . get_page_template_slug() . "\n";
echo "Template file: " . get_page_template() . "\n";
