<?php if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) : ?>

    <?php get_template_part( 'template-parts/footer-content' ); ?>

<?php else : ?>

    </div><!-- .page -->

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
