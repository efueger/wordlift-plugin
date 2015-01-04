<?php
/**
 * Shortcode to print the in-post navigator
 */

function wordlift_register_shortcode_navigator() {
    add_shortcode('wl-navigator', 'wordlift_shortcode_navigator');
}

function wordlift_shortcode_navigator_populate( $post_id ) {
    
    // add as first the most recent article in the same iptc category
    $related_posts = wl_iptc_get_most_recent_post_in_same_category( $post_id );
    if( isset( $related_posts->ID ) ) {
        $related_posts = array( $related_posts->ID );
    } else {
        $related_posts = array();
    }
    
    // get the related entities, and for each one retrieve the most recent post regarding it.
    $related_entities = wl_get_referenced_entity_ids( $post_id );
    foreach ( $related_entities as $rel_entity ) {
        
        // take the id of posts referencing the entity
        $referencing_posts = wl_get_referencing_posts( $rel_entity );
        
        // loop over them and take the first one which is not already in the $related_posts
        foreach ( $referencing_posts as $referencing_post ) {
            if( isset( $referencing_post->ID )
                    && !in_array( array( $referencing_post->ID, $rel_entity ), $related_posts )
                    && $referencing_post->ID != $post_id ) {
                $related_posts[] = array( $referencing_post->ID, $rel_entity );
                break;
            }
        }
    }
    
    return $related_posts;
}

function wl_get_the_post_thumbnail_src( $img ) {
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

function wordlift_shortcode_navigator() {

    // include mobifyjs on page
    wp_enqueue_script( 'slick-js', plugins_url( 'js-client/slick/slick.min.js', __FILE__ ) );
    wp_enqueue_style( 'slick-css', plugins_url( 'js-client/slick/slick.css', __FILE__ ) );
        
    // get the current post.
    $post = get_post( get_the_ID() );
    
    // get posts that will populate the navigator (criteria may vary, see function *wordlift_shortcode_navigator_populate*)
    $related_posts_and_entities = wordlift_shortcode_navigator_populate( $post->ID );
    
    // build the HTML
    $counter = 0;
    $content = '<div id="wl-navigator-widget">';
    foreach ( $related_posts_and_entities as $related_post_entity ) {
        
        $related_post_id = $related_post_entity[0];
        $related_post = get_post( $related_post_id );
        
        $thumb = wl_get_the_post_thumbnail_src( get_the_post_thumbnail( $related_post_id, 'medium' ) );
        if( empty( $thumb ) ) {
            $thumb = plugins_url( 'js-client/slick/missing-image-150x150.png', __FILE__ );
        }
        
        if( $counter == 0 || !isset( $related_post_entity[1] ) ) {
            // the first card is a post suggested by category
            $context_link = get_iptc_category_links( $related_post_id, true );
            $context_name = get_iptc_category_names( $related_post_id, true );
        } else {
            // the other cards are suggested by entities
            $context_link = get_permalink( $related_post_entity[1] );
            $context_name = get_post( $related_post_entity[1] )->post_name;
        }
        
        $content .= '<div class="wl-navigator-card">
            <div class="wl-navigator-lens" style="background-image:url(' . $thumb . ')">
                <span class="wl-navigator-trigger">
                    <a href="' . get_permalink( $related_post_id ) . '">' . $related_post->post_title . '</a>
                </span>
            </div>
            <div class="wl-navigator-context">
                <a href="' . $context_link . '">' . $context_name . '</a>
            </div>
        </div>';
        
        $counter+=1;
    }
    $content .= '</div>';

    // add js
    $content .= '<script>$=jQuery; $(document).ready(function(){

            // Some css fixing
            setTimeout( function() {
                $(".wl-navigator-lens").height( $(".wl-navigator-lens").width() );
            }, 500);
            setInterval( function(){
                $(".slick-prev, .slick-next").css("background", "gray");
            }, 500);
            
            // Launch navigator
            $("#wl-navigator-widget").slick({
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1
            });
        });
    </script>';
    
    return $content;
}

add_action( 'init', 'wordlift_register_shortcode_navigator');

