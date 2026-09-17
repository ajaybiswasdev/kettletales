<?php
/**
 * WooCommerce Reviews Tab Template - Custom Design
 *
 * @package KettleTales
 */

defined( 'ABSPATH' ) || exit;

$product_id = get_the_ID();
$product    = wc_get_product( $product_id );

if ( ! $product ) {
    return;
}

$reviews = get_comments( array(
    'post_id' => $product_id,
    'status'  => 'approve',
    'type'    => 'review',
) );

$averaging = 0;
$count     = count( $reviews );

if ( $count > 0 ) {
    $total = 0;
    foreach ( $reviews as $review ) {
        $total += (int) get_comment_meta( $review->comment_ID, 'rating', true );
    }
    $averaging = $total / $count;
}

$comment_post_ID = $product_id;
$action          = site_url( '/wp-comments-post.php' );
?>

<div id="reviews" class="kt-reviews">

    <div class="kt-reviews-header">
        <div class="kt-reviews-summary">
            <?php if ( $count > 0 ) : ?>
                <div class="kt-summary-score">
                    <span class="kt-score-number"><?php echo number_format( $averaging, 1 ); ?></span>
                    <span class="kt-score-label">out of 5</span>
                </div>
                <div class="kt-summary-stars">
                    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                        <span class="kt-star<?php echo $i <= round( $averaging ) ? ' filled' : ''; ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
                <p class="kt-summary-count"><?php echo esc_html( $count ); ?> <?php echo _n( 'review', 'reviews', $count, 'kettletales' ); ?></p>
            <?php else : ?>
                <div class="kt-summary-empty">
                    <p>No reviews yet</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="kt-reviews-cta">
            <button type="button" class="kt-write-review-btn" onclick="document.getElementById('kt_review_form').scrollIntoView({behavior:'smooth'})">
                Write a Review
            </button>
        </div>
    </div>

    <?php if ( $count > 0 ) : ?>
        <div class="kt-reviews-list">
            <?php foreach ( $reviews as $review ) :
                $rating    = (int) get_comment_meta( $review->comment_ID, 'rating', true );
                $date      = get_comment_date( 'M j, Y', $review->comment_ID );
                $name      = $review->comment_author;
                $initial   = strtoupper( mb_substr( $name, 0, 1 ) );
            ?>
                <div class="kt-review-item">
                    <div class="kt-review-avatar"><?php echo esc_html( $initial ); ?></div>
                    <div class="kt-review-body">
                        <div class="kt-review-top">
                            <div>
                                <span class="kt-review-name"><?php echo esc_html( $name ); ?></span>
                            </div>
                            <span class="kt-review-date"><?php echo esc_html( $date ); ?></span>
                        </div>
                        <div class="kt-review-stars">
                            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                                <span class="kt-star<?php echo $i <= $rating ? ' filled' : ''; ?>">&#9733;</span>
                            <?php endfor; ?>
                        </div>
                        <div class="kt-review-content">
                            <?php echo wp_kses_post( $review->comment_content ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div id="kt_review_form" class="kt-review-form-wrapper">
        <h3 class="kt-form-title">Add Your Review</h3>
        <p class="kt-form-note">Your email address will not be published. Required fields are marked <span class="required">*</span></p>

        <form id="commentform" class="kt-review-form" action="<?php echo esc_url( $action ); ?>" method="post">

            <div class="kt-form-group kt-rating-group">
                <label class="kt-form-label">Your Rating <span class="required">*</span></label>
                <div class="kt-star-rating-select">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star">&#9733;</label>
                </div>
            </div>

            <div class="kt-form-group">
                <label class="kt-form-label" for="comment">Your Review <span class="required">*</span></label>
                <textarea id="comment" name="comment" rows="5" required placeholder="Share your experience with this tea..."></textarea>
            </div>

            <div class="kt-form-row">
                <div class="kt-form-group">
                    <label class="kt-form-label" for="author">Name <span class="required">*</span></label>
                    <input type="text" id="author" name="author" required placeholder="Your name">
                </div>
                <div class="kt-form-group">
                    <label class="kt-form-label" for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Your email">
                </div>
            </div>

            <div class="kt-form-submit">
                <button type="submit" name="submit" class="kt-submit-btn">Submit Review</button>
            </div>

            <input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( $comment_post_ID ); ?>">
            <input type="hidden" name="comment_parent" value="0">
        </form>
    </div>

</div>
