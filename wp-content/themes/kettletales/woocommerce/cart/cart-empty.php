<?php
/**
 * Empty cart page — custom override
 *
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) ); ?>
		</a>
	</p>
<?php endif; ?>

<?php
$new_products = wc_get_products( array(
	'status'  => 'publish',
	'limit'   => 4,
	'orderby' => 'date',
	'order'   => 'DESC',
	'return'  => 'objects',
) );

if ( ! empty( $new_products ) ) : ?>
	<div class="kt-empty-cart-products">
		<h2><?php esc_html_e( 'New in store', 'kettletales' ); ?></h2>
		<div class="row g-4">
			<?php foreach ( $new_products as $product ) :
				$image_id  = $product->get_image_id();
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
				$permalink = $product->get_permalink();
			?>
				<div class="col-6 col-md-3">
					<div class="product-card">
						<a href="<?php echo esc_url( $permalink ); ?>" class="product-image-wrap">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
						</a>
						<div class="product-content">
							<h4><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h4>
							<div class="price"><?php echo $product->get_price_html(); ?></div>
							<?php echo kettletales_get_quick_add_html( $product ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
