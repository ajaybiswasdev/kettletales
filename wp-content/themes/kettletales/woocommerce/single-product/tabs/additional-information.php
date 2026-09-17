<?php
/**
 * WooCommerce Additional Information Tab Template
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attributes = $product->get_attributes();
$weight_attr = null;

// Find the weight attribute
foreach ( $attributes as $attr ) {
    $name = wc_attribute_label( $attr->get_name() );
    if ( in_array( strtolower( $name ), array( 'weight', 'weights', 'size', 'sizes' ), true ) ) {
        $weight_attr = $attr;
        break;
    }
}
?>

<div class="woocommerce-product-attributes">
    <table class="woocommerce-product-attributes shop_attributes">
        <tbody>
            <?php if ( $weight_attr ) : ?>
                <tr>
                    <th><?php echo esc_html( wc_attribute_label( $weight_attr->get_name() ) ); ?></th>
                    <td>
                        <?php
                        $values = $weight_attr->get_options();
                        echo esc_html( implode( ', ', $values ) );
                        ?>
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ( $attributes as $attribute ) :
                if ( $weight_attr && $attribute->get_name() === $weight_attr->get_name() ) continue;
                if ( ! $attribute->is_visible() ) continue;
            ?>
                <tr>
                    <th><?php echo esc_html( wc_attribute_label( $attribute->get_name() ) ); ?></th>
                    <td>
                        <?php
                        $values = $attribute->is_taxonomy() ? wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) ) : $attribute->get_options();
                        echo esc_html( implode( ', ', $values ) );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
