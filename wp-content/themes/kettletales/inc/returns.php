<?php
/**
 * KettleTales Returns & Refunds System
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

/**
 * Create custom returns table on activation
 */
function kettletales_create_returns_table() {
    // Quick check via option to avoid DB query on every load
    if ( get_option( 'kettletales_returns_table_created' ) === '1' ) {
        return;
    }

    global $wpdb;
    $table      = $wpdb->prefix . 'kettletales_returns';
    $charset    = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        order_id BIGINT(20) UNSIGNED NOT NULL,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        product_id BIGINT(20) UNSIGNED NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        reason VARCHAR(50) NOT NULL,
        description TEXT,
        photo_id BIGINT(20) UNSIGNED DEFAULT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        admin_note TEXT,
        refund_amount DECIMAL(10,2) DEFAULT 0,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id),
        KEY order_id (order_id),
        KEY user_id (user_id),
        KEY status (status)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
    update_option( 'kettletales_returns_table_created', '1' );
}
add_action( 'after_switch_theme', 'kettletales_create_returns_table' );
add_action( 'init', 'kettletales_create_returns_table' );

/**
 * Check if a return already exists for an order + product
 */
function kettletales_has_return_request( $order_id, $product_id = 0 ) {
    global $wpdb;
    $table = $wpdb->prefix . 'kettletales_returns';

    if ( $product_id ) {
        return $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$table} WHERE order_id = %d AND product_id = %d AND status IN ('pending','approved','shipped')",
            $order_id, $product_id
        ) );
    }

    return $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$table} WHERE order_id = %d AND status IN ('pending','approved','shipped')",
        $order_id
    ) );
}

/**
 * Get return status label + color
 */
function kettletales_get_return_status_info( $status ) {
    $statuses = array(
        'pending'  => array( 'label' => 'Pending Review', 'bg' => '#fff3cd', 'color' => '#856404' ),
        'approved' => array( 'label' => 'Approved',       'bg' => '#d4edda', 'color' => '#155724' ),
        'rejected' => array( 'label' => 'Rejected',       'bg' => '#f8d7da', 'color' => '#721c24' ),
        'shipped'  => array( 'label' => 'Product Shipped', 'bg' => '#cce5ff', 'color' => '#004085' ),
        'received' => array( 'label' => 'Product Received', 'bg' => '#e2e3e5', 'color' => '#383d41' ),
        'refunded' => array( 'label' => 'Refunded',        'bg' => '#d1ecf1', 'color' => '#0c5460' ),
    );
    return isset( $statuses[ $status ] ) ? $statuses[ $status ] : $statuses['pending'];
}

/**
 * Get all return requests for a user
 */
function kettletales_get_user_returns( $user_id ) {
    global $wpdb;
    $table = $wpdb->prefix . 'kettletales_returns';
    return $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM {$table} WHERE user_id = %d ORDER BY created_at DESC",
        $user_id
    ) );
}

/**
 * AJAX: Submit return request
 */
