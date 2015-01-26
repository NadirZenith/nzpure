<?php

/**
 * Configuration values
 */
define( 'GOOGLE_ANALYTICS_ID', '' ); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)
define( 'PURE_RESPONSIVE', TRUE );

/**
 * Enable theme features
 */
//add_theme_support( 'soil-clean-up' );         // Enable clean up from Soil
//add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil
//add_theme_support( 'soil-nice-search' );      // Enable /?s= to /search/ redirect from Soil
add_theme_support( 'pure-gallery' );     // Enable pure thumbnails component on [gallery]
add_theme_support( 'jquery-cdn' );            // Enable to load jQuery from the Google CDN
add_theme_support( 'pure-cdn');            // Enable to load pure from yahoo cdn


if ( !defined( 'WP_ENV' ) ) {
      define( 'WP_ENV', 'production' );  // scripts.php checks for values 'production' or 'development'
}

/**
 * Add body class if sidebar is active
 */
function nzpure_sidebar_body_class( $classes ) {
      if ( nzpure_display_sidebar() ) {
            $classes[] = 'has-sidebar';
      }
      return $classes;
}

add_filter( 'body_class', 'nzpure_sidebar_body_class' );

/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function nzpure_display_sidebar() {
      static $display;

      if ( !isset( $display ) ) {
            $sidebar_config = new NzPure_Sidebar(
                      /**
                       * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
                       * Any of these conditional tags that return true won't show the sidebar
                       *
                       * To use a function that accepts arguments, use the following format:
                       *
                       * array('function_name', array('arg1', 'arg2'))
                       *
                       * The second element must be an array even if there's only 1 argument.
                       */
                      array(
                  'is_404',
                  'is_front_page'
                      ),
                      /**
                       * Page template checks (via is_page_template())
                       * Any of these page templates that return true won't show the sidebar
                       */ array(
                  'template-custom.php'
                      )
            );
            $display = apply_filters( 'nzpure/display_sidebar', $sidebar_config->display );
      }

      return $display;
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 */
if ( !isset( $content_width ) ) {
      $content_width = 1140;
}


/**
 * remove default sizes
 */
add_filter( 'intermediate_image_sizes', '__return_empty_array' );
