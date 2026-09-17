<!-- HERO -->
<section class="hero-section" id="home">
    <div class="overlay">
        <span class="overlay-bg"></span>
        <?php
        $hero_video = get_theme_mod( 'hero_bg_video', KETTLETALES_URI . '/assets/images/Tea.mp4' );
        $hero_image = get_theme_mod( 'hero_bg_image', '' );

        if ( $hero_video ) :
        ?>
            <video autoplay muted loop playsinline class="bg-video">
                <source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
            </video>
        <?php elseif ( $hero_image ) : ?>
            <img src="<?php echo esc_url( $hero_image ); ?>" alt="" class="bg-video" style="object-fit:cover;">
        <?php endif; ?>
    </div>
    <div class="bannerCaption">
        <div class="container position-relative z-2 h-100">
            <div class="bannerCaptionInner">
                <div class="row h-100">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h1 class="hero-title">
                            <?php echo esc_html( get_theme_mod( 'hero_title', __( 'Every cup has a tale!', 'kettletales' ) ) ); ?>
                        </h1>

                        <p class="hero-desc">
                            <?php echo esc_html( get_theme_mod( 'hero_desc', __( 'Premium Himalayan Teas from Dooars, Darjeeling and Assam sourced from small growers, packed fresh and delivered across India. From delicate spring harvests to bold everyday brews, discover teas crafted for modern tea lovers.', 'kettletales' ) ) ); ?>
                        </p>

                        <div class="d-flex gap-2 flex-wrap quality-badges">
                            <?php
                            $badges = array(
                                get_theme_mod( 'hero_badge_1', __( 'Wellness & Lifestyle Products', 'kettletales' ) ),
                                get_theme_mod( 'hero_badge_2', __( 'Artisanal Gift Hampers', 'kettletales' ) ),
                                get_theme_mod( 'hero_badge_3', __( 'Small Farm Sourced', 'kettletales' ) ),
                                get_theme_mod( 'hero_badge_4', __( 'Freshly Packed', 'kettletales' ) ),
                                get_theme_mod( 'hero_badge_5', __( 'Quality Tested', 'kettletales' ) ),
                            );
                            foreach ( $badges as $badge ) {
                                if ( ! empty( $badge ) ) {
                                    echo '<span class="badge-custom">' . esc_html( $badge ) . '</span>';
                                }
                            }
                            ?>
                        </div>

                        <a href="<?php echo esc_url( get_theme_mod( 'hero_btn_link', '#collections' ) ); ?>" class="btn btn-shop">
                            <?php echo esc_html( get_theme_mod( 'hero_btn_text', __( 'Explore & Shop Teas', 'kettletales' ) ) ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
