<?php
/**
 * The front page template
 *
 * @package KettleTales
 */

get_header();
?>

    <?php get_template_part( 'template-parts/hero' ); ?>

    <?php get_template_part( 'template-parts/tea-slider' ); ?>

    <?php get_template_part( 'template-parts/himalayan-collection' ); ?>

    <?php get_template_part( 'template-parts/himalayan-products' ); ?>

    <?php get_template_part( 'template-parts/story' ); ?>

    <?php get_template_part( 'template-parts/signature-collection' ); ?>

    <?php get_template_part( 'template-parts/signature-products' ); ?>

    <?php get_template_part( 'template-parts/payment-parallax' ); ?>

    <?php get_template_part( 'template-parts/wellness-collection' ); ?>

    <?php get_template_part( 'template-parts/quality' ); ?>

    <?php get_template_part( 'template-parts/footer-content' ); ?>

<?php
get_footer();
