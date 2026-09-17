<?php
/**
 * Tea Slider - Dynamic from WooCommerce
 *
 * @package KettleTales
 */

$products = kettletales_get_all_products( 20 );
if ( empty( $products ) ) {
    return;
}
?>

<!-- TEA SLIDER -->
<section class="tea-slider z-3">
    <div class="container">
        <div class="tea-carousel">
            <?php foreach ( $products as $post ) :
                setup_postdata( $post );
                $product = wc_get_product( $post->ID );
                if ( ! $product ) continue;
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
                $img_url   = $thumbnail ? $thumbnail[0] : wc_placeholder_img_src( 'thumbnail' );
            ?>
                <div class="tea-item" data-product-id="<?php echo esc_attr( $post->ID ); ?>">
                    <a href="<?php the_permalink(); ?>" class="tea-item-link">
                        <div class="tea-image">
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <h6><?php the_title(); ?></h6>
                    </a>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
