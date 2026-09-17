<?php
/**
 * My Account Orders List
 *
 * @package KettleTales
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

$status_colors = array(
    'pending'    => array( 'bg' => '#fff3cd', 'color' => '#856404' ),
    'processing' => array( 'bg' => '#cce5ff', 'color' => '#004085' ),
    'on-hold'    => array( 'bg' => '#fff3cd', 'color' => '#856404' ),
    'completed'  => array( 'bg' => '#d4edda', 'color' => '#155724' ),
    'cancelled'  => array( 'bg' => '#f8d7da', 'color' => '#721c24' ),
    'refunded'   => array( 'bg' => '#e2e3e5', 'color' => '#383d41' ),
    'failed'     => array( 'bg' => '#f8d7da', 'color' => '#721c24' ),
);

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>
    <div class="kt-orders-list">
        <?php foreach ( $customer_orders->orders as $customer_order ) :
            $order = wc_get_order( $customer_order );
            $status = $order->get_status();
            $sc = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : $status_colors['processing'];
        ?>
            <div class="kt-order-card">
                <div class="kt-order-card-left">
                    <div class="kt-order-num">
                        <span class="kt-order-num-label"><?php esc_html_e( 'Order', 'kettletales' ); ?></span>
                        <span class="kt-order-num-value">#<?php echo esc_html( $order->get_order_number() ); ?></span>
                    </div>
                    <div class="kt-order-date"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></div>
                </div>
                <div class="kt-order-card-center">
                    <div class="kt-order-items-preview">
                        <?php foreach ( $order->get_items() as $item ) :
                            $product = $item->get_product();
                        ?>
                            <?php if ( $product && has_post_thumbnail( $product->get_id() ) ) : ?>
                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ); ?>" class="kt-order-thumb" alt="">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <span class="kt-order-count"><?php printf( esc_html( _n( '%d item', '%d items', $order->get_item_count(), 'kettletales' ) ), $order->get_item_count() ); ?></span>
                </div>
                <div class="kt-order-card-right">
                    <span class="kt-order-total"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
                    <span class="kt-order-status-badge" style="background:<?php echo esc_attr( $sc['bg'] ); ?>;color:<?php echo esc_attr( $sc['color'] ); ?>"><?php echo esc_html( wc_get_order_status_name( $status ) ); ?></span>
                </div>
                <div class="kt-order-card-action">
                    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="kt-ov-btn"><?php esc_html_e( 'View', 'kettletales' ); ?> <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

    <?php if ( 1 < $customer_orders->max_num_pages ) : ?>
        <div class="woocommerce-pagination">
            <?php if ( 1 !== $current_page ) : ?>
                <a class="kt-ov-btn" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'kettletales' ); ?></a>
            <?php endif; ?>
            <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                <a class="kt-ov-btn kt-ov-btn-primary" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'kettletales' ); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php else : ?>
    <div class="kt-wo-empty">
        <i class="fas fa-shopping-bag"></i>
        <p><?php esc_html_e( 'No orders have been made yet.', 'kettletales' ); ?></p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="kt-ov-btn kt-ov-btn-primary"><?php esc_html_e( 'Browse Shop', 'kettletales' ); ?></a>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
