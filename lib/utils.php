<?php

/* include_once 'soil/soil.php'; */

/**
 * Utility functions
 */
function is_element_empty( $element ) {
      $element = trim( $element );
      return !empty( $element );
}

// Tell WordPress to use searchform.php from the templates/ directory
function nzpure_get_search_form() {
      $form = '';
      locate_template( '/templates/searchform.php', true, false );
      return $form;
}

add_filter( 'get_search_form', 'nzpure_get_search_form' );

/**
 * Add page slug to body_class() classes if it doesn't exist
 */
function nzpure_body_class( $classes ) {
      // Add post/page slug
      if ( is_single() || is_page() && !is_front_page() ) {
            if ( !in_array( basename( get_permalink() ), $classes ) ) {
                  $classes[] = basename( get_permalink() );
            }
      }
      return $classes;
}

add_filter( 'body_class', 'nzpure_body_class' );
