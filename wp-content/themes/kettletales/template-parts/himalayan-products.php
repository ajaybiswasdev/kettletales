<?php
/**
 * Himalayan Products Grid - Dynamic from WooCommerce
 *
 * Shows all products except the featured one (shown in the section above).
 *
 * @package KettleTales
 */

$all_products = kettletales_get_products_by_category( 'himalayan-collection' );
if ( empty( $all_products ) ) {
    return;
}

$featured    = kettletales_get_featured_product( 'himalayan-collection' );
$featured_id = $featured ? $featured->get_id() : 0;

$products = array_filter( $all_products, function( $post ) use ( $featured_id ) {
    return $post->ID !== $featured_id;
} );

if ( empty( $products ) ) {
    return;
}
?>

<!-- HIMALAYAN PRODUCTS GRID -->
<section class="collection-section" id="collectionsList">
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
