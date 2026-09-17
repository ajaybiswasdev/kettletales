<?php
/**
 * WooCommerce Single Product Content Template
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) ) {
    return;
}

$categories = get_the_terms( get_the_ID(), 'product_cat' );
?>

<div class="single-product-wrapper">
    <div class="container">
        <nav class="woocommerce-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'kettletales' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'kettletales' ); ?></a>
            <span class="separator"> / </span>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Shop', 'kettletales' ); ?></a>
            <?php if ( $categories && ! is_wp_error( $categories ) ) :
                $cat = reset( $categories );
            ?>
                <span class="separator"> / </span>
                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
            <?php endif; ?>
            <span class="separator"> / </span>
            <span class="current"><?php the_title(); ?></span>
        </nav>
    </div>

    <div class="container">
        <div class="row single-product-content">
            <div class="col-lg-6 col-md-6 single-product-images-col">
                <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
            </div>

            <div class="col-lg-6 col-md-6 single-product-summary-col">
                <?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
                    <div class="product-cats">
                        <?php foreach ( $categories as $cat ) : ?>
                            <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="product-cat-badge"><?php echo esc_html( $cat->name ); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="summary entry-summary">
                    <?php do_action( 'woocommerce_single_product_summary' ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php wc_get_template( 'single-product/tabs/tabs.php' ); ?>
    </div>

    <?php
    $related_ids = wc_get_related_products( get_the_ID(), 3 );
    if ( $related_ids ) :
        $related_query = new WP_Query( array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'post__in'       => $related_ids,
            'orderby'        => 'rand',
        ) );
        if ( $related_query->have_posts() ) :
    ?>
    <div class="container related-products-section">
        <div class="section-title text-center">
            <h2><?php esc_html_e( 'You May Also Like', 'kettletales' ); ?></h2>
        </div>
        <div class="row g-4">
            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                <div class="col-lg-4 col-md-6">
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; endif; ?>
</div>
