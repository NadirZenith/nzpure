<?php

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.11.1.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/scripts.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */
function pure_scripts() {
      $template_directory_uri = get_template_directory_uri();

      /**
       * The build task in Grunt renames production assets with a hash
       * Read the asset names from assets-manifest.json
       */
      if ( WP_ENV === 'development' ) {
            $assets = array(
                  'main' => $template_directory_uri . '/assets/css/main.css',
                  'js' => $template_directory_uri . '/assets/js/scripts.js',
                  'pure' => $template_directory_uri . '/assets/vendor/pure/pure.css',
                  'pure-responsive' => $template_directory_uri . '/assets/vendor/pure/grids-responsive.css',
                  'pure-responsive-debug' => $template_directory_uri . '/assets/css/pure-responsive-debug.css',
                  'modernizr' => $template_directory_uri . '/assets/vendor/modernizr/modernizr.js',
                  'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js'
            );
            wp_enqueue_style( 'pure-responsive-debug', $assets[ 'pure-responsive-debug' ], array( 'pure-responsive' ) );
      } else {
            $get_assets = file_get_contents( $template_directory_uri . '/assets/manifest.json' );
            $assets = json_decode( $get_assets, true );
            $assets = array(
                  'main' => $template_directory_uri . '/assets/css/main.min.css?' . $assets[ 'assets/css/main.min.css' ][ 'hash' ],
                  'js' => $template_directory_uri . '/assets/js/scripts.min.js?' . $assets[ 'assets/js/scripts.min.js' ][ 'hash' ],
                  'pure' => $template_directory_uri . '/assets/vendor/pure/pure-min.css',
                  'pure-responsive' => $template_directory_uri . '/assets/vendor/pure/grids-responsive-min.css',
                  'modernizr' => $template_directory_uri . '/assets/js/vendor/modernizr.min.js',
                  'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'
            );
      }

      wp_enqueue_style( 'pure', $assets[ 'pure' ], false, null );

      if ( PURE_RESPONSIVE ) {
            wp_enqueue_style( 'pure-responsive', $assets[ 'pure-responsive' ], array( 'pure' ), null );
      }
      wp_enqueue_style( 'main', $assets[ 'main' ], array( 'pure' ), null );

      /**
       * jQuery is loaded using the same method from HTML5 Boilerplate:
       * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
       * It's kept in the header instead of footer to avoid conflicts with plugins.
       */
      if ( !is_admin() ) {

            if ( current_theme_supports( 'jquery-cdn' ) ) {
                  wp_deregister_script( 'jquery' );
                  wp_register_script( 'jquery', $assets[ 'jquery' ], array(), null, true );
                  add_filter( 'script_loader_src', 'pure_jquery_local_fallback', 10, 2 );
            }
            if ( current_theme_supports( 'pure-cdn' ) ) {
                  wp_deregister_style( 'pure' );
                  wp_enqueue_style( 'pure', 'http://yui.yahooapis.com/pure/0.5.0/pure-min.css' );

                  if ( PURE_RESPONSIVE ) {
                        wp_deregister_style( 'pure-responsive' );
                        wp_enqueue_style( 'pure-responsive', 'http://yui.yahooapis.com/pure/0.5.0/grids-responsive-min.css', array( 'pure' ) );
                  }
            }
      }

      if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
      }

      wp_enqueue_script( 'modernizr', $assets[ 'modernizr' ], array(), null, true );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'pure_js', $assets[ 'js' ], array(), null, true );
}

add_action( 'wp_enqueue_scripts', 'pure_scripts', 100 );

// http://wordpress.stackexchange.com/a/12450
function pure_jquery_local_fallback( $src, $handle = null ) {
      static $add_jquery_fallback = false;
      if ( $add_jquery_fallback ) {
            $base = get_template_directory_uri();
            if ( class_exists( 'Roots_Rewrites' ) ) {
                  $base = get_home_url();
            }
            echo '<script>window.jQuery || document.write(\'<script src="' . $base . '/assets/vendor/jquery/dist/jquery.min.js?1.11.1"><\/script>\')</script>' . "\n";
            $add_jquery_fallback = false;
      }

      if ( $handle === 'jquery' ) {
            $add_jquery_fallback = true;
      }

      return $src;
}

add_action( 'wp_head', 'pure_jquery_local_fallback' );

/**
 * Google Analytics snippet from HTML5 Boilerplate
 *
 * Cookie domain is 'auto' configured. See: http://goo.gl/VUCHKM
 */
function pure_google_analytics() {
      ?>
      <script>
      <?php if ( WP_ENV === 'production' ) : ?>
                  (function(b, o, i, l, e, r) {
                        b.GoogleAnalyticsObject = l;
                        b[l] || (b[l] =
                                function() {
                                      (b[l].q = b[l].q || []).push(arguments)
                                });
                        b[l].l = +new Date;
                        e = o.createElement(i);
                        r = o.getElementsByTagName(i)[0];
                        e.src = '//www.google-analytics.com/analytics.js';
                        r.parentNode.insertBefore(e, r)
                  }(window, document, 'script', 'ga'));
      <?php else : ?>
                  function ga() {
                        console.log('GoogleAnalytics: ' + [].slice.call(arguments));
                  }
      <?php endif; ?>
            ga('create', '<?php echo GOOGLE_ANALYTICS_ID; ?>', 'auto');
            ga('send', 'pageview');
      </script>

      <?php
}

if ( GOOGLE_ANALYTICS_ID && (WP_ENV !== 'production' || !current_user_can( 'manage_options' )) ) {
      add_action( 'wp_footer', 'pure_google_analytics', 20 );
}
