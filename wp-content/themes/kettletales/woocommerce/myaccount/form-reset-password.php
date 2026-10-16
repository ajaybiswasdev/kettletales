<?php
/**
 * Password Reset Form
 *
 * @package KettleTales
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="kt-reset-wrapper">
    <div class="kt-reset-card">
        <div class="kt-reset-icon">
            <i class="fas fa-key"></i>
        </div>
        <h2 class="kt-reset-title"><?php esc_html_e( 'Reset Your Password', 'kettletales' ); ?></h2>
        <p class="kt-reset-subtitle"><?php esc_html_e( 'Enter a new password below.', 'kettletales' ); ?></p>

        <form method="post" class="woocommerce-ResetPassword lost_reset_password">

            <?php do_action( 'woocommerce_reset_password_form' ); ?>

            <div class="kt-reset-field">
                <label for="password_1"><?php esc_html_e( 'New password', 'kettletales' ); ?> <span class="required">*</span></label>
                <div class="kt-input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-text" name="password_1" id="password_1" autocomplete="new-password" required>
                    <button type="button" class="kt-toggle-pass" data-target="password_1"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <div class="kt-reset-field">
                <label for="password_2"><?php esc_html_e( 'Re-enter new password', 'kettletales' ); ?> <span class="required">*</span></label>
                <div class="kt-input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="input-text" name="password_2" id="password_2" autocomplete="new-password" required>
                    <button type="button" class="kt-toggle-pass" data-target="password_2"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <input type="hidden" name="wc_reset_password" value="true" />

            <?php wp_nonce_field( 'reset_password', 'reset-password-nonce' ); ?>

            <button type="submit" class="kt-reset-btn">
                <i class="fas fa-check"></i> <?php esc_html_e( 'Save New Password', 'kettletales' ); ?>
            </button>

        </form>

        <div class="kt-reset-footer">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="kt-reset-back">
                <i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Back to My Account', 'kettletales' ); ?>
            </a>
        </div>
    </div>
</div>
