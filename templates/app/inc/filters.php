<?php
require_once {{CONSTANT}}_PATH_INC . '/filters/all.php';
require_once {{CONSTANT}}_PATH_INC . '/filters/image.php';
require_once {{CONSTANT}}_PATH_INC . '/filters/cf7.php';

add_action( 'pre_get_posts', '{{FUNCTION}}_archive_pre_get_posts' );
function {{FUNCTION}}_archive_pre_get_posts( $query ){

    if ( ! is_admin() && $query->is_main_query() && $query->is_archive() ) {
        $query->set( 'posts_per_page', 10 );
    }
}
