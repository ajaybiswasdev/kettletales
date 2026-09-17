<?php
/**
 * WooCommerce Integration
 *
 * @package KettleTales
 */

/**
 * Declare WooCommerce support
 */
function kettletales_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 400,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 4,
        ),
    ) );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kettletales_woocommerce_support' );

/**
 * WooCommerce wrapper classes
 */
function kettletales_woocommerce_wrapper_before() {
    echo '<div class="woocommerce-wrapper"><div class="container">';
}
add_action( 'woocommerce_before_main_content', 'kettletales_woocommerce_wrapper_before' );

function kettletales_woocommerce_wrapper_after() {
    echo '</div></div>';
}
add_action( 'woocommerce_after_main_content', 'kettletales_woocommerce_wrapper_after' );

/**
 * Change WooCommerce product per page
 */
function kettletales_products_per_page( $cols ) {
    return 12;
}
add_filter( 'loop_shop_per_page', 'kettletales_products_per_page' );

/**
 * Change related products count
 */
function kettletales_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns']        = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'kettletales_related_products_args' );

/**
 * Get products by category slug.
 *
 * @param string $category_slug Category slug.
 * @param int    $limit         Number of products to get (-1 for all).
 * @return array Array of WC_Product objects.
 */
function kettletales_get_products_by_category( $category_slug, $limit = -1 ) {
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ),
        'orderby'  => 'menu_order',
        'order'    => 'ASC',
    );

    $query = new WP_Query( $args );
    return $query->posts;
}

/**
 * Get the first (featured) product from a category.
 *
 * @param string $category_slug Category slug.
 * @return WC_Product|null Product object or null.
 */
function kettletales_get_featured_product( $category_slug ) {
    $products = kettletales_get_products_by_category( $category_slug, 1 );
    if ( ! empty( $products ) ) {
        return wc_get_product( $products[0]->ID );
    }
    return null;
}

/**
 * Get the weight-based price table for a variable product.
 * Looks for an attribute named "weight" (or "Weight") and returns
 * formatted price rows for each variation.
 *
 * @param WC_Product $product Product object.
 * @return string HTML of the price table.
 */
function kettletales_get_weight_price_table( $product ) {
    if ( ! $product || ! $product->is_type( 'variable' ) ) {
        return '';
    }

    $variations = $product->get_children();
    if ( empty( $variations ) ) {
        return '';
    }

    $weight_attr = null;
    $attributes  = $product->get_attributes();

    foreach ( $attributes as $attr ) {
        $name = wc_attribute_label( $attr->get_name() );
        if ( in_array( strtolower( $name ), array( 'weight', 'weights', 'size', 'sizes' ), true ) ) {
            $weight_attr = $attr;
            break;
        }
    }

    if ( ! $weight_attr ) {
        return '';
    }

    $html = '<div class="price-box">';
    $html .= '<strong>' . esc_html__( 'Price:', 'kettletales' ) . '</strong>';

    foreach ( $variations as $variation_id ) {
        $variation = wc_get_product( $variation_id );
        if ( ! $variation || ! $variation->is_visible() ) {
            continue;
        }

        $variation_attr = $variation->get_attribute( $weight_attr->get_name() );
        $price          = $variation->get_price_html();

        if ( $variation_attr && $price ) {
            $html .= '<div>' . esc_html( $variation_attr ) . ' &ndash; <span>' . wp_kses_post( $price ) . '</span></div>';
        }
    }

    $html .= '</div>';
    return $html;
}

/**
 * Get all published products for the tea slider.
 *
 * @param int $limit Max products to return.
 * @return array Array of WC_Product objects.
 */
function kettletales_get_all_products( $limit = -1 ) {
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    $query = new WP_Query( $args );
    return $query->posts;
}

/**
 * Remove WooCommerce default styles
 */
function kettletales_dequeue_default_styles() {
    wp_dequeue_style( 'woocommerce-general' );
    wp_dequeue_style( 'woocommerce-layout' );
    wp_dequeue_style( 'woocommerce-smallscreen' );
    wp_dequeue_script( 'wc-tabs' );
}
add_action( 'wp_enqueue_scripts', 'kettletales_dequeue_default_styles', 99 );

/**
 * Inject weight price table on single product page.
 * Hooked at priority 26 (after price at 25, before add-to-cart at 30).
 */
function kettletales_weight_price_table_single() {
    if ( ! is_product() ) {
        return;
    }
    global $product;
    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }
    if ( ! $product ) {
        return;
    }
    echo '<div class="price-box-single">';
    echo kettletales_get_weight_price_table( $product );
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'kettletales_weight_price_table_single', 26 );

/**
 * Hide default WooCommerce price on single product page for variable products
 * (we show our custom weight price table instead).
 */
function kettletales_hide_default_price_single() {
    if ( ! is_product() ) {
        return;
    }
    global $product;
    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }
    if ( ! $product ) {
        return;
    }
    if ( $product->is_type( 'variable' ) ) {
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
    }
}
add_action( 'wp', 'kettletales_hide_default_price_single' );

/**
 * Remove default WooCommerce reviews from single product summary.
 * Reviews are handled by our custom reviews.php tab template instead.
 */
function kettletales_remove_default_reviews() {
    if ( ! is_product() ) {
        return;
    }
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_reviews', 10 );
}
add_action( 'wp', 'kettletales_remove_default_reviews' );

/**
 * Get the quick-add-to-cart overlay HTML for a product card.
 * Shows a weight dropdown + add to cart button on hover.
 *
 * @param WC_Product $product Product object.
 * @return string HTML of the quick-add overlay.
 */
