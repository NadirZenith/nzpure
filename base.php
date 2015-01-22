<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

      <?php get_template_part( 'templates/base/head' ); ?>

      <body <?php body_class(); ?>>

            <!--[if lt IE 8]>
              <div class="alert alert-warning">
            <?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'nzpure' ); ?>
              </div>
            <![endif]-->
            <header role="banner">
                  <?php
                  /* do_action( 'get_header' ); */
                  get_template_part( 'templates/base/header' );
                  ?>
            </header>

            <div id="site" class="group" role="document">
                  <main role="main">
                        <?php include nzpure_template_path(); ?>
                  </main>
                  <?php if ( nzpure_display_sidebar() ) : ?>
                        <aside role="complementary">
                              <?php include nzpure_sidebar_path(); ?>
                        </aside>
                  <?php endif; ?>
            </div>
            <footer role="contentinfo">
                  <?php get_template_part( 'templates/base/footer' ); ?>
            </footer>

            <?php wp_footer(); ?>

      </body>
</html>
