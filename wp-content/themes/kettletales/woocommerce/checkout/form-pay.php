<?php
/**
 * Pay for order form — Professional Design
 *
 * @package KettleTales
 * @version 10.9.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
?>

<div class="kt-pay-page">
    <div class="kt-pay-card">

        <div class="kt-pay-header">
            <div class="kt-pay-icon"><i class="fas fa-lock"></i></div>
            <h1><?php esc_html_e( 'Complete Your Payment', 'kettletales' ); ?></h1>
            <p><?php esc_html_e( 'Review your order and click Pay Now to complete your purchase.', 'kettletales' ); ?></p>
        </div>

        <div class="kt-pay-order-info">
            <div class="kt-pay-info-row">
                <span><?php esc_html_e( 'Order', 'kettletales' ); ?></span>
                <span>#<?php echo esc_html( $order->get_order_number() ); ?></span>
            </div>
            <div class="kt-pay-info-row">
                <span><?php esc_html_e( 'Date', 'kettletales' ); ?></span>
                <span><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
            </div>
            <div class="kt-pay-info-row">
                <span><?php esc_html_e( 'Payment', 'kettletales' ); ?></span>
                <span><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
            </div>
        </div>

        <div class="kt-pay-items">
            <?php if ( count( $order->get_items() ) > 0 ) : ?>
                <?php foreach ( $order->get_items() as $item_id => $item ) : ?>
                    <?php if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) continue; ?>
                    <div class="kt-pay-item">
                        <div class="kt-pay-item-name">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) ); ?>
                            <?php wc_display_item_meta( $item ); ?>
                        </div>
                        <div class="kt-pay-item-qty">&times;<?php echo esc_html( $item->get_quantity() ); ?></div>
                        <div class="kt-pay-item-price"><?php echo $order->get_formatted_line_subtotal( $item ); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ( $totals ) : ?>
            <div class="kt-pay-totals">
                <?php foreach ( $totals as $total ) : ?>
                    <div class="kt-pay-total-row <?php echo ( 'order_total' === $total['key'] ) ? 'kt-pay-total-grand' : ''; ?>">
                        <span><?php echo wp_kses_post( $total['label'] ); ?></span>
                        <span><?php echo wp_kses_post( $total['value'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form id="order_review" method="post">
            <?php do_action( 'woocommerce_pay_order_before_payment' ); ?>

            <?php if ( $order->needs_payment() ) : ?>
                <?php if ( ! empty( $available_gateways ) ) : ?>
                    <?php foreach ( $available_gateways as $gateway ) : ?>
                        <div class="kt-pay-gateway">
                            <?php wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) ); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>

            <div class="kt-pay-actions">
                <input type="hidden" name="woocommerce_pay" value="1" />
                <?php wc_get_template( 'checkout/terms.php' ); ?>
                <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>
                <div class="kt-pay-buttons-row">
                    <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="kt-pay-now-btn" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '"><i class="fas fa-lock"></i> ' . esc_html( $order_button_text ) . '</button>' ); ?>
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="kt-pay-cancel-btn">
                        <i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Cancel', 'kettletales' ); ?>
                    </a>
                </div>
                <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>
                <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
            </div>
        </form>

    </div>
</div>
