<?php

/**
 * Page titles
 */
function nzpure_title() {
      if ( is_home() ) {
            if ( get_option( 'page_for_posts', true ) ) {
                  return get_the_title( get_option( 'page_for_posts', true ) );
            } else {
                  return __( 'Latest Posts', 'nzpure' );
            }
      } elseif ( is_archive() ) {

            return post_type_archive_title( '', FALSE );
      } elseif ( is_search() ) {
            return sprintf( __( 'Search Results for %s', 'nzpure' ), get_search_query() );
      } elseif ( is_404() ) {
            return __( 'Not Found', 'nzpure' );
      } else {
            return get_the_title();
      }
}
