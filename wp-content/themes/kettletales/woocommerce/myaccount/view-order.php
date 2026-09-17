<?php
/**
 * View Order Page (My Account)
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

$status = $order->get_status();
$status_colors = array(
    'pending'    => array( 'bg' => '#fff3cd', 'color' => '#856404', 'icon' => 'fa-clock' ),
    'processing' => array( 'bg' => '#cce5ff', 'color' => '#004085', 'icon' => 'fa-spinner' ),
    'on-hold'    => array( 'bg' => '#fff3cd', 'color' => '#856404', 'icon' => 'fa-hourglass-half' ),
    'completed'  => array( 'bg' => '#d4edda', 'color' => '#155724', 'icon' => 'fa-check-circle' ),
    'cancelled'  => array( 'bg' => '#f8d7da', 'color' => '#721c24', 'icon' => 'fa-times-circle' ),
    'refunded'   => array( 'bg' => '#e2e3e5', 'color' => '#383d41', 'icon' => 'fa-undo' ),
    'failed'     => array( 'bg' => '#f8d7da', 'color' => '#721c24', 'icon' => 'fa-exclamation-circle' ),
);
$sc = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : $status_colors['processing'];
?>

<div class="kt-order-view">

    <!-- Header -->
    <div class="kt-ov-header">
        <div class="kt-ov-header-left">
            <h2><?php printf( esc_html__( 'Order #%s', 'kettletales' ), esc_html( $order->get_order_number() ) ); ?></h2>
            <span class="kt-ov-date"><?php printf( esc_html__( 'Placed on %s', 'kettletales' ), '<strong>' . wc_format_datetime( $order->get_date_created() ) . '</strong>' ); ?></span>
        </div>
        <div class="kt-ov-status" style="background:<?php echo esc_attr( $sc['bg'] ); ?>;color:<?php echo esc_attr( $sc['color'] ); ?>">
            <i class="fas <?php echo esc_attr( $sc['icon'] ); ?>"></i>
            <?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="kt-ov-stats">
        <div class="kt-ov-stat">
            <div class="kt-ov-stat-icon"><i class="fas fa-indian-rupee-sign"></i></div>
            <div>
                <span class="kt-ov-stat-label"><?php esc_html_e( 'Total', 'kettletales' ); ?></span>
                <span class="kt-ov-stat-value"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
            </div>
        </div>
        <div class="kt-ov-stat">
            <div class="kt-ov-stat-icon"><i class="fas fa-credit-card"></i></div>
            <div>
                <span class="kt-ov-stat-label"><?php esc_html_e( 'Payment', 'kettletales' ); ?></span>
                <span class="kt-ov-stat-value"><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
            </div>
        </div>
        <div class="kt-ov-stat">
            <div class="kt-ov-stat-icon"><i class="fas fa-truck"></i></div>
            <div>
                <span class="kt-ov-stat-label"><?php esc_html_e( 'Shipping', 'kettletales' ); ?></span>
                <span class="kt-ov-stat-value"><?php echo $order->get_shipping_total() > 0 ? wp_kses_post( wc_price( $order->get_shipping_total() ) ) : esc_html__( 'Free', 'kettletales' ); ?></span>
            </div>
        </div>
        <div class="kt-ov-stat">
            <div class="kt-ov-stat-icon"><i class="fas fa-box"></i></div>
            <div>
                <span class="kt-ov-stat-label"><?php esc_html_e( 'Items', 'kettletales' ); ?></span>
                <span class="kt-ov-stat-value"><?php echo esc_html( $order->get_item_count() ); ?></span>
            </div>
        </div>
    </div>

    <div class="kt-ov-grid">
        <!-- Order Items -->
        <div class="kt-ov-card">
            <h3 class="kt-ov-card-title"><i class="fas fa-box-open"></i> <?php esc_html_e( 'Order Details', 'kettletales' ); ?></h3>
            <table class="kt-ov-table">
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
                                <?php if ( $product ) : ?>
                                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="kt-ov-product-link">
                                        <?php if ( has_post_thumbnail( $product->get_id() ) ) : ?>
                                            <img src="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ); ?>" class="kt-ov-product-img" alt="">
                                        <?php endif; ?>
                                        <span class="kt-ov-item-name"><?php echo wp_kses_post( $item->get_name() ); ?> &times; <?php echo esc_html( $item->get_quantity() ); ?></span>
                                    </a>
                                <?php else : ?>
                                    <span class="kt-ov-item-name"><?php echo wp_kses_post( $item->get_name() ); ?> &times; <?php echo esc_html( $item->get_quantity() ); ?></span>
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
                    <tr class="kt-ov-total-row">
                        <td><strong><?php esc_html_e( 'Total', 'kettletales' ); ?></strong></td>
                        <td><strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Addresses -->
        <div class="kt-ov-addresses">
            <?php if ( $order->needs_shipping_address() ) : ?>
                <div class="kt-ov-card">
                    <h3 class="kt-ov-card-title"><i class="fas fa-truck"></i> <?php esc_html_e( 'Shipping Address', 'kettletales' ); ?></h3>
                    <address class="kt-ov-address"><?php echo wp_kses_post( $order->get_formatted_shipping_address() ); ?></address>
                    <?php if ( $order->get_billing_phone() ) : ?>
                        <div class="kt-ov-contact"><i class="fas fa-phone"></i> <?php echo esc_html( $order->get_billing_phone() ); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="kt-ov-card">
                <h3 class="kt-ov-card-title"><i class="fas fa-file-invoice"></i> <?php esc_html_e( 'Billing Address', 'kettletales' ); ?></h3>
                <address class="kt-ov-address"><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></address>
                <?php if ( $order->get_billing_email() ) : ?>
                    <div class="kt-ov-contact"><i class="fas fa-envelope"></i> <?php echo esc_html( $order->get_billing_email() ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="kt-ov-actions">
        <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="kt-ov-btn">
            <i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Back to Orders', 'kettletales' ); ?>
        </a>
        <?php if ( $order->needs_payment() ) : ?>
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="kt-ov-btn kt-ov-btn-primary">
                <i class="fas fa-credit-card"></i> <?php esc_html_e( 'Pay Now', 'kettletales' ); ?>
            </a>
        <?php endif; ?>
    </div>

</div>
