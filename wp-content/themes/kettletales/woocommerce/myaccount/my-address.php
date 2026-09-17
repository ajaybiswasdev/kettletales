<?php
/**
 * My Addresses
 *
 * @package KettleTales
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'kettletales' ),
			'shipping' => __( 'Shipping address', 'kettletales' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'kettletales' ),
		),
		$customer_id
	);
}
?>

<div class="kt-addresses-page">
    <p class="kt-addr-intro"><?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'kettletales' ) ); ?></p>

    <div class="kt-addr-grid">
        <?php foreach ( $get_addresses as $name => $address_title ) :
            $address = wc_get_account_formatted_address( $name );
        ?>
            <div class="kt-addr-card">
                <div class="kt-addr-card-header">
                    <h3><i class="fas fa-<?php echo 'billing' === $name ? 'file-invoice' : 'truck'; ?>"></i> <?php echo esc_html( $address_title ); ?></h3>
                    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="kt-addr-edit">
                        <i class="fas fa-pen"></i> <?php printf( esc_html__( 'Edit %s', 'kettletales' ), '' ); ?>
                    </a>
                </div>
                <address class="kt-addr-card-body">
                    <?php
                    echo $address ? wp_kses_post( $address ) : esc_html__( 'You have not set up this type of address yet.', 'kettletales' );
                    do_action( 'woocommerce_my_account_after_my_address', $name );
                    ?>
                </address>
            </div>
        <?php endforeach; ?>
    </div>
</div>
