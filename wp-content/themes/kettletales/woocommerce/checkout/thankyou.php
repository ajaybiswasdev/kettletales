<?php
/**
 * Order Received (Thank You) Page
 *
 * @package KettleTales
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$order_id  = absint( get_query_var( 'order-received' ) );
$order_key = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';
$order     = wc_get_order( $order_id );

if ( ! $order || ! $order_key || $order->get_order_key() !== $order_key ) {
    return;
}
?>

<div class="kt-thankyou-page">

    <!-- Hero -->
    <div class="kt-ty-hero">
        <div class="kt-ty-check">
            <svg viewBox="0 0 52 52" width="64" height="64">
                <circle cx="26" cy="26" r="25" fill="none" stroke="#b0cb1f" stroke-width="2"/>
                <path fill="none" stroke="#b0cb1f" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M14 27l7 7 16-16"/>
            </svg>
        </div>
        <h1 class="kt-ty-heading"><?php esc_html_e( 'Order Received', 'kettletales' ); ?></h1>
        <p class="kt-ty-message"><?php esc_html_e( 'Thank you for shopping with us. Your account has been charged and your transaction is successful. We will be processing your order soon.', 'kettletales' ); ?></p>
    </div>

    <!-- Stats -->
    <div class="kt-ty-stats">
        <div class="kt-ty-stat">
            <div class="kt-ty-stat-icon"><i class="fas fa-hashtag"></i></div>
            <div>
                <span class="kt-ty-stat-label"><?php esc_html_e( 'Order', 'kettletales' ); ?></span>
                <span class="kt-ty-stat-val"><?php echo esc_html( $order->get_order_number() ); ?></span>
            </div>
        </div>
        <div class="kt-ty-stat">
            <div class="kt-ty-stat-icon"><i class="fas fa-calendar"></i></div>
            <div>
                <span class="kt-ty-stat-label"><?php esc_html_e( 'Date', 'kettletales' ); ?></span>
                <span class="kt-ty-stat-val"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
            </div>
        </div>
        <div class="kt-ty-stat">
            <div class="kt-ty-stat-icon"><i class="fas fa-envelope"></i></div>
            <div>
                <span class="kt-ty-stat-label"><?php esc_html_e( 'Email', 'kettletales' ); ?></span>
                <span class="kt-ty-stat-val"><?php echo esc_html( $order->get_billing_email() ); ?></span>
            </div>
        </div>
        <div class="kt-ty-stat">
            <div class="kt-ty-stat-icon"><i class="fas fa-credit-card"></i></div>
            <div>
                <span class="kt-ty-stat-label"><?php esc_html_e( 'Payment', 'kettletales' ); ?></span>
                <span class="kt-ty-stat-val"><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
            </div>
        </div>
        <div class="kt-ty-stat kt-ty-stat-total">
            <div class="kt-ty-stat-icon"><i class="fas fa-indian-rupee-sign"></i></div>
            <div>
                <span class="kt-ty-stat-label"><?php esc_html_e( 'Total', 'kettletales' ); ?></span>
                <span class="kt-ty-stat-val"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
            </div>
        </div>
    </div>

    <div class="kt-ty-grid">
        <!-- Order Items -->
        <div class="kt-ty-card">
            <h3 class="kt-ty-card-title"><i class="fas fa-box-open"></i> <?php esc_html_e( 'Order Details', 'kettletales' ); ?></h3>
            <table class="kt-ty-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Product', 'kettletales' ); ?></th>
                        <th><?php esc_html_e( 'Total', 'kettletales' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $order->get_items() as $item_id => $item ) :
                        $product = $item->get_product();
                    ?>
                        <tr>
                            <td>
                                <span class="kt-ty-item-name"><?php echo wp_kses_post( $item->get_name() ); ?> &times; <?php echo esc_html( $item->get_quantity() ); ?></span>
                                <?php if ( $item->get_meta( 'pa_weight' ) ) : ?>
                                    <span class="kt-ty-item-sku"><?php echo esc_html( $item->get_meta( 'pa_weight' ) ); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><?php esc_html_e( 'Subtotal', 'kettletales' ); ?></td>
                        <td><?php echo wp_kses_post( wc_price( $order->get_subtotal() ) ); ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Shipping', 'kettletales' ); ?></td>
                        <td><?php echo $order->get_shipping_total() > 0 ? wp_kses_post( wc_price( $order->get_shipping_total() ) ) : esc_html__( 'Free', 'kettletales' ); ?></td>
                    </tr>
                    <?php foreach ( $order->get_fees() as $fee ) : ?>
                        <tr>
                            <td><?php echo esc_html( $fee->get_name() ); ?></td>
                            <td><?php echo wp_kses_post( wc_price( $fee->get_total() ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong><?php esc_html_e( 'Total', 'kettletales' ); ?></strong></td>
                        <td><strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Addresses -->
        <div>
            <?php if ( $order->needs_shipping_address() ) : ?>
                <div class="kt-ty-card" style="margin-bottom:20px">
                    <h3 class="kt-ty-card-title"><i class="fas fa-truck"></i> <?php esc_html_e( 'Shipping Address', 'kettletales' ); ?></h3>
                    <address class="kt-ty-address"><?php echo wp_kses_post( $order->get_formatted_shipping_address() ); ?></address>
                    <?php if ( $order->get_billing_phone() ) : ?>
                        <div class="kt-ty-contact"><i class="fas fa-phone"></i> <?php echo esc_html( $order->get_billing_phone() ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="kt-ty-card">
                <h3 class="kt-ty-card-title"><i class="fas fa-file-invoice"></i> <?php esc_html_e( 'Billing Address', 'kettletales' ); ?></h3>
                <address class="kt-ty-address"><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></address>
                <?php if ( $order->get_billing_email() ) : ?>
                    <div class="kt-ty-contact"><i class="fas fa-envelope"></i> <?php echo esc_html( $order->get_billing_email() ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Note -->
    <div class="kt-ty-note">
        <i class="fas fa-info-circle"></i>
        <p><?php esc_html_e( 'Your order will be processed within 24 hours. You will receive an email confirmation with tracking details once your order has been shipped.', 'kettletales' ); ?></p>
    </div>

    <!-- Actions -->
    <div class="kt-ty-actions">
        <?php if ( $order->needs_payment() ) : ?>
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="kt-ty-btn kt-ty-btn-primary">
                <i class="fas fa-credit-card"></i> <?php esc_html_e( 'Pay Now', 'kettletales' ); ?>
            </a>
        <?php endif; ?>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kt-ty-btn kt-ty-btn-primary">
            <?php esc_html_e( 'Continue Shopping', 'kettletales' ); ?>
        </a>
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="kt-ty-btn kt-ty-btn-outline">
            <?php esc_html_e( 'View My Orders', 'kettletales' ); ?>
        </a>
    </div>

</div>
