<?php

if ( current_theme_supports( 'pure-gallery' ) ) {
      remove_shortcode( 'gallery' );
      add_shortcode( 'gallery', 'nzpure_gallery' );
      add_filter( 'use_default_gallery_style', '__return_null' );
}

/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from Pure
 * The number of columns must be a factor of 12.
 *
 * @link http://purecss.io/grids/
 */
function nzpure_gallery( $attr ) {
      $post = get_post();

      static $instance = 0;
      $instance++;

      if ( !empty( $attr[ 'ids' ] ) ) {
            if ( empty( $attr[ 'orderby' ] ) ) {
                  $attr[ 'orderby' ] = 'post__in';
            }
            $attr[ 'include' ] = $attr[ 'ids' ];
      }

      $output = apply_filters( 'post_gallery', '', $attr );

      if ( $output != '' ) {
            return $output;
      }

      if ( isset( $attr[ 'orderby' ] ) ) {
            $attr[ 'orderby' ] = sanitize_sql_orderby( $attr[ 'orderby' ] );
            if ( !$attr[ 'orderby' ] ) {
                  unset( $attr[ 'orderby' ] );
            }
      }

      extract( shortcode_atts( array(
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'id' => $post->ID,
            'itemtag' => '',
            'icontag' => '',
            'captiontag' => '',
            'columns' => 3,
            'size' => 'thumbnail',
            'include' => '',
            'exclude' => '',
            'link' => ''
                          ), $attr ) );

      $id = intval( $id );
      $columns = (24 % $columns == 0) ? $columns : 4;
      $grid = sprintf( 'pure-u-1 pure-u-sm-%1$s-24', 24 / $columns );

      if ( $order === 'RAND' ) {
            $orderby = 'none';
      }

      if ( !empty( $include ) ) {
            $_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                  $attachments[ $val->ID ] = $_attachments[ $key ];
            }
      } elseif ( !empty( $exclude ) ) {
            $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
      } else {
            $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
      }

      if ( empty( $attachments ) ) {
            return '';
      }

      if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment ) {
                  $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
            }
            return $output;
      }

      $unique = (get_query_var( 'page' )) ? $instance . '-p' . get_query_var( 'page' ) : $instance;
      $output = '<div class="gallery gallery-' . $id . '-' . $unique . '">';

      $i = 0;
      foreach ( $attachments as $id => $attachment ) {
            switch ( $link ) {
                  case 'file':
                        $image = wp_get_attachment_link( $id, $size, false, false );
                        break;
                  case 'none':
                        $image = wp_get_attachment_image( $id, $size, false, array( 'class' => 'thumbnail pure-img' ) );
                        break;
                  default:
                        $image = wp_get_attachment_link( $id, $size, true, false );
                        break;
            }
            $output .= ($i % $columns == 0) ? '<div class="pure-g">' : '';
            $output .= '<div class="' . $grid . '">' . $image;

            if ( trim( $attachment->post_excerpt ) ) {
                  $output .= '<div class="caption hidden">' . wptexturize( $attachment->post_excerpt ) . '</div>';
            }

            $output .= '</div>';
            $i++;
            $output .= ($i % $columns == 0) ? '</div>' : '';
      }

      $output .= ($i % $columns != 0 ) ? '</div>' : '';
      $output .= '</div>';

      return $output;
}

/**
 * Add class="thumbnail img-thumbnail" to attachment items
 */
function nzpure_attachment_link_class( $html ) {
      $html = str_replace( '<a', '<a class="thumbnail img-thumbnail"', $html );
      return $html;
}

/* add_filter( 'wp_get_attachment_link', 'nzpure_attachment_link_class', 10, 1 ); */

function nzpure_attachment_image_attributes( $attr ) {
      $attr[ 'class' ] = 'pure-img';
      return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'nzpure_attachment_image_attributes', 10, 1 );
