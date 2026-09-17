<?php
/**
 * Custom search form
 *
 * @package KettleTales
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'kettletales' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search&hellip;', 'kettletales' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="btn btn-outline-success"><?php esc_html_e( 'Search', 'kettletales' ); ?></button>
</form>
