<?php
/**
 * WooCommerce Variable Product Add to Cart Template
 *
 * @package KettleTales
 * @version 10.9.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; ?>">
    <?php do_action( 'woocommerce_before_variations_form' ); ?>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
    <?php else : ?>
        <div class="variations-wrapper variations">
            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                <div class="variations-row">
                    <div class="label">
                        <label><?php echo wp_kses_post( wc_attribute_label( $attribute_name ) ); ?></label>
                    </div>
                    <div class="value">
                        <div class="kt-pill-group" data-attribute="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
                            <?php foreach ( $options as $option ) : ?>
                                <button type="button" class="kt-pill" data-value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( wc_attribute_label( $attribute_name ) . ': ' . $option ); ?></button>
                            <?php endforeach; ?>
                        </div>
                        <select name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" style="display:none">
                            <option value=""><?php echo esc_html__( 'Choose an option', 'kettletales' ); ?></option>
                            <?php foreach ( $options as $option ) : ?>
                                <option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ( end( $attribute_keys ) === $attribute_name ) : ?>
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'kettletales' ) . '">' . esc_html__( 'Clear', 'kettletales' ) . '</a>' ) ); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php do_action( 'woocommerce_after_variations_table' ); ?>

        <div class="single_variation_wrap">
            <?php
            do_action( 'woocommerce_before_single_variation' );
            do_action( 'woocommerce_single_variation' );
            do_action( 'woocommerce_after_single_variation' );
            ?>
        </div>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
