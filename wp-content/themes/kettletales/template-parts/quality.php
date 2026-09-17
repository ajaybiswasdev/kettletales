<?php
/**
 * Quality & Sourcing Section
 *
 * @package KettleTales
 */

$cup_image  = get_theme_mod( 'quality_image', KETTLETALES_URI . '/assets/images/cup.png' );
$subtitle   = get_theme_mod( 'quality_subtitle', 'QUALITY & SOURCING' );
$heading    = get_theme_mod( 'quality_heading', 'From small farms to your cup!' );
$icons      = array(
    get_theme_mod( 'quality_icon_1', KETTLETALES_URI . '/assets/images/icon1.png' ),
    get_theme_mod( 'quality_icon_2', KETTLETALES_URI . '/assets/images/icon2.png' ),
    get_theme_mod( 'quality_icon_3', KETTLETALES_URI . '/assets/images/icon3-1.png' ),
    get_theme_mod( 'quality_icon_4', KETTLETALES_URI . '/assets/images/icon4.png' ),
    get_theme_mod( 'quality_icon_5', KETTLETALES_URI . '/assets/images/icon5.png' ),
);
$features   = array(
    get_theme_mod( 'quality_feature_1', 'Sourced from small holder tea farmers' ),
    get_theme_mod( 'quality_feature_2', 'Eco-friendly growing practices' ),
    get_theme_mod( 'quality_feature_3', 'Limited-batch harvesting' ),
    get_theme_mod( 'quality_feature_4', 'Freshly packed for maximum aroma' ),
    get_theme_mod( 'quality_feature_5', 'Selected batches quality-tested by accredited laboratories' ),
);
?>

<!-- QUALITY -->
<section class="quality-section" id="quality">
    <div class="quality-section-overlay">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 quality-section-top">
                <div class="image">
                    <img src="<?php echo esc_url( $cup_image ); ?>" alt="Quality Icon">
                </div>
                <div class="text-left">
                    <h5><?php echo esc_html( $subtitle ); ?></h5>
                    <h2><?php echo esc_html( $heading ); ?></h2>
                </div>
            </div>

            <div class="featureList d-flex justify-content-center justify-content-lg-between text-center gap-4 gap-lg-5 mt-5">
                <?php for ( $i = 0; $i < 5; $i++ ) :
                    if ( empty( $features[ $i ] ) ) continue;
                ?>
                <div class="feature">
                    <div class="feature-icon">
                        <img src="<?php echo esc_url( $icons[ $i ] ); ?>" alt="<?php echo esc_attr( $features[ $i ] ); ?>">
                    </div>
                    <p><?php echo esc_html( $features[ $i ] ); ?></p>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
