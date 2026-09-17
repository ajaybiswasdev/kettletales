<?php
/**
 * WooCommerce Product Image Template (Single Product)
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();
$first_image    = reset( $attachment_ids );
$main_image     = $main_image_id ? wp_get_attachment_image_src( $main_image_id, 'woocommerce_single' ) : false;
?>

<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
    <div class="woocommerce-product-gallery__image main-product-image">
        <?php if ( $main_image ) : ?>
            <a href="<?php echo esc_url( $main_image[0] ); ?>" class="woocommerce-product-gallery__image-main" data-lightbox="true">
                <img src="<?php echo esc_url( $main_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr( $main_image[1] ); ?>" height="<?php echo esc_attr( $main_image[2] ); ?>" />
            </a>
        <?php else : ?>
            <img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'kettletales' ); ?>" />
        <?php endif; ?>
    </div>

    <?php if ( count( $attachment_ids ) > 0 ) : ?>
    <div class="woocommerce-product-gallery__thumbnails product-thumbnails">
        <?php
        // Main image thumbnail
        if ( $main_image ) :
            $thumb = wp_get_attachment_image_src( $main_image_id, 'thumbnail' );
        ?>
            <div class="woocommerce-product-gallery__image thumbnail active" data-index="0">
                <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>" />
            </div>
        <?php endif; ?>

        <?php foreach ( $attachment_ids as $index => $attachment_id ) :
            $thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
            $full  = wp_get_attachment_image_src( $attachment_id, 'woocommerce_single' );
            if ( ! $thumb ) continue;
        ?>
            <div class="woocommerce-product-gallery__image thumbnail" data-index="<?php echo esc_attr( $index + 1 ); ?>" data-full="<?php echo esc_url( $full[0] ); ?>">
                <img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php the_title_attribute(); ?>" />
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