function kettletales_ajax_submit_return() {
    // Verify nonce
    if ( ! isset( $_POST['kt_return_nonce'] ) || ! wp_verify_nonce( $_POST['kt_return_nonce'], 'kt_return_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please try again.' ) );
    }

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Please login to request a return.' ) );
    }

    $order_id    = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
    $product_id  = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $reason      = isset( $_POST['reason'] ) ? sanitize_text_field( $_POST['reason'] ) : '';
    $description = isset( $_POST['description'] ) ? sanitize_textarea_field( $_POST['description'] ) : '';

    // Validate
    if ( ! $order_id || ! $product_id || empty( $reason ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    // Validate order belongs to user
    $order = wc_get_order( $order_id );
    if ( ! $order || $order->get_customer_id() !== get_current_user_id() ) {
        wp_send_json_error( array( 'message' => 'Invalid order.' ) );
    }

    // Check order is eligible (completed or processing, within 7 days)
    $status = $order->get_status();
    if ( ! in_array( $status, array( 'completed', 'processing', 'on-hold' ) ) ) {
        wp_send_json_error( array( 'message' => 'This order is not eligible for return.' ) );
    }

    // Check 7-day window from order completion
    $completed_date = $order->get_date_completed() ? $order->get_date_completed()->getTimestamp() : $order->get_date_created()->getTimestamp();
    if ( ( time() - $completed_date ) > ( 7 * DAY_IN_SECONDS ) ) {
        wp_send_json_error( array( 'message' => 'Return window has expired (7 days from delivery).' ) );
    }

    // Check if already requested
    if ( kettletales_has_return_request( $order_id, $product_id ) ) {
        wp_send_json_error( array( 'message' => 'A return request for this product already exists.' ) );
    }

    // Handle photo upload
    $photo_id = 0;
    if ( isset( $_FILES['return_photo'] ) && $_FILES['return_photo']['error'] === UPLOAD_ERR_OK ) {
        $allowed_types = array( 'image/jpeg', 'image/png', 'image/webp', 'image/gif' );
        $file_type     = wp_check_filetype( $_FILES['return_photo']['name'] );

        if ( ! in_array( $file_type['type'], $allowed_types ) ) {
            wp_send_json_error( array( 'message' => 'Only JPG, PNG, WEBP, or GIF images are allowed.' ) );
        }

        if ( $_FILES['return_photo']['size'] > 5 * MB_IN_BYTES ) {
            wp_send_json_error( array( 'message' => 'Photo must be under 5MB.' ) );
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $attachment_id = media_handle_upload( 'return_photo', 0 );
        if ( is_wp_error( $attachment_id ) ) {
            wp_send_json_error( array( 'message' => 'Photo upload failed: ' . $attachment_id->get_error_message() ) );
        }
        $photo_id = $attachment_id;
    }

    // Get product name
    $product = wc_get_product( $product_id );
    $product_name = $product ? $product->get_name() : 'Unknown Product';

    // Insert return request
    global $wpdb;
    $table = $wpdb->prefix . 'kettletales_returns';

    $result = $wpdb->insert( $table, array(
        'order_id'     => $order_id,
        'user_id'      => get_current_user_id(),
        'product_id'   => $product_id,
        'product_name' => $product_name,
        'reason'       => $reason,
        'description'  => $description,
        'photo_id'     => $photo_id,
        'status'       => 'pending',
        'created_at'   => current_time( 'mysql' ),
        'updated_at'   => current_time( 'mysql' ),
    ), array( '%d', '%d', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s' ) );

    if ( ! $result ) {
        wp_send_json_error( array( 'message' => 'Failed to submit return request. Please try again.' ) );
    }

    $return_id = $wpdb->insert_id;

    // Email to admin
    $admin_email = get_option( 'admin_email' );
    $subject = sprintf( 'New Return Request #%d for Order #%d', $return_id, $order_id );
    $message = sprintf(
        "A new return request has been submitted.\n\nReturn ID: #%d\nOrder: #%d\nProduct: %s\nReason: %s\nDescription: %s\n\nCustomer: %s (%s)\n\nManage: %s",
        $return_id,
        $order_id,
        $product_name,
        $reason,
        $description ? $description : 'N/A',
        wp_get_current_user()->display_name,
        get_userdata( get_current_user_id() )->user_email,
        admin_url( 'admin.php?page=kettletales-returns' )
    );
    wp_mail( $admin_email, $subject, $message );

    // Confirmation email to customer
    $customer_email = $order->get_billing_email();
    $customer_subject = sprintf( 'Return Request Received - Order #%d', $order_id );
    $customer_message = sprintf(
        "Dear %s,\n\nWe have received your return request for Order #%d.\n\nProduct: %s\nReason: %s\n\nOur team will review your request within 24-48 hours and get back to you.\n\nReturn Reference: #%d\n\nThank you,\nKettleTales Team",
        $order->get_billing_first_name(),
        $order_id,
        $product_name,
        $reason,
        $return_id
    );
    wp_mail( $customer_email, $customer_subject, $customer_message );

    wp_send_json_success( array(
        'message' => 'Return request submitted successfully! We will review it within 24-48 hours.',
        'return_id' => $return_id,
    ) );
}
add_action( 'wp_ajax_kt_submit_return', 'kettletales_ajax_submit_return' );
add_action( 'wp_ajax_nopriv_kt_submit_return', 'kettletales_ajax_submit_return' );

/**
 * AJAX: Upload return photo (separate endpoint for progress)
 */
function kettletales_ajax_upload_return_photo() {
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Please login.' ) );
    }
    wp_send_json_success( array( 'photo_id' => 0 ) );
}
add_action( 'wp_ajax_kt_upload_return_photo', 'kettletales_ajax_upload_return_photo' );

/**
 * Enqueue return request assets on My Account pages
 */
function kettletales_return_assets() {
    if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
        return;
    }

    wp_enqueue_style( 'kettletales-returns', KETTLETALES_URI . '/assets/css/returns.css', array(), KETTLETALES_VERSION );
    wp_enqueue_script( 'kettletales-returns', KETTLETALES_URI . '/assets/js/returns.js', array( 'jquery' ), KETTLETALES_VERSION, true );
    wp_localize_script( 'kettletales-returns', 'kt_returns_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'kt_return_action' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'kettletales_return_assets' );

/**
 * Include return modal on My Account pages
 */
function kettletales_include_return_modal() {
    if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
        return;
    }
    get_template_part( 'template-parts/return-modal' );
}
add_action( 'woocommerce_after_account_orders', 'kettletales_include_return_modal', 5 );
add_action( 'woocommerce_after_view_order', 'kettletales_include_return_modal', 5 );

/**
 * Build product data for each order (JSON for JS)
 */
function kettletales_return_order_products_json( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) return array();

    $products = array();
    foreach ( $order->get_items() as $item ) {
        $product = $item->get_product();
        $products[] = array(
            'id'   => $item->get_product_id(),
            'name' => $item->get_name() . ' × ' . $item->get_quantity(),
        );
    }
    return $products;
}

/**
 * Admin: Add menu page
 */
function kettletales_returns_admin_menu() {
    add_menu_page(
        'Return Requests',
        'Return Requests',
        'manage_woocommerce',
        'kettletales-returns',
        'kettletales_render_returns_admin_page',
        'dashicons-undo',
        56
    );

    // Add badge count
    add_filter( 'admin_menu', function( $menu ) {
        global $wpdb;
        $table = $wpdb->prefix . 'kettletales_returns';
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE status = 'pending'" );
        if ( $count > 0 ) {
            foreach ( $menu as $key => $item ) {
                if ( $item[2] === 'kettletales-returns' ) {
                    $menu[$key][0] .= ' <span class="awaiting-mod"><span class="pending-count">' . esc_html( $count ) . '</span></span>';
                    break;
                }
            }
        }
        return $menu;
    } );
}
add_action( 'admin_menu', 'kettletales_returns_admin_menu' );

/**
 * Admin: Render returns page
 */
function kettletales_render_returns_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'kettletales_returns';

    // Handle status update
    if ( isset( $_POST['kt_update_return'] ) && wp_verify_nonce( $_POST['kt_returns_nonce'], 'kt_returns_action' ) ) {
        $return_id = absint( $_POST['return_id'] );
        $new_status = sanitize_text_field( $_POST['new_status'] );
        $admin_note = sanitize_textarea_field( $_POST['admin_note'] );
        $refund_amount = isset( $_POST['refund_amount'] ) ? floatval( $_POST['refund_amount'] ) : 0;

        $allowed_statuses = array( 'pending', 'approved', 'rejected', 'shipped', 'received', 'refunded' );
        if ( in_array( $new_status, $allowed_statuses ) ) {
            $wpdb->update( $table, array(
                'status'        => $new_status,
                'admin_note'    => $admin_note,
                'refund_amount' => $refund_amount,
                'updated_at'    => current_time( 'mysql' ),
            ), array( 'id' => $return_id ), array( '%s', '%s', '%f', '%s' ), array( '%d' ) );

            // Get return details for email
            $return = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $return_id ) );
            if ( $return ) {
                $order = wc_get_order( $return->order_id );
                if ( $order ) {
                    $customer_email = $order->get_billing_email();
                    $status_info = kettletales_get_return_status_info( $new_status );

                    $status_messages = array(
                        'approved' => "Your return request for Order #{$return->order_id} has been APPROVED.\n\nPlease ship the product back to us. We will process your refund once we receive and inspect the product.\n\nReturn Reference: #{$return_id}",
                        'rejected' => "Your return request for Order #{$return->order_id} has been reviewed and unfortunately cannot be approved.\n\nReason: " . ( $admin_note ? $admin_note : 'Product is not eligible for return.' ) . "\n\nIf you have questions, please contact us at kettletales.info@gmail.com",
                        'refunded' => "Your refund of ₹{$refund_amount} for Order #{$return->order_id} has been processed.\n\nThe amount will reflect in your account within 5-7 business days.\n\nThank you for your patience.\n\nKettleTales Team",
                        'shipped'  => "We have received your shipped return for Order #{$return->order_id}.\n\nWe will inspect the product and process your refund shortly.\n\nKettleTales Team",
                        'received' => "We have received your returned product for Order #{$return->order_id}.\n\nWe will inspect it and process your refund within 2-3 business days.\n\nKettleTales Team",
                    );

                    if ( isset( $status_messages[ $new_status ] ) ) {
                        wp_mail( $customer_email, "Return Request Update - Order #{$return->order_id}", $status_messages[ $new_status ] );
                    }
                }
            }

            echo '<div class="notice notice-success is-dismissible"><p>Return request updated successfully.</p></div>';
        }
    }

    // Get filter
    $filter = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : 'all';

    if ( $filter === 'all' ) {
        $returns = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY created_at DESC" );
    } else {
        $returns = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$table} WHERE status = %s ORDER BY created_at DESC",
            $filter
        ) );
    }

    // Count by status
    $counts = $wpdb->get_results( "SELECT status, COUNT(*) as cnt FROM {$table} GROUP BY status", OBJECT_K );
    ?>
    <div class="wrap">
        <h1><span class="dashicons dashicons-undo"></span> Return Requests</h1>

        <!-- Status Tabs -->
        <nav class="nav-tab-wrapper">
            <a href="?page=kettletales-returns&status=all" class="nav-tab <?php echo $filter === 'all' ? 'nav-tab-active' : ''; ?>">
                All <span class="count">(<?php echo esc_html( count( $returns ) ); ?>)</span>
            </a>
            <?php
            $tabs = array(
                'pending'  => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'shipped'  => 'Shipped',
                'received' => 'Received',
                'refunded' => 'Refunded',
            );
            foreach ( $tabs as $key => $label ) :
                $cnt = isset( $counts[ $key ] ) ? $counts[ $key ]->cnt : 0;
            ?>
                <a href="?page=kettletales-returns&status=<?php echo esc_attr( $key ); ?>" class="nav-tab <?php echo $filter === $key ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html( $label ); ?> <span class="count">(<?php echo esc_html( $cnt ); ?>)</span>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php if ( empty( $returns ) ) : ?>
            <p style="margin-top:20px;color:#666;">No return requests found.</p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped" style="margin-top:15px">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Reason</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $returns as $ret ) :
                        $order = wc_get_order( $ret->order_id );
                        $user = get_userdata( $ret->user_id );
                        $status_info = kettletales_get_return_status_info( $ret->status );
                        $photo_url = $ret->photo_id ? wp_get_attachment_url( $ret->photo_id ) : '';
                    ?>
                        <tr>
                            <td><strong>#<?php echo esc_html( $ret->id ); ?></strong></td>
                            <td>
                                <?php if ( $order ) : ?>
                                    <a href="<?php echo esc_url( admin_url( 'post.php?post=' . $ret->order_id . '&action=edit' ) ); ?>">#<?php echo esc_html( $ret->order_id ); ?></a>
                                    <br><small><?php echo esc_html( $order->get_formatted_order_total() ); ?></small>
                                <?php else : ?>
                                    #<?php echo esc_html( $ret->order_id ); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $ret->product_name ); ?></td>
                            <td>
                                <?php echo esc_html( $user ? $user->display_name : 'Unknown' ); ?>
                                <br><small><?php echo esc_html( $user ? $user->user_email : '' ); ?></small>
                            </td>
                            <td>
                                <strong><?php echo esc_html( ucfirst( $ret->reason ) ); ?></strong>
                                <?php if ( $ret->description ) : ?>
                                    <br><small><?php echo esc_html( wp_trim_words( $ret->description, 15 ) ); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ( $photo_url ) : ?>
                                    <a href="<?php echo esc_url( $photo_url ); ?>" target="_blank">
                                        <img src="<?php echo esc_url( $photo_url ); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                    </a>
                                <?php else : ?>
                                    <em style="color:#999;">No photo</em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="background:<?php echo esc_attr( $status_info['bg'] ); ?>;color:<?php echo esc_attr( $status_info['color'] ); ?>;padding:3px 8px;border-radius:4px;font-size:12px;font-weight:600;">
                                    <?php echo esc_html( $status_info['label'] ); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html( mysql2date( 'M j, Y g:i A', $ret->created_at ) ); ?></td>
                            <td>
                                <button class="button button-small kt-manage-return" data-return="<?php echo esc_attr( $ret->id ); ?>">
                                    Manage
                                </button>
                            </td>
                        </tr>
                        <!-- Hidden manage form row -->
                        <tr id="kt-manage-row-<?php echo esc_attr( $ret->id ); ?>" style="display:none;background:#f0f6ff;">
                            <td colspan="9">
                                <form method="post" style="padding:15px;">
                                    <?php wp_nonce_field( 'kt_returns_action', 'kt_returns_nonce' ); ?>
                                    <input type="hidden" name="kt_update_return" value="1">
                                    <input type="hidden" name="return_id" value="<?php echo esc_attr( $ret->id ); ?>">
                                    <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap;">
                                        <div>
                                            <label><strong>Status:</strong></label><br>
                                            <select name="new_status" style="padding:5px;min-width:150px;">
                                                <?php foreach ( $tabs as $key => $label ) : ?>
                                                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $ret->status, $key ); ?>><?php echo esc_html( $label ); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label><strong>Refund Amount (₹):</strong></label><br>
                                            <input type="number" name="refund_amount" step="0.01" min="0" value="<?php echo esc_attr( $ret->refund_amount ); ?>" style="padding:5px;width:120px;">
                                        </div>
                                        <div style="flex:1;min-width:250px;">
                                            <label><strong>Admin Note (sent to customer):</strong></label><br>
                                            <textarea name="admin_note" rows="2" style="width:100%;padding:5px;"><?php echo esc_textarea( $ret->admin_note ); ?></textarea>
                                        </div>
                                        <div>
                                            <button type="submit" class="button button-primary" style="margin-top:20px;">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <style>
    .kt-manage-return{cursor:pointer}
    .nav-tab .count{background:rgba(0,0,0,.1);padding:1px 6px;border-radius:3px;margin-left:4px}
    </style>
    <script>
    jQuery(document).ready(function($) {
        $('.kt-manage-return').on('click', function() {
            var id = $(this).data('return');
            var row = $('#kt-manage-row-' + id);
            row.toggle();
        });
    });
    </script>
    <?php
}
