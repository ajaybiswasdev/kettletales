<?php
/**
 * The template for displaying 404 pages
 *
 * @package KettleTales
 */

get_header();
?>

<main id="primary" class="site-main container py-5 text-center">
    <section class="error-404 not-found">
        <header class="page-header mb-4">
            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'kettletales' ); ?></h1>
        </header>

        <div class="page-content">
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'kettletales' ); ?></p>
            <?php get_search_form(); ?>
        </div>
    </section>
</main>

<?php
get_footer();
