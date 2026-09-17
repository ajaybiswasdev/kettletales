<?php
/**
 * WooCommerce Related Products Template
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

$related_ids = wc_get_related_products( $product->get_id(), $woocommerce_loop['columns'] );

if ( empty( $related_ids ) ) {
    return;
}

$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $woocommerce_loop['columns'],
    'post__in'       => $related_ids,
    'orderby'        => 'rand',
);

$related_query = new WP_Query( $args );

if ( $related_query->have_posts() ) :
?>
    <div class="related products">
        <div class="section-title text-center">
            <h2><?php esc_html_e( 'You May Also Like', 'kettletales' ); ?></h2>
        </div>
        <div class="row g-4">
            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                <div class="col-lg-4 col-md-6">
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php
    wp_reset_postdata();
endif;
