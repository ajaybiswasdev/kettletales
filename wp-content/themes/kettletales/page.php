<?php
/**
 * The template for displaying all pages
 *
 * @package KettleTales
 */

if ( function_exists( 'is_woocommerce' ) && is_account_page() ) {
    get_header( 'shop' );
} else {
    get_header();
}
?>

<?php if ( function_exists( 'is_woocommerce' ) && is_account_page() ) : ?>

<main id="primary" class="site-main container py-5">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</main>

<?php else : ?>

<main id="primary" class="site-main container py-5">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
            <header class="entry-header mb-4">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kettletales' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <?php if ( get_edit_post_link() ) : ?>
                <footer class="entry-footer mt-4">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                /* translators: %s: post title */
                                __( 'Edit <span class="screen-reader-text">%s</span>', 'kettletales' ),
                                array( 'span' => array( 'class' => array() ) )
                            ),
                            get_the_title()
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer>
            <?php endif; ?>
        </article>

        <?php if ( comments_open() || get_comments_number() ) : ?>
            <?php comments_template(); ?>
        <?php endif; ?>

    <?php endwhile; ?>
</main>

<?php endif; ?>

<?php
if ( function_exists( 'is_woocommerce' ) && is_account_page() ) {
    get_footer( 'shop' );
} else {
    get_footer();
}
?>
