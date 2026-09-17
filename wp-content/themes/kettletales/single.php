<?php
/**
 * The template for displaying single posts
 *
 * @package KettleTales
 */

get_header();
?>

<main id="primary" class="site-main container py-5">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-5' ); ?>>
            <header class="entry-header mb-4">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                <div class="entry-meta text-muted">
                    <?php
                    kettletales_posted_on();
                    kettletales_posted_by();
                    ?>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail mb-4">
                    <?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kettletales' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <footer class="entry-footer mt-4">
                <?php
                $tags_list = get_the_tag_list( '<ul class="list-inline"><li class="list-inline-item">', '</li><li class="list-inline-item">', '</li></ul>' );
                if ( $tags_list ) {
                    printf( '<div class="tags-links mb-2">%s</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
                ?>
            </footer>
        </article>

        <?php
        the_post_navigation( array(
            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'kettletales' ) . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'kettletales' ) . '</span> <span class="nav-title">%title</span>',
        ) );

        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>

    <?php endwhile; ?>
</main>

<?php
get_footer();
