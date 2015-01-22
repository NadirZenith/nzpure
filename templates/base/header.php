<nav class="pure-menu pure-menu-open pure-menu-horizontal" role="navigation">
      <a class="pure-menu-heading" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
      <?php
      if ( has_nav_menu( 'primary_navigation' ) ) :
            wp_nav_menu( array( 'theme_location' => 'primary_navigation', 'walker' => new NzPure_Nav_Walker(), 'menu_class' => 'nav navbar-nav' ) );
      endif;
      ?>
</nav>
