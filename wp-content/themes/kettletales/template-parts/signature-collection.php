<?php
/**
 * Signature / Assam Collection Section
 *
 * @package KettleTales
 */

$subtitle = get_theme_mod( 'signature_subtitle', 'Collection' );
$heading  = get_theme_mod( 'signature_heading', 'Bold, malty and full-bodied teas from the small tea-growers primarily of Assam.' );
$image    = get_theme_mod( 'signature_image', KETTLETALES_URI . '/assets/images/img1.jpg' );
$text     = get_theme_mod( 'signature_text', 'Sourced from renowned Assam tea-growing regions, these teas are chosen for their depth, strength and signature malty richness. Whether enjoyed as a robust morning brew or a comforting cup throughout the day, every selection reflects the authentic character of Assam.' );
?>

<!-- SIGNATURE / ASSAM -->
<section class="assam-intro-section" id="assam">
    <div class="container">
        <div class="row">
            <!-- Left Content -->
            <div class="col-lg-6 fade-left">
                <div class="pe-5">
                    <div class="assam-title text-lg-start text-center">
                        <h2><?php esc_html_e( 'Signature', 'kettletales' ); ?></h2>
                        <span><?php echo esc_html( $subtitle ); ?></span>
                    </div>
                    <h3 class="assam-heading text-lg-start text-center">
                        <?php echo wp_kses_post( $heading ); ?>
                    </h3>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-6 fade-right">
                <div class="assam-image">
                    <img src="<?php echo esc_url( $image ); ?>" alt="Assam Tea Garden">
                </div>
                <p class="assam-description">
                    <?php echo wp_kses_post( $text ); ?>
                </p>
            </div>
        </div>
    </div>
</section>