function kettletales_get_quick_add_html( $product ) {
    if ( ! $product ) {
        return '';
    }

    $product_id = $product->get_id();

    if ( ! $product->is_in_stock() ) {
        return '<div class="kt-quick-add"><span class="kt-quick-oos">Out of Stock</span></div>';
    }

    if ( $product->is_type( 'variable' ) ) {
        $variations = $product->get_children();
        if ( empty( $variations ) ) {
            return '';
        }

        $weight_attr = null;
        $attributes  = $product->get_attributes();

        foreach ( $attributes as $attr ) {
            $name = wc_attribute_label( $attr->get_name() );
            if ( in_array( strtolower( $name ), array( 'weight', 'weights', 'size', 'sizes' ), true ) ) {
                $weight_attr = $attr;
                break;
            }
        }

        if ( ! $weight_attr ) {
            return '';
        }

        $html = '<div class="kt-quick-add" data-product-id="' . esc_attr( $product_id ) . '">';
        $html .= '<div class="kt-quick-sizes">';

        foreach ( $variations as $variation_id ) {
            $variation = wc_get_product( $variation_id );
            if ( ! $variation || ! $variation->is_visible() || ! $variation->is_in_stock() ) {
                continue;
            }
            $variation_attr = $variation->get_attribute( $weight_attr->get_name() );

            if ( $variation_attr ) {
                $html .= '<button type="button" class="kt-size-pill" data-variation-id="' . esc_attr( $variation_id ) . '">';
                $html .= esc_html( $variation_attr );
                $html .= '</button>';
            }
        }

        $html .= '</div>';
        $html .= '<button class="kt-quick-add-btn" data-product-id="' . esc_attr( $product_id ) . '" disabled><i class="fas fa-shopping-bag"></i> ' . esc_html__( 'Add to Cart', 'kettletales' ) . '</button>';
        $html .= '</div>';

        return $html;
    }

    return '<div class="kt-quick-add"><a href="' . esc_url( wc_add_to_cart_url( $product_id ) ) . '" class="kt-quick-add-btn"><i class="fas fa-shopping-bag"></i> ' . esc_html__( 'Add to Cart', 'kettletales' ) . '</a></div>';
}

/**
 * AJAX handler for adding variable products to cart from homepage.
 */
function kettletales_ajax_add_variation_to_cart() {
    if ( ! function_exists( 'WC' ) ) {
        wp_send_json_error( array( 'message' => __( 'WooCommerce is not active.', 'kettletales' ) ) );
    }

    if ( ! did_action( 'woocommerce_init' ) ) {
        if ( ! WC()->session ) {
            WC()->session = new WC_Session_Handler();
            WC()->session->init();
        }
        if ( ! WC()->cart ) {
            WC()->cart = new WC_Cart();
        }
    }

    $variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;

    if ( ! $variation_id ) {
        wp_send_json_error( array( 'message' => __( 'Please select a size.', 'kettletales' ) ) );
    }

    $variation = wc_get_product( $variation_id );
    if ( ! $variation ) {
        wp_send_json_error( array( 'message' => __( 'Variation not found.', 'kettletales' ) ) );
    }

    if ( ! $variation->is_in_stock() ) {
        wp_send_json_error( array( 'message' => __( 'This variation is not available.', 'kettletales' ) ) );
    }

    $product_id    = $variation->get_parent_id();
    $variation_attr = array();

    foreach ( $variation->get_attributes() as $key => $value ) {
        $variation_attr[ 'attribute_' . sanitize_title( $key ) ] = $value;
    }

    $added = WC()->cart->add_to_cart( $product_id, 1, $variation_id, $variation_attr );

    if ( ! $added ) {
        wp_send_json_error( array( 'message' => __( 'Could not add to cart. Please try again.', 'kettletales' ) ) );
    }

    wp_send_json_success( array(
        'message'    => __( 'Added to cart!', 'kettletales' ),
        'fragments'  => apply_filters( 'woocommerce_add_to_cart_fragments', array(
            '.shop-cart-count' => '<span class="shop-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>',
        ) ),
    ) );
}
add_action( 'wp_ajax_kt_add_variation_to_cart', 'kettletales_ajax_add_variation_to_cart' );
add_action( 'wp_ajax_nopriv_kt_add_variation_to_cart', 'kettletales_ajax_add_variation_to_cart' );

/**
 * Register custom cart count selector with wc-cart-fragments
 * so it auto-updates on every page load.
 */
function kettletales_cart_fragments( $fragments ) {
    $fragments['.shop-cart-count'] = '<span class="shop-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'kettletales_cart_fragments' );

/**
 * Kolkata postcode shipping: 700xxx = FREE, rest of WB = ₹30, other states = ₹80.
 *
 * WooCommerce Blocks doesn't support postcode ranges, so we override flat_rate
 * cost at runtime based on the customer's postcode.
 */
function kettletales_kolkata_shipping_rate( $rates, $package ) {
    if ( empty( $rates ) ) {
        return $rates;
    }

    $customer    = WC()->customer;
    $country     = $customer->get_shipping_country();
    $state       = $customer->get_shipping_state();
    $postcode    = trim( $customer->get_shipping_postcode() );

    foreach ( $rates as $rate_id => $rate ) {
        if ( 'flat_rate' !== $rate->method_id ) {
            continue;
        }

        if ( 'IN' !== $country ) {
            continue;
        }

        if ( 'WB' === $state && strlen( $postcode ) === 6 && substr( $postcode, 0, 3 ) === '700' ) {
            $rate->cost = '0';
            $rate->set_label( 'Kolkata Local (Free)' );
        } elseif ( 'WB' === $state ) {
            $rate->cost = '30';
            $rate->set_label( 'Rest of West Bengal' );
        } else {
            $rate->cost = '80';
            $rate->set_label( 'Other States' );
        }
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'kettletales_kolkata_shipping_rate', 20, 2 );
