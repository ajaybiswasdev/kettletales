<?php
/**
 * Shipping Calculator - Custom Design
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' );
?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<section class="shipping-calculator-form" id="shipping-calculator-form">

		<div class="kt-calc-field">
			<label for="calc_shipping_country"><?php esc_html_e( 'Country / Region', 'kettletales' ); ?> <span class="required">*</span></label>
			<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
				<?php
				foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				}
				?>
			</select>
		</div>

		<div class="kt-calc-field">
			<label for="calc_shipping_state"><?php esc_html_e( 'State', 'kettletales' ); ?> <span class="required">*</span></label>
			<?php
			$current_cc = WC()->customer->get_shipping_country();
			$current_r  = WC()->customer->get_shipping_state();
			$states     = WC()->countries->get_states( $current_cc );

			if ( is_array( $states ) && ! empty( $states ) ) {
				?>
				<select name="calc_shipping_state" class="state_select" id="calc_shipping_state">
					<option value=""><?php esc_html_e( 'Select a state', 'kettletales' ); ?></option>
					<?php
					foreach ( $states as $ckey => $cvalue ) {
						echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
					}
					?>
				</select>
				<?php
			} else {
				?>
				<input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'Enter state', 'kettletales' ); ?>" />
				<?php
			}
			?>
		</div>

		<div class="kt-calc-row">
			<div class="kt-calc-field">
				<label for="calc_shipping_city"><?php esc_html_e( 'Town / City', 'kettletales' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" name="calc_shipping_city" id="calc_shipping_city" placeholder="<?php esc_attr_e( 'e.g. Kolkata', 'kettletales' ); ?>" />
			</div>
			<div class="kt-calc-field">
				<label for="calc_shipping_postcode"><?php esc_html_e( 'PIN Code', 'kettletales' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" placeholder="<?php esc_attr_e( 'e.g. 700001', 'kettletales' ); ?>" />
			</div>
		</div>

		<button type="submit" name="calc_shipping" value="1" class="button kt-calc-update-btn">
			<i class="fas fa-sync-alt"></i> <?php esc_html_e( 'Update', 'kettletales' ); ?>
		</button>

		<?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
