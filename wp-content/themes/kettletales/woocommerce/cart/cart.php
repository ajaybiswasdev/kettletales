<?php
/**
 * Cart Page — Professional Card Layout
 *
 * @package KettleTales
 * @version 11.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="kt-cart-page">
    <div class="kt-cart-header">
        <h1 class="kt-cart-title"><?php esc_html_e( 'Shopping Cart', 'kettletales' ); ?></h1>
        <p class="kt-cart-subtitle"><?php printf( esc_html( _n( '%d item in your cart', '%d items in your cart', WC()->cart->get_cart_contents_count(), 'kettletales' ) ), WC()->cart->get_cart_contents_count() ); ?></p>
    </div>

    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <div class="kt-cart-layout">

            <div class="kt-cart-items">
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    $visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

                    if ( ! ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) ) {
                        continue;
                    }

                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                    <div class="kt-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                        <div class="kt-cart-item-remove">
                            <?php echo apply_filters( 'woocommerce_cart_item_remove_link',
                                sprintf( '<a href="%s" class="kt-remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fas fa-times"></i></a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    esc_attr( sprintf( __( 'Remove %s', 'kettletales' ), wp_strip_all_tags( $product_name ) ) ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                            ?>
                        </div>

                        <div class="kt-cart-item-thumb">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                            if ( ! $product_permalink ) {
                                echo $thumbnail;
                            } else {
                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                            }
                            ?>
                        </div>

                        <div class="kt-cart-item-details">
                            <h3 class="kt-cart-item-name">
                                <?php if ( $product_permalink ) : ?>
                                    <a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $product_name ); ?></a>
                                <?php else : ?>
                                    <?php echo wp_kses_post( $product_name . '&nbsp;' ); ?>
                                <?php endif; ?>
                            </h3>
                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                            <?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
                                <span class="kt-backorder"><?php esc_html_e( 'Available on backorder', 'kettletales' ); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="kt-cart-item-price">
                            <span class="kt-price-label"><?php esc_html_e( 'Price', 'kettletales' ); ?></span>
                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                        </div>

                        <div class="kt-cart-item-qty">
                            <span class="kt-price-label"><?php esc_html_e( 'Qty', 'kettletales' ); ?></span>
                            <?php
                            if ( $_product->is_sold_individually() ) {
                                $min_quantity = 1;
                                $max_quantity = 1;
                            } else {
                                $min_quantity = 0;
                                $max_quantity = $_product->get_max_purchase_quantity();
                            }
                            echo apply_filters( 'woocommerce_cart_item_quantity',
                                woocommerce_quantity_input( array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $max_quantity,
                                    'min_value'    => $min_quantity,
                                    'product_name' => $product_name,
                                ), $_product, false ),
                                $cart_item_key, $cart_item );
                            ?>
                        </div>

                        <div class="kt-cart-item-subtotal">
                            <span class="kt-price-label"><?php esc_html_e( 'Total', 'kettletales' ); ?></span>
                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                        </div>

                    </div>
                <?php endforeach; ?>

                <?php do_action( 'woocommerce_cart_contents' ); ?>
                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            </div>

            <div class="kt-cart-sidebar">

                <div class="kt-cart-actions-top">
                    <button type="submit" class="kt-update-btn" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'kettletales' ); ?>"><i class="fas fa-sync-alt"></i> <?php esc_html_e( 'Update Cart', 'kettletales' ); ?></button>
                </div>

                <?php if ( wc_coupons_enabled() ) : ?>
                    <div class="kt-cart-coupon">
                        <h3><i class="fas fa-tag"></i> <?php esc_html_e( 'Coupon Code', 'kettletales' ); ?></h3>
                        <div class="kt-coupon-row">
                            <input type="text" name="coupon_code" class="kt-coupon-input" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter coupon', 'kettletales' ); ?>" />
                            <button type="submit" class="kt-coupon-btn" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'kettletales' ); ?>"><i class="fas fa-check"></i></button>
                        </div>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php endif; ?>

                <div class="kt-cart-totals">
                    <h3><?php esc_html_e( 'Order Summary', 'kettletales' ); ?></h3>
                    <div class="kt-totals-table">
                        <div class="kt-totals-row">
                            <span><?php esc_html_e( 'Subtotal', 'kettletales' ); ?></span>
                            <span><?php wc_cart_totals_subtotal_html(); ?></span>
                        </div>
                        <?php if ( WC()->cart->needs_shipping() ) :
                            $method_label = '';
                            $method_cost  = '';
                            foreach ( WC()->cart->get_shipping_methods() as $method ) {
                                $method_label = $method->get_label();
                                $method_cost  = $method->get_cost();
                            }
                            $is_free = ( '' === $method_cost || 0 == $method_cost );
                            $customer = WC()->customer;
                            $dest_country = $customer->get_shipping_country();
                            $dest_state   = $customer->get_shipping_state();
                            $dest_city    = $customer->get_shipping_city();
                            $dest_postcode = $customer->get_shipping_postcode();
                        ?>
                            <div class="kt-totals-row">
                                <span><?php esc_html_e( 'Shipping', 'kettletales' ); ?></span>
                                <span class="kt-shipping-value"><?php echo $is_free ? esc_html__( 'Free', 'kettletales' ) : wc_price( $method_cost ); ?></span>
                            </div>
                            <?php if ( $dest_country ) : ?>
                                <div class="kt-shipping-dest">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php
                                    $parts = array();
                                    if ( $dest_city ) $parts[] = $dest_city;
                                    if ( $dest_state ) $parts[] = WC()->countries->states[ $dest_country ][ $dest_state ] ?? $dest_state;
                                    if ( $dest_postcode ) $parts[] = $dest_postcode;
                                    $parts[] = WC()->countries->countries[ $dest_country ] ?? $dest_country;
                                    echo esc_html( implode( ', ', $parts ) );
                                    ?>
                                    <a href="#" id="kt-toggle-shipping-calc" onclick="document.getElementById('kt-shipping-calculator').style.display=document.getElementById('kt-shipping-calculator').style.display==='block'?'none':'block';return false;"><i class="fas fa-map-marker-alt" style="margin-right:4px;"></i> <?php esc_html_e( 'Calculate shipping', 'kettletales' ); ?></a>
                                </div>
                            <?php endif; ?>
                            <div id="kt-shipping-calculator" style="display:none;" class="kt-shipping-calculator">
                                <?php woocommerce_shipping_calculator(); ?>
                            </div>
                        <?php endif; ?>
                        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                            <div class="kt-totals-row">
                                <span><?php echo esc_html( $fee->name ); ?></span>
                                <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <?php if ( WC()->cart->has_discount() ) : ?>
                            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                                <div class="kt-totals-row kt-discount-row">
                                    <span><i class="fas fa-tag" style="color:#b0cb1f;margin-right:4px;font-size:11px;"></i> <?php echo esc_html( strtoupper( $coupon->get_code() ) ); ?></span>
                                    <span class="kt-discount-amount">-<?php echo wp_kses_post( wc_price( WC()->cart->get_coupon_discount_amount( $code ) ) ); ?> <a href="<?php echo esc_url( add_query_arg( array( 'remove_coupon' => urlencode( $code ) ), wc_get_cart_url() ) ); ?>" class="kt-remove-coupon" title="<?php esc_attr_e( 'Remove', 'kettletales' ); ?>">&times;</a></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                                    <div class="kt-totals-row">
                                        <span><?php echo esc_html( $tax->label ); ?></span>
                                        <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="kt-totals-row">
                                    <span><?php echo esc_html( WC()->cart->get_tax_totals()['total']->label ); ?></span>
                                    <span><?php echo wp_kses_post( WC()->cart->get_tax_totals()['total']->formatted_amount ); ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

                        <div class="kt-totals-row kt-totals-grand">
                            <span><?php esc_html_e( 'Total', 'kettletales' ); ?></span>
                            <span><?php wc_cart_totals_order_total_html(); ?></span>
                        </div>
                    </div>

                    <div class="kt-cart-actions">
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kt-continue-shopping">
                            <i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Continue Shopping', 'kettletales' ); ?>
                        </a>
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="kt-proceed-btn">
                            <i class="fas fa-lock"></i> <?php esc_html_e( 'Proceed to Checkout', 'kettletales' ); ?>
                        </a>
                    </div>

                    <input type="hidden" name="woocommerce-cart-nonce" value="<?php echo esc_attr( wp_create_nonce( 'woocommerce-cart' ) ); ?>" />
                </div>
            </div>

        </div>
    </form>

    <?php do_action( 'woocommerce_after_cart_table' ); ?>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
