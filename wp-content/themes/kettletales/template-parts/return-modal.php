<?php
/**
 * Return Request Modal Template
 *
 * Loaded on My Account pages (Orders + View Order)
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

// Build product list for the current order (passed via JS data attributes)
?>
<div id="kt-return-modal" class="kt-return-modal" style="display:none;">
    <div class="kt-return-modal-overlay"></div>
    <div class="kt-return-modal-content">
        <div class="kt-return-modal-header">
            <h3><i class="fas fa-undo"></i> <?php esc_html_e( 'Request a Return', 'kettletales' ); ?></h3>
            <button type="button" class="kt-return-close">&times;</button>
        </div>
        <div class="kt-return-modal-body">
            <form id="kt-return-form" enctype="multipart/form-data">
                <?php wp_nonce_field( 'kt_return_action', 'kt_return_nonce' ); ?>
                <input type="hidden" name="action" value="kt_submit_return">
                <input type="hidden" name="order_id" id="kt-return-order-id" value="">
                <input type="hidden" name="product_id" id="kt-return-product-id" value="">

                <div class="kt-return-field">
                    <label for="kt-return-product"><?php esc_html_e( 'Product *', 'kettletales' ); ?></label>
                    <select name="product_select" id="kt-return-product" required>
                        <option value=""><?php esc_html_e( 'Select a product to return', 'kettletales' ); ?></option>
                    </select>
                </div>

                <div class="kt-return-field">
                    <label for="kt-return-reason"><?php esc_html_e( 'Reason for Return *', 'kettletales' ); ?></label>
                    <select name="reason" id="kt-return-reason" required>
                        <option value=""><?php esc_html_e( 'Select a reason', 'kettletales' ); ?></option>
                        <option value="damaged"><?php esc_html_e( 'Product arrived damaged', 'kettletales' ); ?></option>
                        <option value="wrong-product"><?php esc_html_e( 'Wrong product received', 'kettletales' ); ?></option>
                        <option value="not-as-described"><?php esc_html_e( 'Product not as described', 'kettletales' ); ?></option>
                        <option value="quality-issue"><?php esc_html_e( 'Quality issue', 'kettletales' ); ?></option>
                        <option value="expired"><?php esc_html_e( 'Product expired or near expiry', 'kettletales' ); ?></option>
                        <option value="changed-mind"><?php esc_html_e( 'Changed my mind', 'kettletales' ); ?></option>
                        <option value="other"><?php esc_html_e( 'Other', 'kettletales' ); ?></option>
                    </select>
                </div>

                <div class="kt-return-field">
                    <label for="kt-return-description"><?php esc_html_e( 'Description', 'kettletales' ); ?></label>
                    <textarea name="description" id="kt-return-description" rows="3"
                        placeholder="<?php esc_attr_e( 'Describe the issue in detail (optional but recommended)', 'kettletales' ); ?>"></textarea>
                </div>

                <div class="kt-return-field">
                    <label for="kt-return-photo"><?php esc_html_e( 'Photo of Product', 'kettletales' ); ?></label>
                    <div class="kt-return-photo-upload" id="kt-return-photo-upload">
                        <i class="fas fa-camera"></i>
                        <span><?php esc_html_e( 'Click to upload a photo', 'kettletales' ); ?></span>
                        <small><?php esc_html_e( 'JPG, PNG, WEBP or GIF (max 5MB)', 'kettletales' ); ?></small>
                        <input type="file" name="return_photo" id="kt-return-photo" accept="image/jpeg,image/png,image/webp,image/gif">
                    </div>
                    <div class="kt-return-photo-preview" id="kt-return-photo-preview" style="display:none;">
                        <img src="" alt="Preview" id="kt-return-preview-img">
                        <button type="button" class="kt-return-remove-photo">&times;</button>
                    </div>
                </div>

                <div class="kt-return-notice">
                    <i class="fas fa-info-circle"></i>
                    <span><?php esc_html_e( 'Returns are accepted within 7 days of delivery. Product must be unopened and in original packaging.', 'kettletales' ); ?></span>
                </div>

                <div class="kt-return-msg" id="kt-return-msg" style="display:none;"></div>

                <div class="kt-return-actions">
                    <button type="button" class="kt-return-cancel"><?php esc_html_e( 'Cancel', 'kettletales' ); ?></button>
                    <button type="submit" class="kt-return-submit" id="kt-return-submit">
                        <span class="kt-return-submit-text"><?php esc_html_e( 'Submit Return Request', 'kettletales' ); ?></span>
                        <span class="kt-return-submit-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i> <?php esc_html_e( 'Submitting...', 'kettletales' ); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
