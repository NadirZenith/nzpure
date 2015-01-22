<div class="byline author vcard post-cate">
      <?php echo __( 'By', 'nzpure' ); ?> 
      <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author" class="fn">
            <?php echo get_the_author(); ?>
      </a>
      <?php echo __( 'on', 'nzpure' ); ?> 
      <time class="updated" datetime="<?php echo get_the_time( 'c' ); ?>">
            <?php echo get_the_date(); ?>
      </time>
      <?php
      if ( is_single() ) {
            ?>
            <div class="fr">

                  <?php
                  echo __( 'Category ', 'nzpure' );
                  the_category();
                  ?>
                  <?php
                  the_tags( __( 'Tags ', 'nzpure' ) );
                  ?>
            </div>
            <?php
      }
      ?> 
</div>