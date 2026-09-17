<?php
/**
 * WooCommerce Product Tabs Template
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( empty( $product_tabs ) ) {
    return;
}

$first = true;
?>

<div class="kt-tabs">
    <ul class="kt-tabs-nav">
        <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
            <li class="kt-tab-btn<?php echo $first ? ' active' : ''; ?>" data-tab="kt-<?php echo esc_attr( $key ); ?>">
                <?php echo esc_html( $product_tab['title'] ); ?>
            </li>
        <?php $first = false; endforeach; ?>
    </ul>

    <?php $first = true; ?>
    <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
        <div class="kt-tab-panel<?php echo $first ? ' active' : ''; ?>" id="kt-<?php echo esc_attr( $key ); ?>">
            <?php
            if ( isset( $product_tab['callback'] ) ) {
                call_user_func( $product_tab['callback'], $key, $product_tab );
            }
            ?>
        </div>
    <?php $first = false; endforeach; ?>
</div>
