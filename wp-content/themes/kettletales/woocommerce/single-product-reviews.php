<?php
/**
 * Single Product Reviews - Custom Design
 *
 * @package KettleTales
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

$reviews = get_comments( array(
	'post_id' => $product->get_id(),
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
						<i class="fas fa-star<?php echo $i <= round( $averaging ) ? '' : '-o'; ?>"></i>
					<?php endfor; ?>
				</div>
				<p class="kt-summary-count"><?php echo esc_html( $count ); ?> <?php echo _n( 'review', 'reviews', $count, 'kettletales' ); ?></p>
			<?php else : ?>
				<div class="kt-summary-empty">
					<i class="fas fa-star-o"></i>
					<p>No reviews yet</p>
				</div>
			<?php endif; ?>
		</div>
		<div class="kt-reviews-cta">
			<button type="button" class="kt-write-review-btn" onclick="document.getElementById('review_form_wrapper').scrollIntoView({behavior:'smooth'})">
				Write a Review
			</button>
		</div>
	</div>

	<?php if ( $count > 0 ) : ?>
		<div class="kt-reviews-list">
			<?php foreach ( $reviews as $review ) :
				$rating  = (int) get_comment_meta( $review->comment_ID, 'rating', true );
				$date    = get_comment_date( 'M j, Y', $review->comment_ID );
				$name    = $review->comment_author;
				$initial = strtoupper( mb_substr( $name, 0, 1 ) );
			?>
				<div class="kt-review-item">
					<div class="kt-review-avatar"><?php echo esc_html( $initial ); ?></div>
					<div class="kt-review-body">
						<div class="kt-review-top">
							<span class="kt-review-name"><?php echo esc_html( $name ); ?></span>
							<span class="kt-review-date"><?php echo esc_html( $date ); ?></span>
						</div>
						<div class="kt-review-stars">
							<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
								<i class="fas fa-star<?php echo $i <= $rating ? '' : '-o'; ?>"></i>
							<?php endfor; ?>
						</div>
						<div class="kt-review-content">
							<?php echo wp_kses_post( $review->comment_content ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<p class="kt-no-reviews">There are no reviews yet.</p>
	<?php endif; ?>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form" class="kt-review-form-wrapper">
				<h3 class="kt-form-title">
					<?php
					if ( $count > 0 ) {
						esc_html_e( 'Add Your Review', 'kettletales' );
					} else {
						printf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'kettletales' ), esc_html( get_the_title() ) );
					}
					?>
				</h3>
				<p class="kt-form-note">Your email address will not be published. Required fields are marked <span class="required">*</span></p>

				<?php
				$commenter    = wp_get_current_commenter();
				$comment_post_ID = $product->get_id();
				$action          = site_url( '/wp-comments-post.php' );
				?>

				<form id="commentform" class="kt-review-form" action="<?php echo esc_url( $action ); ?>" method="post">

					<div class="kt-form-group kt-rating-group">
						<label class="kt-form-label">Your Rating <span class="required">*</span></label>
						<div class="kt-star-rating-select">
							<input type="radio" id="star5" name="rating" value="5"><label for="star5" title="Perfect">&#9733;</label>
							<input type="radio" id="star4" name="rating" value="4"><label for="star4" title="Good">&#9733;</label>
							<input type="radio" id="star3" name="rating" value="3"><label for="star3" title="Average">&#9733;</label>
							<input type="radio" id="star2" name="rating" value="2"><label for="star2" title="Not that bad">&#9733;</label>
							<input type="radio" id="star1" name="rating" value="1"><label for="star1" title="Very poor">&#9733;</label>
							<span class="kt-rating-label">Click to rate</span>
						</div>
					</div>

					<div class="kt-form-group">
						<label class="kt-form-label" for="comment">Your Review <span class="required">*</span></label>
						<textarea id="comment" name="comment" rows="5" required placeholder="Share your experience with this tea..."></textarea>
					</div>

					<div class="kt-form-row">
						<div class="kt-form-group">
							<label class="kt-form-label" for="author">Name <span class="required">*</span></label>
							<input type="text" id="author" name="author" required placeholder="Your name" value="<?php echo esc_attr( $commenter['comment_author'] ); ?>">
						</div>
						<div class="kt-form-group">
							<label class="kt-form-label" for="email">Email <span class="required">*</span></label>
							<input type="email" id="email" name="email" required placeholder="Your email" value="<?php echo esc_attr( $commenter['comment_author_email'] ); ?>">
						</div>
					</div>

					<div class="kt-form-submit">
						<button type="submit" name="submit" class="kt-submit-btn">Submit Review</button>
					</div>

					<input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( $comment_post_ID ); ?>">
					<input type="hidden" name="comment_parent" value="0">
					<?php wp_nonce_field( 'kettletales-review', 'kt-review-nonce' ); ?>
					<?php wp_nonce_field( 'unfiltered-html-comment', '_wp_unfiltered_html_comment_disabled', false ); ?>

				</form>
			</div>
		</div>
	<?php else : ?>
		<p class="kt-verification-required">Only logged in customers who have purchased this product may leave a review.</p>
	<?php endif; ?>

</div>
