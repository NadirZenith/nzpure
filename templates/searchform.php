<form role="search" method="get" class="search-form pure-form pure-g" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="search-field pure-u-4-5" placeholder="<?php _e( 'Search', 'nzpure' ); ?> <?php bloginfo( 'name' ); ?>" required>
      <button type="submit" class="search-submit pure-button pure-u-1-5"><small><?php _e( 'Search', 'nzpure' ); ?></small></button>
</form>
