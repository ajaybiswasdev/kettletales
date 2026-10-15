/**
 * KettleTales Return Request System
 */
(function($) {
    'use strict';

    $(document).ready(function() {

        // Open modal on Return button click
        $(document).on('click', '.kt-return-btn', function() {
            var orderId = $(this).data('order');
            var products = $(this).data('products');

            // Set order ID
            $('#kt-return-order-id').val(orderId);

            // Populate product dropdown
            var $select = $('#kt-return-product');
            $select.find('option:not(:first)').remove();

            if (products && products.length) {
                $.each(products, function(i, p) {
                    $select.append(
                        $('<option>').val(p.id).text(p.name)
                    );
                });
            }

            // Reset form
            $('#kt-return-reason').val('');
            $('#kt-return-description').val('');
            $('#kt-return-photo').val('');
            $('#kt-return-photo-preview').hide();
            $('#kt-return-photo-upload').show();
            $('#kt-return-msg').hide();
            $('#kt-return-submit').prop('disabled', false);
            $('.kt-return-submit-text').show();
            $('.kt-return-submit-loading').hide();

            // Show modal
            $('#kt-return-modal').fadeIn(200);
            $('body').css('overflow', 'hidden');
        });

        // Close modal
        function closeReturnModal() {
            $('#kt-return-modal').fadeOut(200);
            $('body').css('overflow', '');
        }

        $(document).on('click', '.kt-return-close, .kt-return-cancel, .kt-return-modal-overlay', function() {
            closeReturnModal();
        });

        // ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#kt-return-modal').is(':visible')) {
                closeReturnModal();
            }
        });

        // Photo preview
        $(document).on('change', '#kt-return-photo', function() {
            var file = this.files[0];
            if (!file) return;

            // Validate size
            if (file.size > 5 * 1024 * 1024) {
                showReturnMsg('Photo must be under 5MB.', 'error');
                this.value = '';
                return;
            }

            // Validate type
            var allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            if (allowed.indexOf(file.type) === -1) {
                showReturnMsg('Only JPG, PNG, WEBP, or GIF images are allowed.', 'error');
                this.value = '';
                return;
            }

            // Preview
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#kt-return-preview-img').attr('src', e.target.result);
                $('#kt-return-photo-preview').show();
                $('#kt-return-photo-upload').hide();
                $('#kt-return-msg').hide();
            };
            reader.readAsDataURL(file);
        });

        // Remove photo
        $(document).on('click', '.kt-return-remove-photo', function() {
            $('#kt-return-photo').val('');
            $('#kt-return-photo-preview').hide();
            $('#kt-return-photo-upload').show();
        });

        // Submit form
        $(document).on('submit', '#kt-return-form', function(e) {
            e.preventDefault();

            var $form = $(this);
            var formData = new FormData(this);

            // Validate
            var productId = $('#kt-return-product').val();
            var reason = $('#kt-return-reason').val();

            if (!productId) {
                showReturnMsg('Please select a product.', 'error');
                return;
            }
            if (!reason) {
                showReturnMsg('Please select a reason.', 'error');
                return;
            }

            formData.set('product_id', productId);

            // Show loading
            $('#kt-return-submit').prop('disabled', true);
            $('.kt-return-submit-text').hide();
            $('.kt-return-submit-loading').show();
            $('#kt-return-msg').hide();

            $.ajax({
                url: kt_returns_ajax.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showReturnMsg(response.data.message, 'success');
                        // Disable form after success
                        $('#kt-return-form').find('select, textarea, input[type="file"]').prop('disabled', true);
                        $('.kt-return-submit, .kt-return-cancel').hide();

                        // Reload after 3 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    } else {
                        showReturnMsg(response.data.message, 'error');
                        $('#kt-return-submit').prop('disabled', false);
                        $('.kt-return-submit-text').show();
                        $('.kt-return-submit-loading').hide();
                    }
                },
                error: function() {
                    showReturnMsg('Something went wrong. Please try again.', 'error');
                    $('#kt-return-submit').prop('disabled', false);
                    $('.kt-return-submit-text').show();
                    $('.kt-return-submit-loading').hide();
                }
            });
        });

        function showReturnMsg(msg, type) {
            var $el = $('#kt-return-msg');
            $el.removeClass('success error').addClass(type).text(msg).fadeIn(200);
        }

    });
})(jQuery);
