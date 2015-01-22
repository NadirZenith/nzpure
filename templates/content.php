<article <?php post_class(); ?>>
      <header>
            <h2 class="entry-title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <?php get_template_part( 'templates/entry-meta' ); ?>
      </header>
      <div class="entry-summary pure-g">
            <?php
            if ( has_post_thumbnail() ) {
                  ?>
                  <div class="pure-u-1 pure-u-md-1-6 mt15">
                        <a href="<?php the_permalink(); ?>">
                              <?php
                              the_post_thumbnail();
                              ?>
                        </a>
                  </div>
                  <div class="pure-u-1 pure-u-md-5-6 pl15">
                        <?php the_excerpt(); ?>
                  </div>
                  <?php
            } else {
                  ?>
                  <div class="pure-u-1 pl15">
                        <?php the_excerpt(); ?>
                  </div>
                  <?php
            }
            ?>
</article>
