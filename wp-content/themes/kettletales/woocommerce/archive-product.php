<?php
/**
 * WooCommerce Archive Product Template
 *
 * @package KettleTales
 */

get_header( 'shop' );
?>

<main id="primary" class="site-main container py-5">
    <div class="woocommerce-wrapper">
        <?php if ( have_posts() ) : ?>

            <header class="woocommerce-products-header mb-4">
                <?php woocommerce_output_all_notices(); ?>

                <?php if ( apply_filters( 'woocommerce_shop_page_title', 'Shop' ) ) : ?>
                    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                <?php endif; ?>

                <?php do_action( 'woocommerce_before_shop_loop' ); ?>
            </header>

            <div class="row g-4">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php do_action( 'woocommerce_after_shop_loop' ); ?>

        <?php else : ?>
            <p><?php esc_html_e( 'No products found matching your selection.', 'kettletales' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer( 'shop' );
