<?php
/**
 * Footer Content
 *
 * @package KettleTales
 */

$logo          = get_theme_mod( 'footer_logo', KETTLETALES_URI . '/assets/images/TeaLabel_2.png' );
$about_heading = get_theme_mod( 'footer_about_heading', 'KettleTales tea presented by Craft&Weft' );
$about_text    = get_theme_mod( 'footer_about_text', '' );
$gst           = get_theme_mod( 'footer_gst', 'GST #19BGBPP6543H2Z4' );
$fssai_logo    = get_theme_mod( 'footer_fssai_logo', KETTLETALES_URI . '/assets/images/fssai-logo.png' );
$fssai_number  = get_theme_mod( 'footer_fssai_number', 'Licence #12824013000639' );
$phone_heading = get_theme_mod( 'footer_phone_heading', 'To order call us at' );
$phone_1       = get_theme_mod( 'footer_phone_1', '+918100219450' );
$phone_2       = get_theme_mod( 'footer_phone_2', '+917003678472' );
$email_1       = get_theme_mod( 'footer_email_1', 'kettletales2026@gmail.com' );
$email_2       = get_theme_mod( 'footer_email_2', 'craftnweft@gmail.com' );
$facebook      = get_theme_mod( 'footer_facebook', '#' );
$instagram     = get_theme_mod( 'footer_instagram', '#' );
$youtube       = get_theme_mod( 'footer_youtube', '#' );
$delivery_text = get_theme_mod( 'footer_delivery_text', 'Complimentary Delivery Within Kolkata and nearby | Subject to conditions' );
?>

<!-- FOOTER -->
<footer class="tea-footer" id="contact">
    <div class="tea-footer-top pb-5">
        <div class="container">
            <div class="row">

                <!-- Logo -->
                <div class="col-lg-2 col-md-12 text-center text-lg-start mb-4 mb-lg-0">
                    <img src="<?php echo esc_url( $logo ); ?>" alt="Kettle Tales" class="footer-logo">
                </div>

                <!-- About -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0 pt-5">
                    <h3><?php echo esc_html( $about_heading ); ?></h3>
                    <p><?php echo wp_kses_post( $about_text ); ?></p>
                    <p style="font-size: 12px;"><?php echo esc_html( $gst ); ?></p>
                    <div class="fssaiLogo pt-2">
                        <img src="<?php echo esc_url( $fssai_logo ); ?>" alt="fssai" style="max-width:100px; height:auto;"><br>
                        <?php echo esc_html( $fssai_number ); ?>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h5><?php echo esc_html( $phone_heading ); ?></h5>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/whatsapp.png' ); ?>" alt="Phone Icon" class="contact-icon">
                            <span class="d-flex flex-column">
                                <?php if ( $phone_1 ) : ?>
                                    <a href="tel:<?php echo esc_attr( str_replace( '+', '', $phone_1 ) ); ?>"><?php echo esc_html( $phone_1 ); ?></a>
                                <?php endif; ?>
                                <?php if ( $phone_2 ) : ?>
                                    <a href="tel:<?php echo esc_attr( str_replace( '+', '', $phone_2 ) ); ?>"><?php echo esc_html( $phone_2 ); ?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="contact-item mt-4">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/mail.png' ); ?>" alt="Email Icon" class="contact-icon">
                            <span class="d-flex flex-column">
                                <?php if ( $email_1 ) : ?>
                                    <a href="mailto:<?php echo esc_attr( $email_1 ); ?>"><?php echo esc_html( $email_1 ); ?></a>
                                <?php endif; ?>
                                <?php if ( $email_2 ) : ?>
                                    <a href="mailto:<?php echo esc_attr( $email_2 ); ?>"><?php echo esc_html( $email_2 ); ?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="footer-social">
                            <?php if ( $facebook ) : ?>
                                <a href="<?php echo esc_url( $facebook ); ?>"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ( $instagram ) : ?>
                                <a href="<?php echo esc_url( $instagram ); ?>"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ( $youtube ) : ?>
                                <a href="<?php echo esc_url( $youtube ); ?>"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- QR -->
                <div class="col-lg-3 col-md-6 text-center mb-4 mb-lg-0">
                    <p class="pt-3"><?php echo esc_html( $delivery_text ); ?></p>
                </div>

                <!-- Payment Icons -->
                <div class="col-lg-1 col-md-6 align-self-center">
                    <div class="payment-methods">
                        <div class="d-flex gap-3">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/social-1.jpg' ); ?>" alt="">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/social-3.jpg' ); ?>" alt="">
                        </div>
                        <div class="d-flex gap-3">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/social-2.jpg' ); ?>" alt="">
                            <img src="<?php echo esc_url( KETTLETALES_URI . '/assets/images/social-4.jpg' ); ?>" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="copyright-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center text-md-start">
                    <?php
                    printf(
                        /* translators: %1$s: copyright year, %2$s: site name */
                        esc_html__( 'Copyright &copy; %1$s %2$s, Craft&Weft. All Rights Reserved.', 'kettletales' ),
                        date( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>
