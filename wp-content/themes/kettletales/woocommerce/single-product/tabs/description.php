<?php
/**
 * WooCommerce Description Tab Template
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

global $product;

$description = wc_format_content( $product->get_description() );

if ( ! $description ) {
    return;
}
?>

<div class="woocommerce-product-description">
    <?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
