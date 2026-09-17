<?php
/**
 * Wellness Collection Section
 *
 * @package KettleTales
 */

$featured  = kettletales_get_featured_product( 'wellness-collection' );
$subtitle  = get_theme_mod( 'wellness_subtitle', 'Collection' );
$heading   = get_theme_mod( 'wellness_heading', 'Thoughtfully crafted teas for everyday balance and wellbeing.' );
$well_text = get_theme_mod( 'wellness_text', 'Created for modern lifestyles, this collection features blends designed to support wellness goals—from calming chamomile or Tulsi-Lemon Green Tea and refreshing mint to antioxidant-rich green teas. Each blend combines carefully selected ingredients to create delicious, functional teas that can be enjoyed throughout the day.' );
?>

<!-- WELLNESS -->
<section class="section-part7" id="wellness">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <div class="section-title">
                    <h2><?php esc_html_e( 'Wellness', 'kettletales' ); ?></h2>
                    <span><?php echo esc_html( $subtitle ); ?></span>
                </div>
                <h3 class="collection-heading ps-0">
                    <?php echo wp_kses_post( $heading ); ?>
                </h3>
                <p><?php echo wp_kses_post( $well_text ); ?></p>
            </div>

            <div class="col-lg-5 offset-lg-1">
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
                                <h4><?php echo esc_html( $featured->get_name() ); ?></h4>
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
