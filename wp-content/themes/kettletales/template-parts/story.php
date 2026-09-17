<?php
/**
 * Our Story Section
 *
 * @package KettleTales
 */

$image     = get_theme_mod( 'story_image', KETTLETALES_URI . '/assets/images/parallax_1.jpeg' );
$subtitle  = get_theme_mod( 'story_subtitle', 'The Story' );
$heading   = get_theme_mod( 'story_heading', 'Behind Every Brew!' );
$text_1    = get_theme_mod( 'story_text_1', 'From mist-covered tea gardens to your cup, every leaf is carefully selected and packed. Every harvest reflects generations of craftsmanship and dedication to quality.' );
$text_2    = get_theme_mod( 'story_text_2', 'We believe that great tea starts with the finest ingredients and the most careful preparation.' );
?>

<!-- STORY -->
<section class="story-section jarallax" id="story" data-speed="0.5">
    <div class="parallax-wrapper">
        <img src="<?php echo esc_url( $image ); ?>" class="parallax-bg jarallax-img" alt="Tea Garden">
    </div>
    <span class="story-section-overlay"></span>
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h5><?php echo esc_html( $subtitle ); ?></h5>
                <h2><?php echo esc_html( $heading ); ?></h2>
                <div class="pe-4">
                    <?php if ( $text_1 ) : ?>
                        <p><?php echo wp_kses_post( $text_1 ); ?></p>
                    <?php endif; ?>
                    <?php if ( $text_2 ) : ?>
                        <p><?php echo wp_kses_post( $text_2 ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
