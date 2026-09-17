<?php
/**
 * Himalayan Collection Section
 *
 * @package KettleTales
 */

$subtitle = get_theme_mod( 'himalayan_subtitle', 'Collection' );
$heading  = get_theme_mod( 'himalayan_heading', 'Elegant teas shaped by mountain air, rich soil, love and generations of craftsmanship.' );
$text     = get_theme_mod( 'himalayan_text', 'Handpicked from select Himalayan tea gardens known for their distinctive terroir, this collection showcases the region\'s finest expressions—from delicate first flushes to rich muscatel and roasted varieties. Carefully sourced and packed fresh, each tea captures the character and purity of the mountains.' );

$featured = kettletales_get_featured_product( 'himalayan-collection' );
?>

<!-- HIMALAYAN -->
<section class="himalayan-section" id="collections">
    <div class="leaf-img">
        <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/leaf.png' ); ?>" alt="">
    </div>
    <div class="container">
        <div class="row align-items-center">
            <!-- Content -->
            <div class="col-lg-7 fade-left">
                <div class="section-title">
                    <h2><?php esc_html_e( 'Himalayan', 'kettletales' ); ?></h2>
                    <span><?php echo esc_html( $subtitle ); ?></span>
                </div>
                <h3 class="collection-heading"><?php echo wp_kses_post( $heading ); ?></h3>
                <p class="collection-text"><?php echo wp_kses_post( $text ); ?></p>
            </div>

            <!-- Featured Product -->
            <div class="col-lg-5">
                <?php if ( $featured ) :
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $featured->get_id() ), 'full' );
                    $img   = $thumb ? $thumb[0] : wc_placeholder_img_src( 'full' );
                ?>
                <div class="featured-product fade-right">
                    <div class="row">
                        <div class="col-md-7 text-center">
                            <div class="product-image product-image-wrap">
                                <a href="<?php echo esc_url( $featured->get_permalink() ); ?>">
                                    <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $featured->get_name() ); ?>">
                                </a>
                                <?php echo kettletales_get_quick_add_html( $featured ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="product-content">
                                <h4><a href="<?php echo esc_url( $featured->get_permalink() ); ?>"><?php echo esc_html( $featured->get_name() ); ?></a></h4>
                                <?php if ( $featured->get_short_description() ) : ?>
                                    <p><?php echo wp_kses_post( $featured->get_short_description() ); ?></p>
                                <?php endif; ?>
                                <?php echo kettletales_get_weight_price_table( $featured ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
