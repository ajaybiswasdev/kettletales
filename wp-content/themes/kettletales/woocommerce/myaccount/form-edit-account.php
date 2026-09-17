<?php
/**
 * My Account Account Details
 *
 * @package KettleTales
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="kt-account-details">
    <?php do_action( 'woocommerce_before_edit_account_form' ); ?>

    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

        <div class="kt-acct-grid">
            <!-- Account Info -->
            <div class="kt-ov-card">
                <h3 class="kt-ov-card-title"><i class="fas fa-user"></i> <?php esc_html_e( 'Account Info', 'kettletales' ); ?></h3>

                <div class="kt-acct-field">
                    <label for="account_first_name"><?php esc_html_e( 'First name', 'kettletales' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
                </div>

                <div class="kt-acct-field">
                    <label for="account_last_name"><?php esc_html_e( 'Last name', 'kettletales' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
                </div>

                <div class="kt-acct-field">
                    <label for="account_display_name"><?php esc_html_e( 'Display name', 'kettletales' ); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
                    <span class="kt-acct-hint"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'kettletales' ); ?></span>
                </div>

                <div class="kt-acct-field">
                    <label for="account_email"><?php esc_html_e( 'Email address', 'kettletales' ); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
                </div>
            </div>

            <!-- Password Change -->
            <div class="kt-ov-card">
                <h3 class="kt-ov-card-title"><i class="fas fa-lock"></i> <?php esc_html_e( 'Password Change', 'kettletales' ); ?></h3>

                <div class="kt-acct-field">
                    <label for="password_current"><?php esc_html_e( 'Current password', 'kettletales' ); ?></label>
                    <input type="password" class="woocommerce-Input input-text" name="password_current" id="password_current" autocomplete="current-password" />
                    <span class="kt-acct-hint"><?php esc_html_e( 'Leave blank to leave unchanged', 'kettletales' ); ?></span>
                </div>

                <div class="kt-acct-field">
                    <label for="password_1"><?php esc_html_e( 'New password', 'kettletales' ); ?></label>
                    <input type="password" class="woocommerce-Input input-text" name="password_1" id="password_1" autocomplete="new-password" />
                    <span class="kt-acct-hint"><?php esc_html_e( 'Leave blank to leave unchanged', 'kettletales' ); ?></span>
                </div>

                <div class="kt-acct-field">
                    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'kettletales' ); ?></label>
                    <input type="password" class="woocommerce-Input input-text" name="password_2" id="password_2" autocomplete="new-password" />
                </div>

                <?php do_action( 'woocommerce_edit_account_form' ); ?>

                <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>

                <button type="submit" class="woocommerce-Button button kt-acct-save" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'kettletales' ); ?>"><?php esc_html_e( 'Save changes', 'kettletales' ); ?></button>
            </div>
        </div>

        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
    </form>
</div>
