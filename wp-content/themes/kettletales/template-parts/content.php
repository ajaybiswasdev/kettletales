<?php
/**
 * Template for displaying posts
 *
 * @package KettleTales
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card mb-4 shadow-sm' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="d-block">
            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'card-img-top img-fluid' ) ); ?>
        </a>
    <?php endif; ?>

    <div class="card-body">
        <?php the_title( sprintf( '<h2 class="card-title h5"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <div class="card-text text-muted small mb-2">
            <?php
            kettletales_posted_on();
            kettletales_posted_by();
            ?>
        </div>

        <div class="card-text">
            <?php the_excerpt(); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn-outline-success btn-sm mt-2">
            <?php esc_html_e( 'Read more', 'kettletales' ); ?>
        </a>
    </div>
</article>
