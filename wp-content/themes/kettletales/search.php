<?php
/**
 * Template for displaying search results
 *
 * @package KettleTales
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
    <?php if ( have_posts() ) : ?>

        <header class="page-header mb-4">
            <h1 class="page-title">
                <?php
                printf(
                    /* translators: %s: search query */
                    esc_html__( 'Search Results for: %s', 'kettletales' ),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <?php get_template_part( 'template-parts/content', 'search' ); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => '&laquo; ' . esc_html__( 'Previous', 'kettletales' ),
            'next_text' => esc_html__( 'Next', 'kettletales' ) . ' &raquo;',
        ) ); ?>

    <?php else : ?>
        <p><?php esc_html_e( 'Nothing found. Try a different search term.', 'kettletales' ); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
