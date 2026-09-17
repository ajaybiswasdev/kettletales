<?php
/**
 * WooCommerce Product Content Template (Shop/Archive Card)
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

$product = wc_get_product( get_the_ID() );
if ( ! $product ) {
    return;
}
?>

<div class="product-card">
    <a href="<?php the_permalink(); ?>" class="product-image-wrap">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'shop-product-img' ) ); ?>
        <?php else : ?>
            <img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_thumbnail' ) ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'kettletales' ); ?>" class="shop-product-img" />
        <?php endif; ?>
    </a>
    <div class="product-content">
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="price"><?php echo $product->get_price_html(); ?></div>
        <?php echo kettletales_get_quick_add_html( $product ); ?>
    </div>
</div>
