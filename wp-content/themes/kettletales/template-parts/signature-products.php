<?php
/**
 * Signature / Assam Products Grid - Dynamic from WooCommerce
 *
 * @package KettleTales
 */

$products = kettletales_get_products_by_category( 'signature-collection' );
if ( empty( $products ) ) {
    return;
}
?>

<!-- SIGNATURE / ASSAM PRODUCTS -->
<section class="collection-section" id="collections2">
    <div class="container">
        <div class="row g-4">
            <?php foreach ( $products as $post ) :
                setup_postdata( $post );
                $product = wc_get_product( $post->ID );
                if ( ! $product ) continue;
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'woocommerce_thumbnail' );
                $img   = $thumb ? $thumb[0] : wc_placeholder_img_src( 'woocommerce_thumbnail' );
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url( $img ); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                            </a>
                            <?php echo kettletales_get_quick_add_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                        <div class="product-content">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <?php if ( $product->get_short_description() ) : ?>
                                <p><?php echo wp_kses_post( $product->get_short_description() ); ?></p>
                            <?php endif; ?>
                            <?php echo kettletales_get_weight_price_table( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
